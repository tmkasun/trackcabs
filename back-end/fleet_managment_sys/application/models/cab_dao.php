<?php
class Cab_dao extends CI_Model
{

    function __construct()
    {

    }

    
    function get_collection($collection = 'cabs')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }
    function createCab($cabArray){
        
        $collection = $this->get_collection();

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
        
        $collection = $this->get_collection();

        $searchQuery= array('cabId' => $cabId);
        //$record = $collection->findOne($searchQuery);
        $collection->update($searchQuery,array('$set' => $cabArray));

//        foreach ($cabArray as $key => $value){
//            $record[$key] = $cabArray[$key];
//        }
//
//        $collection->save($record);

    }


    function  getCab($cabId){
        
        $collection = $this->get_collection();

        $searchQuery= array('cabId' => (int)$cabId);
        return $collection->findOne($searchQuery);
    }

    function getAllCabs(){

        $collection = $this->get_collection();

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

        $collection = $this->get_collection();

        $cursor = $collection->find()->limit($limit)->skip($skip);
        $data= array('data' => array());
        foreach ($cursor as $doc ) {
            $data['data'][]= $doc;
        }
        return $data;
    }

    function getCabByPlate($noPlate){
        
        $collection = $this->get_collection();

        $searchQuery = array('noPlate' => $noPlate);
        return $collection->findOne($searchQuery);
    }

    function getVehicleType($cabId){
        
        $collection = $this->get_collection();

        $searchQuery = array('cabId'=> $cabId);
        $record = $collection->findOne($searchQuery);

        return $record['vType'];
    }


    function setLiveZone($cabId , $zone){
        
        $collection = $this->get_collection();
        
        $searchQuery= array('cabId' => (int)$cabId);

        $collection->update($searchQuery ,array('$set' => array('zone' => $zone)),array('new' => true));
        $collection->update($searchQuery ,array('$set' => array('state' => 'live')),array('new' => true));
        return $collection->findOne($searchQuery);

    }

    function setState($cabId,$state){
        
        $collection = $this->get_collection();
        
        $searchQuery= array('cabId' => (int)$cabId);
        $collection->update($searchQuery ,array('$set' => array('state' => $state)),array('new' => true));
        return $collection->findOne($searchQuery);

    }


    function setPobDestinationZoneTime($cabId , $zone, $eta){
        
        $collection = $this->get_collection();
        
        $searchQuery= array('cabId' => (int)$cabId);

        $collection->update($searchQuery ,array('$set' => array('zone' => $zone)),array('new' => true));
        $collection->update($searchQuery ,array('$set' => array('state' => 'pob')),array('new' => true));
        $collection->update($searchQuery ,array('$set' => array('eta' => $eta)),array('new' => true));
        return $collection->findOne($searchQuery);

    }


}