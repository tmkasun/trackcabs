<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro extends CI_Controller
{

    public function index()
    {
        $db  = new MongoClient();
        $dbName = $db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('_id' => new MongoId('544b0552d90580271b8b4567'));
        $result=$collection->findOne($searchQuery);
//    var_dump($result);

        $collection = $dbName->selectCollection('customers');
        $searchQuery= array('tp' => '0779823445');
        $result=$collection->findOne($searchQuery);

        foreach($result as $key => $value){
            if($key == 'history'){
                foreach($value as $newKey){
                    var_dump($newKey);
                    echo 'printing the live data';
                    echo $newKey['_id'];
                    $collection = $dbName->selectCollection('live');
                    $searchQuery= array('_id' =>$newKey['_id']);
                    $liveData=$collection->findOne($searchQuery);
                    var_dump($liveData);
                }
            }
        }

        $this->load->view('cro/cro_main');
    }

}