<?php
class Live_dao extends CI_Model
{

    function __construct()
    {

    }

    function createBooking($bookingArray){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $collection->insert($bookingArray);
        return;
    }

    function getBooking($refId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => $refId);

        return $collection->findOne($searchQuery);
    }

    function updateBooking($refId , $data){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('live');

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
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => $refId);

        $collection->update($searchQuery ,array('$set' => array('status' => $status)));
    }

    function deleteBooking($refId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => $refId);
        $collection->remove( $searchQuery);
    }

    function addInquireCall($refId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => $refId);
        $record = $collection->findOne($searchQuery);

        $record["inqCall"]++;
        $collection->save($record);
    }

    function getAllBookings(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $cursor = $collection->find();
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }


}