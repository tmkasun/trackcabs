<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
session_start();
class Dispatcher extends CI_Controller {

	public function index() {
		if (is_user_logged_in()) {
//			$session_data = is_user_logged_in();
//			$content_data = array('computer_number' => $session_data['computer_number'], 'full_name' => $session_data['full_name']);
//			$layout_data = array('title' => "Welcome to maps", 'content' => "maps/home", 'content_data' => $content_data);
//			$this -> load -> view('layouts/inner_layout', $layout_data);
            $new_orders = $this->live_dao->getAllBookings();
            $new_orders_pane = $this->load->view("dispatcher/panels/new_orders",array('orders'=>$new_orders),TRUE);
            $location_board_pane = $this->load->view("dispatcher/panels/locView",NULL,TRUE);

            $this -> load -> view('dispatcher/index',array('new_orders_pane' => $new_orders_pane, 'location_board_pane' => $location_board_pane));
		} else {
			//If no session, redirect to login page
			$this -> load -> library('form_validation');
			$this -> form_validation -> set_message('check_database', 'Invalid username or password');
			redirect('login', 'refresh');
		}
	}

	public function get_coordinates() {
		if ($this -> input -> is_ajax_request()) {
			$this -> load -> model('coordinate', "code");
			if( $this -> input -> post('firstTime')){
				$query = $this -> code -> all_last_known_positions();
				$this -> output -> set_content_type('application/json') -> set_output(json_encode($query->result()));
				return 0;
			}
			$query = $this -> code -> get_live_status();
			$this -> output -> set_content_type('application/json') -> set_output(json_encode($query->result()));
		} else {
			echo "This method is not allowed";
		}
	}

    function newOrder($orderRefId){
        if(!is_user_logged_in()){
            show_404();
        };
        $newOrder = $this->live_dao->getBooking($orderRefId);
        $this -> load -> view('dispatcher/panels/new_order',array('newOrder' => $newOrder));

    }

    function dispatchVehicle(){
        $postData = $this->input->post();
        $cabId = $postData['cabId'];
        $orderId = $postData['orderId'];
        $dispatchingOrder = $this->live_dao->getBooking($orderId);
        $dispatchingDriver = $this->user_dao->getDriverByCabId($cabId);
        $driverId = $dispatchingDriver['userId'];
//        $this->live_dao->deleteBooking($postData['refId']);
//        $customer = $this->customer_dao->getCustomer($dispatchingOrder['tp']); // TODO: need this when updating customer order history

        $sms = new Sms();
        $custoMessage = "You order has been dispatched Order # $dispatchingOrder[refId]";
        $custoNumber = $dispatchingOrder['tp'];
        $addressArray = array_values($dispatchingOrder['address']);
        $custoAddress = implode(" ",$addressArray);

        $this->live_dao->setDriverId($orderId,$driverId);
        $this->live_dao->setCabId($orderId,$cabId);

        $driverId  = strlen($driverId) <= 1 ? '0'.$driverId : $driverId;
        $driverMessage = "#".$driverId.'1'.$dispatchingOrder['refId']." Address: ".$custoAddress;
        $driverNumber = $dispatchingDriver['tp'];

        $sentCusto = $sms->send($custoNumber,$custoMessage);
        $sentDriver = $sms->send($driverNumber,$driverMessage);

        /*
         * get cust no from refid
         * get driver no from cab
         * send 2 sms to both
         *
         * */

//        $response = array('status'=> 'success', 'message' => 'Reference Id '.$postData['refId'].'Dispatched to '.$dispatchingOrder['address']);
        $this -> output -> set_content_type('application/json');
//        echo json_encode($response);
        echo json_encode($dispatchingDriver);
    }

}