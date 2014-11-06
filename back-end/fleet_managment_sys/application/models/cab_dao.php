<?php
class Cab_dao extends CI_Model
{

    function __construct()
    {

    }

    function createCab($cabArray){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');

        $statusMsg = true;
        $record = $collection->findOne(array("cabId" => $cabArray['cabId']));

        if( $record == null) {
            $cabArray["state"] = "unknown";

            $collection->insert($cabArray);
        }
        else $statusMsg=false;

        return $statusMsg;
    }

    function updateCab($cabId , $cabArray){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');

        $searchQuery= array('cabId' => $cabId);
        $record = $collection->findOne($searchQuery);

        foreach ($cabArray as $key => $value){
            $record[$key] = $cabArray[$key];
        }

        $collection->save($record);

    }


    function  getCab($cabId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');

        $searchQuery= array('cabId' => $cabId);
        return $collection->findOne($searchQuery);
    }

    function getAllCabs(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');

        $cursor = $collection->find();
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    function getCabsInZones(){
        $allCabs = $this->getAllCabs();

        $data = array();
        foreach ($allCabs as $cab) {
            $driver = $this->user_dao->getDriverByCabId((int)$cab['cabId']);
            $cab['driver'] = $driver;
            array_push($data,$cab);
        }
        return $data;
    }


    function getCabsByPage($limit,$skip){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');

        $cursor = $collection->find()->limit($limit)->skip($skip);
        $data= array('data' => array());
        foreach ($cursor as $doc ) {
            $data['data'][]= $doc;
        }
        return $data;
    }

    function getCabByPlate($noPlate){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');

        $searchQuery = array('noPlate' => $noPlate);
        return $collection->findOne($searchQuery);
    }

    function getVehicleType($cabId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');

        $searchQuery = array('cabId'=> $cabId);
        $record = $collection->findOne($searchQuery);

        return $record['vType'];
    }


    function setLiveZone($cabId , $zone){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');
        $searchQuery= array('cabId' => (int)$cabId);

        $collection->update($searchQuery ,array('$set' => array('zone' => $zone)),array('new' => true));
        $collection->update($searchQuery ,array('$set' => array('state' => 'live')),array('new' => true));
        return $collection->findOne($searchQuery);

    }

    function setState($cabId,$state){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');
        $searchQuery= array('cabId' => (int)$cabId);
        $collection->update($searchQuery ,array('$set' => array('state' => $state)),array('new' => true));
        return $collection->findOne($searchQuery);

    }


    function setPobDestinationZoneTime($cabId , $zone, $eta){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('cabs');
        $searchQuery= array('cabId' => (int)$cabId);

        $collection->update($searchQuery ,array('$set' => array('zone' => $zone)),array('new' => true));
        $collection->update($searchQuery ,array('$set' => array('state' => 'pob')),array('new' => true));
        $collection->update($searchQuery ,array('$set' => array('eta' => $eta)),array('new' => true));
        return $collection->findOne($searchQuery);

    }


}