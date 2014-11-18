<?php
class Live_dao extends CI_Model
{

    function __construct()
    {
        $this->db  = new MongoClient();
        //$this.db
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

    function getBookingByTown($town){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('address.town' => $town);

        return $collection->findOne($searchQuery);
    }


    /**
     * @param $objId = mongoId String
     * @return php array of booking
     */
    function getBookingByMongoId($objId){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('_id' => new MongoId($objId));

        return $collection->findOne($searchQuery);
    }

    function updateBooking($objId , $data){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('_id' => new MongoId($objId));
        $record = $collection->findOne($searchQuery);

        foreach ($data as $key => $value){
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }

    function updateStatus($id , $status){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('_id' => new MongoId($id));

        $collection->update($searchQuery ,array('$set' => array('status' => $status)));
    }

    function setDriverId($orderId, $driverId){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => (int)$orderId);

        $collection->update($searchQuery ,array('$set' => array('driverId' => $driverId)));
    }

    function setCabId($orderId,$cabId){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('refId' => (int)$orderId);

        $collection->update($searchQuery ,array('$set' => array('cabId' => (int)$cabId)));
    }

    function deleteBookingByMongoId($objId){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $searchQuery= array('_id' => new MongoId($objId));
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

    function getCroBookingsToday($croId){

        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('time');

        $today = date("Y-m-d 00:00:00");
        $todayUTC = new MongoDate(strtotime($today));

        $bookingArray = array('time' => $today);
        $collection->insert($bookingArray);

        $collection = $dbName->selectCollection('live');
        $cursor =$collection->find(array('bookTime'=> array('$gte' => $todayUTC), 'croId' => $croId));

        $data= array('data' => array());
        foreach($cursor as $doc){
            $data['data'][]= $doc;
        }
        return $data;

    }

    function getNotDispatchedBookings(){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $cursor = $collection->find(array("status" => "START"))->sort(array('bookTime' => 1,'address.town' => 1));
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    function getDispatchedBookings(){
        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $cursor = $collection->find(array("status" => array('$in' => array("MSG_COPIED","MSG_NOT_COPIED","ON_THE_WAY","AT_THE_PLACEa"))))->sort(array('bookTime' => 1,'address.town' => 1));
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    function setDispatchedTime($orderId){

        $today = date("Y-m-d 00:00:00");
        $todayUTC = new MongoDate(strtotime($today));


        $dbName = $this->db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $collection->update(
            array("refId" => (int)$orderId),
            array('$set' => array('dispatchTime' => $todayUTC))
        );

    }


}
