<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro_controller extends CI_Controller
{

    public function index()
    {
        if (is_user_logged_in() && $this->isUserRoleCRO()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/cro_main',$userData);
        }else{
            redirect('login', 'refresh');
        }

    }

    function isUserRoleCRO(){
        $userData = $this->session->userdata('user');
        if($userData['user_type'] == 'cro'){
            return true;
        }else{
            return false;
        }
    }

    function loadBookingsView(){

        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/bookings/bookings_main',$userData);
        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }
    }

    function loadMyBookingsView(){

        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/my_bookings/my_bookings_main',$userData);
        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }
    }

    function loadLocationBoardView(){

        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/non_editable_loc_board',$userData);
        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }
    }


    function loadMapView(){

        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/map/map_main',$userData);
        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }
    }

    function getTodayMyBookings(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        // TODO SET THE SESSION USERID AS PARAMETER
        $user = $this->session->userdata('user');
        $data = $this->live_dao->getCroBookingsToday($user['userId']);

        $data['booking_summary'] = $this->load->view('cro/my_bookings/booking_summary', $data , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getCustomerInfoEditView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data['tp']);

        $data['customer_info_edit_view'] = $this->load->view('cro/customer_info_edit', $result , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getEditBookingView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->live_dao->getBookingByMongoId($input_data['objId']);
        $data['edit_booking_view'] = $this->load->view('cro/edit_booking', $result , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCancelConfirmationView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);

        $data['cancel_confirmation_view'] = $this->load->view('cro/cancel_booking', $bookingData , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCustomerInfoView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data['tp']);

        if($result == null){
            $result =array('tp' => $input_data['tp']);
            $data['customer_info_view'] = $this->load->view('cro/new_customer_form', $result , TRUE);
            /* Customer is new so send empty to to the JOB Info View */
            $data['job_info_view'] = '';
            $data['new_booking_view'] = '';
            $data['booking_history_view']= '';
            $this->output->set_output(json_encode(array("statusMsg" => "fail","view" => $data)));
        }else{

            $bookingData=array('customerInfo' => $result);

            /* TODO ADD PABX DATA TO CALL TIME */
            $user = $this->session->userdata('user');
            $bookingData['callHistory'][] = array('callTime' => new MongoDate() , 'croId' => $user['userId']);
            $this->customer_dao->updateCustomer($input_data["tp"], $bookingData);

            foreach($result as $key => $value){
                if($key == 'history'){
                    foreach($value as $newKey){
                        $liveData = $this->live_dao->getBookingByMongoId($newKey['_id']);
                        if($liveData  != null){
                            /* Get Driver Details For the Booking */
                            if($liveData['driverId'] != '-'){
                                $user = $this->user_dao->getUserById($liveData['driverId']);
                                $liveData['driverTp'] = $user['tp'];
                            }else{
                                $liveData['driverTp']= '-';
                            }

                            /* Get Cab Details For the Booking */
                            if($liveData['cabId'] != '-'){
                                $cab = $this->cab_dao->getCab($liveData['cabId']);
                                $liveData['cabColor'] = $cab['color'];
                                $liveData['cabPlateNo'] = $cab['plateNo'];
                                $liveData['cabModel'] = $cab['model'];
                            }else{
                                $liveData['cabColor'] = '-';
                                $liveData['cabPlateNo'] = '-';
                                $liveData['cabModel'] = '-';
                            }
                            $bookingData['live_booking'][] = $liveData ;
                        }
                        $historyData = $this->history_dao->getBookingByMongoId($newKey['_id']);
                        if($historyData != null){

                            if($historyData ['driverId'] != '-'){
                                $user = $this->user_dao->getUserById($historyData ['driverId']);
                                $historyData ['driverTp'] = $user['tp'];
                            }else{
                                $historyData ['driverTp']= '-';
                            }

                            /* Get Cab Details For the Booking */
                            if($historyData['cabId'] != '-'){
                                $cab = $this->cab_dao->getCab($historyData['cabId']);
                                $historyData['cabColor'] = $cab['color'];
                                $historyData['cabPlateNo'] = $cab['plateNo'];
                                $historyData['cabModel'] = $cab['model'];
                            }else{
                                $historyData['cabColor'] = '-';
                                $historyData['cabPlateNo'] = '-';
                                $historyData['cabModel'] = '-';
                            }

                            $bookingData['history_booking'][] = $historyData ;
                        }
                    }
                }
            }

            if($result['profileType'] == 'Cooperate'){
                if(isset($result['personalProfiles'])){
                    foreach($result['personalProfiles'] as $personalProfileTp){
                        $userInfo = $this->customer_dao->getCustomerByObjId($personalProfileTp['_id']);
                        unset($userInfo['history']);
                        if($userInfo != null)
                        $result['userInfo'][] =$userInfo;
                    }
                }
            }

            $data['customer_info_view'] = $this->load->view('cro/customer_info', $result , TRUE);
            $data['job_info_view'] = $this->load->view('cro/job_info', $bookingData , TRUE);
            $data['new_booking_view'] = $this->load->view('cro/new_booking', $result , TRUE);
            $data['booking_history_view'] = $this->load->view('cro/booking_history', $bookingData , TRUE);
            $data['call_history_view'] = $this->load->view('cro/call_history', $bookingData , TRUE);
            $this->output->set_output(json_encode(array("statusMsg" => "success","important" => $bookingData ,"view" => $data)));
        }
    }
}