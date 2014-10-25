<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro extends CI_Controller
{

    public function index()
    {
        $db  = new MongoClient();
        $dbName = $db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $bookingData = $this->live_dao->getBookingByMongoId("544b115cd905802a1d8b4567");
        $result = $bookingData['status'];
        //var_dump($result);
        if ($result == ("MSG_COPIED") || $result == ("MSG_NOT_COPIED") || $result == ("AT_THE_PLACE") || $result == ("POB") || $result == ("POB")) {

            //$this->customer_dao->addCanceledDispatch($input_data["tp"]);
            //$this->customer_dao->addCanceledTotal($input_data["tp"]);
            $this->live_dao->updateStatus("544b115cd905802a1d8b4567",  "cancelDis");

        } else if ($result == ("start")) {
            $this->live_dao->updateStatus("544b115cd905802a1d8b4567",  "CANCEL");
        }

        $searchQuery= array('_id' => new MongoId('544b0552d90580271b8b4567'));
        $result=$collection->findOne($searchQuery);

        $collection = $dbName->selectCollection('customers');
        $searchQuery= array('tp' => '0779823445');
        $result=$collection->findOne($searchQuery);

        $bookingData=array('booking' => array());
        foreach($result as $key => $value){
            if($key == 'history'){
                foreach($value as $newKey){
                    $data = $this->live_dao->getBookingByMongoId($newKey['_id']);
                    $bookingData['booking'][] = $data;
                }
            }
        }
//        var_dump($bookingData);

        $this->load->view('cro/cro_main');
    }

}