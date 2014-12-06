<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();

class Dispatcher extends CI_Controller
{

    public function index()
    {
        if (is_user_logged_in()) {
//			$session_data = is_user_logged_in();
//			$content_data = array('computer_number' => $session_data['computer_number'], 'full_name' => $session_data['full_name']);
//			$layout_data = array('title' => "Welcome to maps", 'content' => "maps/home", 'content_data' => $content_data);
//			$this -> load -> view('layouts/inner_layout', $layout_data);
            $new_orders = $this->live_dao->getNotDispatchedBookings();
            $dispatchedOrders = $this->live_dao->getDispatchedBookings();
            $new_orders_pane = $this->load->view("dispatcher/panels/new_orders", array('orders' => $new_orders, 'dispatchedOrders' => $dispatchedOrders), TRUE);
            $location_board_pane = $this->load->view("dispatcher/panels/locView_ver2", NULL, TRUE);

            $this->load->view('dispatcher/index', array('new_orders_pane' => $new_orders_pane, 'location_board_pane' => $location_board_pane));
        } else {
            //If no session, redirect to login page
            $this->load->library('form_validation');
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            redirect('login', 'refresh');
        }
    }

    public function get_coordinates()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('coordinate', "code");
            if ($this->input->post('firstTime')) {
                $query = $this->code->all_last_known_positions();
                $this->output->set_content_type('application/json')->set_output(json_encode($query->result()));
                return 0;
            }
            $query = $this->code->get_live_status();
            $this->output->set_content_type('application/json')->set_output(json_encode($query->result()));
        } else {
            echo "This method is not allowed";
        }
    }

    function newOrder($orderRefId)
    {
        if (!is_user_logged_in()) {
            show_404();
        };
        $newOrder = $this->live_dao->getBooking($orderRefId);
        $customerProfile = $this->customer_dao->getCustomerByMongoObjId($newOrder['profileLinks'][0]);
        $this->load->view('dispatcher/panels/new_order', array('newOrder' => $newOrder, 'customerProfile' => $customerProfile));

    }

    function disengageOrder($orderRefId)
    {
        if (!is_user_logged_in()) {
            show_404();
        };
        $newOrder = $this->live_dao->getBooking($orderRefId);
        $cab = $this->cab_dao->getCab($newOrder['cabId']);
        $newOrder['cab'] = $cab;
        $this->load->view('dispatcher/panels/disengage', array('newOrder' => $newOrder));

    }

    function dispatchVehicle()
    {
        $postData = $this->input->post();
        $cabId = $postData['cabId'];
        $orderId = $postData['orderId'];
        $dispatchingOrder = $this->live_dao->getBooking($orderId);
        $dispatchingDriver = $this->user_dao->getDriverByCabId($cabId);
        $driverId = $dispatchingDriver['userId'];
        $dispatchingCab = $this->cab_dao->setState($cabId, "MSG_NOT_COPIED");
        $cabZone = $dispatchingCab['zone'];
        $dispatchingCab = $this->cab_dao->setZone($cabId, "None");
        $dispatchingCab['driverId'] = $driverId;
//        $this->live_dao->deleteBooking($postData['refId']);
//        $customer = $this->customer_dao->getCustomer($dispatchingOrder['tp']); // TODO: need this when updating customer order history

        $sms = new Sms();

        $today = date("Y-m-d h:ia");
        $todayUTC = new MongoDate(strtotime($today));

        $custoMessage = "Cab No: $cabId Dispatched at: $today \nFrom $cabZone ,will reach you shortly\nRef. No: $dispatchingOrder[refId]\nDriver Mobile No: $dispatchingDriver[tp] \nPlate No: $dispatchingCab[plateNo] \nModel: $dispatchingCab[model] \nThank you for using Hao City Cabs: (011) 2 888 888";
        $custoNumber = $dispatchingOrder['tp'];
        $addressArray = array_values($dispatchingOrder['address']);
        $custoAddress = implode(" ", $addressArray);

        $this->live_dao->setDriverId($orderId, $driverId);
        $this->live_dao->setCabId($orderId, $cabId);
        $this->live_dao->updateStatus((string)$dispatchingOrder['_id'], "MSG_NOT_COPIED");
        $this->live_dao->setDispatchedTime($orderId);

        $driverId = strlen($driverId) <= 1 ? '0' . $driverId : $driverId;

        $sentCusto = $sms->send($custoNumber, $custoMessage);

        $custoNumber = $dispatchingOrder['isCusNumberNotSent'] ? '' : "\nCustomer number: $custoNumber";
        $pagingBoard = ($dispatchingOrder['pagingBoard'] != '-') ? "\nPaging Board: $dispatchingOrder[pagingBoard]" : '';

        $driverMessage = "#" . $driverId . '1' . $dispatchingOrder['refId'] . $custoNumber . $pagingBoard . "\nAddress: " . $custoAddress;
        $driverNumber = $dispatchingDriver['tp'];


        $sentDriver = $sms->send($driverNumber, $driverMessage);

        $user = $this->session->userdata('user');
        $webSocket = new Websocket('localhost', '5555', $user['userId']);
        $dispatchingOrder = $this->live_dao->getBooking($orderId); // Get the updated order
        $dispatchingOrder['driverTp'] = $driverNumber;
        $orderCro = $this->user_dao->getUser($dispatchingOrder['croId'], 'cro');
        $dispatchingOrder['cro'] = $orderCro;

        $webSocket->send($dispatchingOrder, 'monitor1');
        /*
         * get cust no from refid
         * get driver no from cab
         * send 2 sms to both
         *
         * */

//        $response = array('status'=> 'success', 'message' => 'Reference Id '.$postData['refId'].'Dispatched to '.$dispatchingOrder['address']);
        $this->output->set_content_type('application/json');
//        echo json_encode($response);
        echo json_encode($dispatchingOrder);
    }

    function cancelOrder()
    {
        $refId = $this->input->post('refId');
        $cancelReason = $this->input->post('cancelReason');

        $order = $this->live_dao->getBooking($refId);

        if ($order['status'] == 'START') {
            $alreadyDispatched = false;
            $this->live_dao->updateStatus($order['_id'], "CANCEL");
        } else {
            /* Adds +1 to the dis_cancel in customers collection */
            $alreadyDispatched = true;
            $this->customer_dao->addCanceledDispatch($order["tp"]);
            $this->live_dao->updateStatus($order['_id'], "DIS_CANCEL");
        }

        /* Adds +1 to the tot_cancel in customers collection */
        $this->customer_dao->addCanceledTotal($order["tp"]);

        $order = $this->live_dao->getBooking($refId);
        $this->live_dao->deleteBookingByMongoId($order['_id']);

        /* Add removed booking from live to the history collection */
        $order['cancelReason'] = $cancelReason;
        $this->history_dao->createBooking($order);

        /*
         * Cancel Message (Customer)
Your booking has been cancelled. Sorry for the inconvenience.
Ref. No:
Date:
Time:
Cancelled Reasons
Thank you for calling Hao City Cabs: 2 888 888
Cancelled Reasons (Driver)
Booking cancelled. Do not proceed to hire. Sorry for the inconvenience.
         * */
        $sms = new Sms();
        $date = date("Y-m-d");
        $time = date("h:ia");

        $custoMessage = "Your booking has been cancelled. Sorry for the inconvenience.\nRef. No: $refId\nDate: $date\nTime: $time\nReasons: $cancelReason\nThank you for calling Hao City Cabs: 2 888 888";
        $custoNumber = $order['tp'];
        $sentCusto = $sms->send($custoNumber, $custoMessage);
        if ($alreadyDispatched) {
            $driver = $this->user_dao->getUser($order['driverId'], 'driver');

            $driverMessage = "#" . $driver['userId'] . '2' . $order['refId'] . "Booking cancelled. Do not proceed to hire. Sorry for the inconvenience.\nReasons: $cancelReason";

            $driverNumber = $driver['tp'];
            $sentDriver = $sms->send($driverNumber, $driverMessage);

        }
        $user = $this->session->userdata('user');
        $webSocket = new Websocket('localhost', '5555', $user['userId']);
        $webSocket->send($order, 'monitor1');
    }


    function disengageCab()
    {
        $refId = $this->input->post('refId');
        $disengageReason = $this->input->post('disengageReason');
        $order = $this->live_dao->getBooking($refId);
        if (empty($order)) {
            $this->output->set_status_header(404, "Can't find refId" . $refId);
            return;
        }
        $this->live_dao->updateStatus((string)$order['_id'], "DISENGAGE");

        $order = $this->live_dao->getBooking($refId);

        $driver = $this->user_dao->getDriverByCabId($order['cabId']);
        $sms = new Sms();
        $driverMessage = "#" . $driver['userId'] . '2' . $order['refId'] . " Order has been disengaged. Do not proceed to hire. Sorry for the inconvenience.\nReason: $disengageReason";
        $driverNumber = $driver['tp'];
        $sentDriver = $sms->send($driverNumber, $driverMessage);


        $sms = new Sms();
        $date = date("Y-m-d");
        $time = date("h:ia");

        $custoMessage = "Vehicle has been disengaged. Another vehicle will reach you shortly. Sorry for the inconvenience.\nRef. No: $refId\nDate: $date\nTime: $time\nReasons: $disengageReason\nThank you for calling Hao City Cabs: 2 888 888";
        $custoNumber = $order['tp'];
        $sentCusto = $sms->send($custoNumber, $custoMessage);


        $user = $this->session->userdata('user');
        $webSocket = new Websocket('localhost', '5555', $user['userId']);
        $webSocket->send($order, 'monitor1');


        $this->output->set_content_type('application/json');
        echo json_encode($order);
    }

    function setIdleZone()
    {
        $cabId = $this->input->post('cabId');
        $zone = $this->input->post('zone');

        $cab = $this->cab_dao->getCab($cabId);
        $driver = $this->user_dao->getDriverByCabId($cabId);
        if ($cab != null) {


            $newCab = $this->cab_dao->setState($cabId, "IDLE");
            $newCab = $this->cab_dao->setZone($cabId, $zone);
            $newCab['userId'] = $driver['userId'];
            $newCab['lastZone'] = $cab['zone'];
            $this->output->set_content_type('application/json');
            echo json_encode($newCab);


        } else {
            $this->output->set_content_type('application/json');
            echo json_encode($cab);

        }

    }


    function setInactive()
    {

        $cabId = $this->input->post('cabId');
        $cab = $this->cab_dao->getCab($cabId);

        if ($cab != null) {
            $newCab = $this->cab_dao->setState($cabId, "IDLE");
            $newCab = $this->cab_dao->setZone($cabId, "None");
            $newCab['lastZone'] = $cab['zone'];
            $this->output->set_content_type('application/json');
            echo json_encode($newCab);

        } else {
            $this->output->set_content_type('application/json');
            echo json_encode($cab);

        }

    }


    function cabsInZones()
    {
        $result = $this->cab_dao->getCabsInZones();
        $this->output->set_content_type('application/json');
        echo json_encode($result);
    }

    function setPobDestinationZoneTime()
    {

        $cabId = $this->input->post('cabId');
        $zone = $this->input->post('zone');
        $cab = $this->cab_dao->getCab($cabId);
        $cabEta = $this->input->post('cabEta');

        $driver = $this->user_dao->getDriverByCabId($cabId);
        if ($cab != null) {
            $newCab = $this->cab_dao->setPobDestinationZoneTime($cabId, $zone, $cabEta);
            $newCab['userId'] = $driver['userId'];

            $newCab['lastZone'] = $cab['zone'];
            $this->output->set_content_type('application/json');
            echo json_encode($newCab);
        } else {
            $this->output->set_content_type('application/json');
            echo json_encode($cab);


        }

    }

    function setOtherState()
    {

        $cabId = $this->input->post('cabId');
        $zone = $this->input->post('zone');
        $cab = $this->cab_dao->getCab($cabId);
        $driver = $this->user_dao->getDriverByCabId($cabId);
        if ($cab != null) {

            $newCab = $this->cab_dao->setState($cabId, "OTHER");
            $newCab = $this->cab_dao->setZone($cabId, $zone);

            $newCab['userId'] = $driver['userId'];
            $newCab['lastZone'] = $cab['zone'];
            $this->output->set_content_type('application/json');
            echo json_encode($newCab);
        } else {
            $this->output->set_content_type('application/json');
            echo json_encode($cab);

        }

    }

    function delayInform()
    {
        $minutes = $this->input->post('minutes');
        $refId = $this->input->post('refId');

        $user = $this->session->userdata('user');
        $webSocket = new Websocket('localhost', '5555', $user['userId']);
        $delayInformOrder = $this->live_dao->getBooking($refId); // Get the updated order
        $delayInformOrder['delay_minutes'] = $minutes;
        $webSocket->send($delayInformOrder, 'cro1');

    }

    function cabDetails($cabId)
    {

        if (!is_user_logged_in()) {
            show_404();
        };
        $cab = $this->cab_dao->getCab($cabId);
        $driver = $this->user_dao->getUser($cab['userId'], 'driver');
        $this->load->view('dispatcher/panels/cab_details', array('cab' => $cab, 'driver' => $driver));

    }

    function search_cab()
    {
        $allCabs = $this->cab_dao->getAllCabs();
        $this->load->view('dispatcher/modals/search_cab', array('cabs' => $allCabs));
    }

    function dispatch_history()
    {
        $history_booking = $cab = $this->history_dao->getBookings();
        $this->load->view('dispatcher/modals/dispatch_history', array('history_booking' => $history_booking));
    }

    function search_cabs($query, $attribute)
    {
        $result = $this->cab_dao->find($query, $attribute);
        $this->output->set_content_type('application/json');
        echo json_encode($result);
    }

    function cancel_reason($orderRefId)
    {
        $cancelOrder = $this->live_dao->getBooking($orderRefId);
        $this->load->view('dispatcher/modals/cancel_reason', array('order' => $cancelOrder));
    }

    function disengage_reason($orderRefId)
    {
        $cancelOrder = $this->live_dao->getBooking($orderRefId);
        $this->load->view('dispatcher/modals/disengage_reason', array('order' => $cancelOrder));
    }

    function calling_number()
    {
        $drivers = $this->user_dao->getDriversSortedByCallingNumber();
        $this->load->view('dispatcher/modals/calling_number', array('data' => $drivers));
    }

    function  cab_start()
    {
        $drivers = $this->user_dao->getAllUsers_by_type('driver');
        $driversWithCab = array();
        foreach ($drivers['data'] as $driver) {
            if ($driver['cabId'] != -1) {
                $driverCab = $this->user_dao->getCabByDriverId($driver['userId']);
                $driver['cab'] = $driverCab;
                array_push($driversWithCab, $driver);
            }
//            else {
//                array_push($driversWithCab, $driver);
//            }
        }
        $this->load->view('dispatcher/modals/cab_start_location', array('data' => $driversWithCab));
    }

    function  logout_user(){
        $driverId = (int)$this->input->post('driverId');
        $status = $this->input->post('status');
        $status = ($status === "true");
        $updateData = array(
            'logout' => $status
        );
        $this->user_dao->updateUser($driverId,$updateData);

    }

//    function sendSms($bookingCreated, $message)
//    {
//        $sms = new Sms();
//        foreach ($bookingCreated['profileLinks'] as $item) {
//            $customerProfile = $this->customer_dao->getCustomerByMongoObjId($item);
//            if ($customerProfile['tp'] != '-') {
//                $sms->send($customerProfile['tp'], $message);
//            }
//            if ($customerProfile['tp2'] != '-') {
//                $sms->send($customerProfile['tp2'], $message);
//            }
//        }
//    }

}