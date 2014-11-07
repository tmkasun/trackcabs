<?php
class History_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'history')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createBooking($bookingArray){
        $collection = $this->get_collection();
        $collection->insert($bookingArray);
        return;
    }

    function getBooking($objId){
        $collection = $this->get_collection();
        $searchQuery= array('_id' => new MongoId($objId ));

        return $collection->findOne($searchQuery);
    }

    /**
     * @param $id = mongoId String
     * @return php array of booking
     */
    function getBookingByMongoId($id){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $searchQuery= array('_id' => new MongoId($id));

        return $collection->findOne($searchQuery);
    }

    function updateBooking($objId , $data){
        $collection = $this->get_collection();

        $searchQuery= array('_id' => new MongoId($objId));
        $record = $collection->findOne($searchQuery);

        foreach ($data as $key => $value){
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }

    function updateBookingCharge($objId , $bookingCharge){
        $collection = $this->get_collection();
        
        $searchQuery= array('_id' => new MongoId($objId));
        $collection->update($searchQuery ,array('$set' => array('bookingCharge' => $bookingCharge)));
    }
}