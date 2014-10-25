<?php
class Live_dao extends CI_Model
{

    function __construct()
    {
        $this->db  = new MongoClient();
    }

    /**
     * @param $bookingArray << this is the default structure of the live dao
     @sample
     * {
     *   "refId": "123",
     *   "status" : "start",
     *   "address":{"number": "8/2","road": "vihara road","city": "Mount Lavania","town": "Colombo","landmark": "near Cargills"},
     *   "cabId": "uv-123",
     *   "driverId":"123",
     *   "callTime": "2014-10-05T00:38:55.070Z",
     *   "bookTime": "2014-10-05T02:38:55.070Z",
     *   "endTime": "10.05pm",
     *   "payType": "cash | credit",
     *   "vType": "nano | cab | van",
     *   "remark": "tinted window",
     *   "call_up": "true | false",
     *   "inqCall": "1",
     *   "bType":"airportDrop"
     * }
     * @return php array
     */

    function createBooking($bookingArray){

        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $collection->insert($bookingArray);
        return;
    }

    function getBooking($refId){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => (int)$refId);

        return $collection->findOne($searchQuery);
    }

    function getBookingByMongoId(){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => (int)$refId);

        return $collection->findOne($searchQuery);
    }

    function updateBooking($refId , $data){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => $refId);
        $record = $collection->findOne($searchQuery);

        foreach ($data as $key => $value){
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }

    function updateStatus($refId , $status){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => $refId);

        $collection->update($searchQuery ,array('$set' => array('status' => $status)));
    }

    function deleteBooking($refId){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => (int)$refId);
        $collection->remove( $searchQuery);
    }

    function addInquireCall($refId){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => $refId);
        $record = $collection->findOne($searchQuery);

        $record["inqCall"]++;
        $collection->save($record);
    }

    function getAllBookings(){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $cursor = $collection->find()->sort(array('bookTime' => 1,'address.town' => 1));
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    function getDayBookings($date){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery = array('callTime' => array('$gte'=>$date) );

        $cursor = $collection->find($searchQuery);
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    function getPeriodBookings($startDate,$endDate){

    }


}
