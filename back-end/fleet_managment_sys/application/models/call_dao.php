<?php
/**
 *  @property Cab_dao $Cab_dao
 */
class Call_dao extends CI_Model
{

    function __construct()
    {

    }


    function get_collection($collection = 'calls')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }

    function createCall($callArray)
    {

        $collection = $this->get_collection();

        $statusMsg = true;
        $collection->insert($callArray);

        return $statusMsg;
    }


    function getLiveCalls(){

        $collection = $this->get_collection();
        $searchQuery = array("state" => "LIVE");
        $cursor = $collection->find($searchQuery);
        $callArray = array();
        foreach ($cursor as $doc) {
            array_push($callArray,$doc);
        }
        return $callArray;
    }

    function addToCallDump($totalCallArray){
        $collection = $this->get_collection('call_dump');

        $collection->insert($totalCallArray);

    }


    function getCallsInLastSeconds(){
        $collection = $this->get_collection();
        $SecondsBeforeNow = strtotime("now")-150;
        $SecondsBeforeNowinMongo = new MongoDate(strtotime($SecondsBeforeNow));
        $cursor =$collection->find(array('time'=> array('$gte' => $SecondsBeforeNowinMongo)));
        $callArray = array();
        foreach ($cursor as $doc) {
            array_push($callArray,$doc);
        }
        return $callArray;
    }

}