<?php
class Log_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'log')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createLog($input_data){
        $collection = $this->get_collection();
        $collection->insert($input_data);
        return;
    }


}