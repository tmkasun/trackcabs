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
        $collection = $this->get_collection();
        $collection->insert($bookingArray);
        return;
    }

    function get_collection($collection = 'live')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function getBooking($refId){
        $collection = $this->get_collection();
        $searchQuery= array('refId' => (int)$refId);
        return $collection->findOne($searchQuery);
    }

    function getBookingsByDateRange($startDate,$endDate,$userId){
        $collection = $this->get_collection();
        if($userId == "0") {
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate));
        }else{
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate),'driverId' => new MongoInt32($userId));
        }
        return $collection->find($searchQuery);//var_dump($cursor);

    }

    function getBookingByTown($town){
        $collection = $this->get_collection();
        $searchQuery= array('address.town' => $town);
        $cursor = $collection->find($searchQuery);

        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    /**
     * @param $objId = mongoId String
     * @return php array of booking
     */
    function getBookingByMongoId($objId){
        $collection = $this->get_collection();
        $searchQuery= array('_id' => new MongoId($objId));

        return $collection->findOne($searchQuery);
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

    function updateStatus($id , $status){
        $collection = $this->get_collection();
        $searchQuery= array('_id' => new MongoId($id));

        $collection->update($searchQuery ,array('$set' => array('status' => $status)));
    }

    function setDriverId($orderId, $driverId){
        $collection = $this->get_collection();
        $searchQuery= array('refId' => (int)$orderId);

        $collection->update($searchQuery ,array('$set' => array('driverId' => $driverId)));
    }

    function setCabId($orderId,$cabId){
        $collection = $this->get_collection();
        $searchQuery= array('refId' => (int)$orderId);

        $collection->update($searchQuery ,array('$set' => array('cabId' => (int)$cabId)));
    }

    function deleteBookingByMongoId($objId){
        $collection = $this->get_collection();

        $searchQuery= array('_id' => new MongoId($objId));
        $collection->remove( $searchQuery);
    }

    function addInquireCall($objId){
        $collection = $this->get_collection();
        $searchQuery= array('_id' => new MongoId($objId));
        $record = $collection->findOne($searchQuery);

        $record["inqCall"]++;
        $collection->save($record);
    }

    function getAllBookings(){
        $collection = $this->get_collection();
        $cursor = $collection->find()->sort(array('bookTime' => 1,'address.town' => 1));
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    function getDayBookings($date){
        $collection = $this->get_collection();
        $searchQuery = array('callTime' => array('$gte'=>$date) );

        $cursor = $collection->find($searchQuery);
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
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


    function getCroBookings($croId){
        $collection = $this->get_collection();
        $cursor =$collection->find(array('croId' => (int)$croId));

        $data= array('data' => array());
        foreach($cursor as $doc){
            $data['data'][]= $doc;
        }
        return $data;

    }

    function getNotDispatchedBookings(){
        $collection = $this->get_collection();

        $cursor = $collection->find(array("status" => "START"))->sort(array('bookTime' => 1,'address.town' => 1));
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    function getDispatchedBookings(){
        $collection = $this->get_collection();

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
