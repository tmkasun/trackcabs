<?php
class History_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'history')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createBooking($bookingArray){
        $collection = $this->get_collection();
        $collection->insert($bookingArray);
        return;
    }

    function getBooking($objId){
        $collection = $this->get_collection();
        $searchQuery= array('_id' => new MongoId($objId ));

        return $collection->findOne($searchQuery);
    }

    function getBookingByRefId($refId){
        $collection = $this->get_collection();
        $searchQuery= array('refId' => (int)$refId);
        return $collection->findOne($searchQuery);
    }

    function getBookings($limit = null){
        $collection = $this->get_collection();
        $bookings = $collection->find()->limit($limit);
        $bookings_with_cab = array();
        foreach ($bookings as $booking) {
            $cab = $this->cab_dao->getCab($booking['cabId']);
            $booking['cab'] = $cab;
            array_push($bookings_with_cab,$booking);
        }
        return $bookings_with_cab;
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

    function getBookingsByDateRange($startDate,$endDate,$userId,$cabId){
        $collection = $this->get_collection();
        if($userId == "0" && $cabId == "0") {
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate));
        }else if($userId != "0" && $cabId == "0"){
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate),'driverId' => new MongoInt32($userId));
        }else if($userId == "0" && $cabId != "0"){
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate),'cabId' => new MongoInt32($cabId));
        }else if($userId != "0" && $cabId != "0"){
            $searchQuery = array('bookTime' => array('$gt' => $startDate, '$lte' => $endDate),'driverId' => new MongoInt32($userId),'cabId' => new MongoInt32($cabId));
        }
        return $collection->find($searchQuery);//var_dump($cursor);

    }
    /**
     * @param $id = mongoId String
     * @return php array of booking
     */
    function getBookingFeeByMongoId($id){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');

        $searchQuery= array('_id' => new MongoId($id), 'bookingCharge' => '-');
        $cursor = $collection->find($searchQuery);
        $bookings= array();
        foreach ($cursor as $booking) {
            $bookings[]= $booking;
        }
        return $bookings;
    }

    /**
     * @return array
     */
    function getBookingFees(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');
        $searchQuery= array('vType' => array('$nin'=>array('nano')),'status' => 'END','bookingCharge' => '-');//'vType' => array('$not'=>'nano'),'vType' => array('$nin'=>array('nano')),
        //$searchQuery= array('$nin'=>array('bookingCharge'=>'-'));
        $cursor = $collection->find($searchQuery);//var_dump($cursor);
        $bookings= array('data'=> array());
        foreach ($cursor as $booking) {
            $bookings['data'][]= $booking;
        }
        return $bookings;
    }

    /**
     * @param $id
     * @return array
     */
    function getBookingFeesByDriverId($id){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('history');
        $searchQuery= array('vType' => array('$nin'=>array('nano')),'status' => 'END','driverId' => new MongoInt32($id), 'bookingCharge' => '-');
        $cursor = $collection->find($searchQuery);
        $bookings= array('data'=> array());
        foreach ($cursor as $booking) {
            $bookings['data'][]= $booking;
        }
        return $bookings;
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

    function updateBookingCharge($objId , $bookingCharge){
        $collection = $this->get_collection();

        $searchQuery= array('_id' => new MongoId($objId));
        $collection->update($searchQuery ,array('$set' => array('bookingCharge' => intval($bookingCharge))));
    }

    function updateBookingChargeByRef($refId , $bookingCharge){
        $collection = $this->get_collection();
        $searchQuery= array('refId' => new MongoInt32($refId));
        $collection->update($searchQuery ,array('$set' => array('bookingCharge' => intval($bookingCharge))));
    }
    
    function get_driver_and_cro_by_refId($refId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('refId' => $refId);
        $driver_cro = $collection->findOne($searchQuery,array('driverId' => true, 'croId' => true));
        return $driver_cro;
    }

    function getHireSummaryByDate($date){

        $collection = $this->get_collection();
        $searchQuery= array('bDate' =>$date);
        $bookings = $collection->find($searchQuery);

        return $bookings;
    }
}