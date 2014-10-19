<?php
class Driver_dao extends CI_Model
{

    function __construct()
    {

    }

    function createDriver($driverArray){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('drivers');

        $statusMsg = true;
        $record = $collection->findOne(array("driverId" => $driverArray['driverId']));

        if( $record == null)
            $collection->insert($driverArray);
        else $statusMsg=false;

        return $statusMsg;
    }

    function getDriver($driverId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('drivers');

        $searchQuery = array('driverId' => $driverId);
        return $collection->findOne($searchQuery);
    }

    function getAllDrivers(){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('drivers');

        $cursor = $collection->find();
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }

        return $data;
    }

    function getDriverByCabId(){

    }

    function getDriversByPage($limit,$skip){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('drivers');

        $cursor = $collection->find()->limit($limit)->skip($skip);
        $data= array('data' => array());
        foreach ($cursor as $doc ) {
            $data['data'][]= $doc;
        }
        return $data;
    }

    function authenticate($userName , $pass ){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('drivers');

        return $collection->findOne(array("uName" => $userName , 'pass' => $pass ));

    }

    function updateDriver($driverId , $data){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('drivers');

        $searchQuery= array('driverId' => $driverId);
        $record = $collection->findOne($searchQuery);

        foreach ($data as $key => $value){
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }


}