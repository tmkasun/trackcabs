<?php
class Ref_dao extends CI_Model
{

    function __construct()
    {

    }

    function getRefId(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('ref');

        $searchQuery= array('data' => 'refe');
        $record = $collection->findOne($searchQuery);

        if($record == null){
            $searchQuery['refId']=1;
            $collection->insert($searchQuery);
            $record = $searchQuery;
        if(!isset($record['refId'])){
            $record['refId']=1;
            $collection->save($record);
        }
        }else{
            $record['refId']++;
            $collection->save($record);
        }
        return $record['refId'];
    }

    function getDriverId(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('ref');

        $searchQuery= array('data' => 'refe');
        $record = $collection->findOne($searchQuery);

        if($record == null ){
            $searchQuery['driverId']=1;
            $collection->insert($searchQuery);
            $record = $searchQuery;
        if(!isset($record['driverId'])){
            $record['driverId']=1;
            $collection->save($record);
        }
        }else{
            $record['driverId']++;
            $collection->save($record);
        }
        return $record['driverId'];
    }

    function getCabId(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('ref');

        $searchQuery= array('data' => 'refe');
        $record = $collection->findOne($searchQuery);
        //var_dump($record);

        if($record == null){
            $searchQuery['cabId']=1;
            $collection->insert($searchQuery);
            $record = $searchQuery;
        if( !isset($record['cabId']) ){
            $record['cabId']=1;
            $collection->save($record);
        }
        }else{
            $record['cabId']++;
            $collection->save($record);
        }
        return $record['cabId'];
    }
}