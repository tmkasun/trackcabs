<?php
class History_dao extends CI_Model
{

    function __construct()
    {

    }

    function createBooking($bookingArray){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $collection->insert($bookingArray);
        return;
    }

    function getBooking($refId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $searchQuery= array('refId' => $refId);

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

    function updateBooking($refId , $data){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $searchQuery= array('refId' => $refId);
        $record = $collection->findOne($searchQuery);

        foreach ($data as $key => $value){
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }

    function updateStatus($refId , $status){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $searchQuery= array('refId' => $refId);

        $collection->update($searchQuery ,array('$set' => array('status' => $status)));
    }
}