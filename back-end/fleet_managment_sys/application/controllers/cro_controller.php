<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro_controller extends CI_Controller
{

    public function index()
    {

    }

    function test()
    {
        //$prev_date = date('Y-m-d', strtotime(date('Y-m-d') .' -1 day'));
        $prev_date = date('Y-m-d');
        var_dump($prev_date);

        /* set the timezone for the call time */
        $bookDT = new DateTime(date($prev_date). ''.date('00:00:00'), new DateTimeZone('UTC'));
        $bookTS = $bookDT->getTimestamp();
        $data = array('time' => new MongoDate($bookTS));

        $db  = new MongoClient();
        $dbName = $db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $collection->insert($data);

        $this->load->view('cro/my_bookings_main');
    }

    function getMyBookingsCroToday(){
        $prev_date = date('Y-m-d', strtotime(date('Y-m-d') .' -1 day'));
    }

    function loadCustomerInfoEditView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data['tp']);

        $data['table_content'] = $this->load->view('cro/customer_info_edit', $result , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getCancelConfirmationView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data['tp']);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->customer_dao->getIndex($result , $input_data['refId'], $stat);

        $data['cancel_confirmation_view'] = $this->load->view('cro/cancel_booking', $result['history'][$stat["index"]] , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCustomerInfoView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data['tp']);

        if($result == null){
            $result =array('tp' => $input_data['tp']);
            $data['table_content'] = $this->load->view('cro/new_customer_form', $result , TRUE);
            /* Customer is new so send empty to to the JOB Info View */
            $data['job_info_view'] = '';
            $data['new_booking_view'] = '';
            $this->output->set_output(json_encode(array("statusMsg" => "fail","view" => $data)));
        }else{

//          TODO HAVE TO GET THE BOOKINGS FROM LIVE COLLECTION AND HISTORY COLLECTION
            $bookingData=array();
            foreach($result as $key => $value){
                if($key == 'history'){
                    foreach($value as $newKey){
                        var_dump($newKey);
                        echo 'printing the live data';
                        echo $newKey['_id'];
                        //$collection = $dbName->selectCollection('live');
//                        $searchQuery= array('_id' =>$newKey['_id']);
//                        $liveData=$collection->findOne($searchQuery);
//                        var_dump($liveData);
                    }
                }
            }

            $data['table_content'] = $this->load->view('cro/customer_info', $result , TRUE);
            $data['job_info_view'] = $this->load->view('cro/job_info', $result , TRUE);
            $data['new_booking_view'] = $this->load->view('cro/new_booking', $result , TRUE);
            $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
        }
    }

}