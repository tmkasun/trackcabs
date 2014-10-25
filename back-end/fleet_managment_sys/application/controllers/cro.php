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
        var_dump($result);

        $searchQuery= array('_id' => new MongoId('544b0552d90580271b8b4567'));
        $result=$collection->findOne($searchQuery);

        $collection = $dbName->selectCollection('customers');
        $searchQuery= array('tp' => '0779823445');
        $result=$collection->findOne($searchQuery);

        $bookingData=array('booking' => array());
        foreach($result as $key => $value){
            if($key == 'history'){
                foreach($value as $newKey){
                    //var_dump($newKey);
                    echo 'printing the live data';
                    echo $newKey['_id'];
                    $data = $this->live_dao->getBookingByMongoId($newKey['_id']);
                    //var_dump($data);
                    $bookingData['booking'][] = $data;
                }
            }
        }
//        var_dump($bookingData);

        $this->load->view('cro/cro_main');
    }

}