<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Customer_retriever extends CI_Controller
{

    public function index()
    {

    }

    public function createCustomer()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->createCustomer($input_data);
        if ($result == true)
            $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => "customer created successfully ")));
        else
            $this->output->set_output(json_encode(array("statusMsg" => "fail", "data" => "customer already exists")));
    }

    public function getSimilarTpNumbers()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getSimilar($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result)));

    }

    public function getCustomer()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result)));

    }

    public function updateCustomer()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->updateCustomer($input_data["tp"], $input_data["data"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }

    public function addBooking()
    {
        $statusMsg = 'success';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $user = $this->session->userdata('user');

        $input_data["data"]["refId"] = $this->counters_dao->getNextId('reference');
        $input_data['data']['croId'] = $user['userId'];

        /* Set the date and time to UTC */
        $input_data["data"]["callTime"] = new MongoDate();
        $input_data["data"]["bookTime"] = new MongoDate(strtotime($input_data['data']['bDate'] . " " . $input_data["data"]['bTime']));

        /* Unset the values of bDate and bTime */
        unset($input_data['data']['bTime']);
        unset($input_data['data']['bDate']);

        $input_data["data"]["tp"] = $input_data["tp"];
        $customerProfile = $this->customer_dao->getCustomer($input_data['tp']);
        $input_data['data']['profileLinks'][] = $customerProfile['_id'];

        /* If it is a cooperate booking a personal profile also will be sent */
        if ($input_data['data']['personalProfileTp'] != '-') {
            $customerProfile2 = $this->customer_dao->getCustomer($input_data['data']['personalProfileTp']);
            $input_data['data']['profileLinks'][] = $customerProfile2['_id'];
        }

        $this->live_dao->createBooking($input_data["data"]);
        $this->customer_dao->addTotalJob($input_data["tp"]);

        $bookingCreated = $this->live_dao->getBooking($input_data['data']['refId']);
        $bookingObjId = array('_id' => $bookingCreated['_id']);
        /* Add the booking array to the customer collection */
        $this->customer_dao->addBooking($input_data["tp"], $bookingObjId);
        if(isset($customerProfile2)){
            $this->customer_dao->addBooking($customerProfile2['tp'],$bookingObjId);
        }

        $message = 'Your order has been confirmed. The booking number is ' . $input_data['data']['refId'] . '. Have a nice day';
        $this->sendSms($bookingCreated, $message);

        /* Send the newly added booking to the dispatch view */

        $webSocket = new Websocket('localhost', '5555', $user['userId']);
        $webSocket->send($bookingCreated, 'dispatcher1');
        $webSocket->send($bookingCreated, 'monitor1');

        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));
    }

    function sendSms($bookingCreated, $message)
    {
        $sms = new Sms();
        foreach ($bookingCreated['profileLinks'] as $item) {
            $customerProfile = $this->customer_dao->getCustomerByMongoObjId($item);
            if ($customerProfile['tp'] != '-') {
                $sms->send($customerProfile['tp'], $message);
            }
            if ($customerProfile['tp2'] != '-') {
                $sms->send($customerProfile['tp2'], $message);
            }
        }
    }

    public function canceled()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $user = $this->session->userdata('user');

        $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);
        $result = $bookingData['status'];

        if ($bookingData != null) {
            if ($result == ("MSG_COPIED") || $result == ("MSG_NOT_COPIED") || $result == ("AT_THE_PLACE") || $result == ("POB") || $result == ("POB")) {

                /* Adds +1 to the dis_cancel in customers collection */
                $this->customer_dao->addCanceledDispatch($input_data["tp"]);
                $this->live_dao->updateStatus($input_data['_id'], "DIS_CANCEL");

            } else if ($result == ("START")) {
                $this->live_dao->updateStatus($input_data['_id'], "CANCEL");
            }

            /* Adds +1 to the tot_cancel in customers collection */
            $this->customer_dao->addCanceledTotal($input_data["tp"]);
            /* Remove the record from live collection and add it to the history */
            $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);
            $this->live_dao->deleteBookingByMongoId($input_data['_id']);
            /* Add removed booking from live to the history collection */
            $this->history_dao->createBooking($bookingData);

            $message = 'Your booking ' . $input_data['data']['refId'] . '. has been canceled. Have a nice day';
            $this->sendSms($bookingData, $message);

            /* Send the canceled booking to the dispatch view */

            $webSocket = new Websocket('localhost', '5555', $user['userId']);
            $webSocket->send($bookingData, 'monitor1');
            $webSocket->send($bookingData, 'dispatcher1');

        }
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }

    public function updateBooking()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $user = $this->session->userdata('user');

        $input_data["data"]["bookTime"] = new MongoDate(strtotime($input_data['data']['bDate'] . " " . $input_data["data"]['bTime']));
        /* Unset the values of bDate and bTime */
        unset($input_data['data']['bTime']);
        unset($input_data['data']['bDate']);

        $this->live_dao->updateBooking($input_data["_id"], $input_data["data"]);
        $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);

        /* Send the updated booking to the dispatch view */
        $webSocket = new Websocket('localhost', '5555', $user['userId']);
        $webSocket->send($bookingData, 'monitor1');
        $webSocket->send($bookingData, 'dispatcher1');
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }

    public function getBooking()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getBooking($input_data["tp"], $input_data["refId"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result)));

    }

    public function addInquireCall()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->addInquireCall($input_data["tp"], $input_data["refId"]);
        $this->live_dao->addInquireCall($input_data["refId"]);

        /* TODO INFORM THROUGH WEB SOCKETS CHANGE HAS HAPPENED */
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }

    public function addCustomerToCooperateProfile()
    {
        $statusMsg = 'fail';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $cooperateProfile = $this->customer_dao->getCustomer($input_data["tp"]);
        $personalProfile = $this->customer_dao->getCustomer($input_data["userTp"]);

        if ($personalProfile != null) {
            $statusMsg = 'success';
            $customerObjId = array('_id' => $personalProfile['_id']);

            $cooperateProfile['personalProfiles'][] = $customerObjId;
        }
        $this->customer_dao->updateCustomer($input_data["tp"], $cooperateProfile);

        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));
    }
}