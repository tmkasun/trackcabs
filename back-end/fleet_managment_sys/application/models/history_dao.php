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

    /**
     * @param $id = mongoId String
     * @return php array of booking
     */
    function getBookingFeeByMongoId($id){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $searchQuery= array('_id' => new MongoId($id), 'bookingCharge' => '-');
        $cursor = $collection->find($searchQuery);
        $bookings= array();
        foreach ($cursor as $booking) {
            $bookings[]= $booking;
        }
        return $bookings;
    }

    /**
     * @return array
     */
    function getBookingFees(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');
        $searchQuery= array('vType' => array('$nin'=>array('nano')),'status' => 'END','bookingCharge' => '-');//'vType' => array('$not'=>'nano'),'vType' => array('$nin'=>array('nano')),
        //$searchQuery= array('$nin'=>array('bookingCharge'=>'-'));
        $cursor = $collection->find($searchQuery);//var_dump($cursor);
        $bookings= array('data'=> array());
        foreach ($cursor as $booking) {
            $bookings['data'][]= $booking;
        }
        return $bookings;
    }

    /**
     * @param $id
     * @return array
     */
    function getBookingFeesByDriverId($id){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');
        $searchQuery= array('vType' => array('$nin'=>array('nano')),'status' => 'END','driverId' => new MongoInt32($id), 'bookingCharge' => '-');
        $cursor = $collection->find($searchQuery);
        $bookings= array('data'=> array());
        foreach ($cursor as $booking) {
            $bookings['data'][]= $booking;
        }
        return $bookings;
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
        $collection->update($searchQuery ,array('$set' => array('bookingCharge' => intval($bookingCharge))));
    }

    function updateBookingChargeByRef($refId , $bookingCharge){
        $collection = $this->get_collection();
        $searchQuery= array('refId' => new MongoInt32($refId));
        $collection->update($searchQuery ,array('$set' => array('bookingCharge' => intval($bookingCharge))));
    }
}