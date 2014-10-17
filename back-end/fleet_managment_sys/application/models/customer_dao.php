<?php
class Customer_dao extends CI_Model
{

    function __construct()
    {

    }

   /*
   * creates a new customer record in the customers collection
   * @keys in the customerArray {"telephone" => "", type => "", "Name" => "", "title" => "", "designation" => "" }
   */
    function createCustomer($customerArray){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $statusMsg = true;

        if($collection->findOne(array("tp" => $customerArray["tp"]))==null)
        $collection->insert($customerArray);
        else $statusMsg=false;

        return $statusMsg;
    }

    /*
    * Adds a new booking entry to the history array in the customer collection
    * @parameters $tp= customer tp number $booking = {'id'=>'', 'status' => '', address : {}}
    */
    function addBooking($tp , $booking){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery = array('tp' => $tp );
        $result = true;
        /* TODO get all booking and check if ID already Exists */
        if($result) {
            $collection->update($searchQuery, array('$push' => array("history" => $booking)));
            return true;
        }
        else return false;
    }


    /*
    * @method add +1 to the dispatch_cancel in the customers collection
    */
    function addCanceledDispatch($tp){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        /* If a record doesn't exist create new else update*/
        if(!isset($record['dis_cancel'])){
            $record["dis_cancel"] = 1;
        }
        else {
            $record["dis_cancel"]++;
        }
        $collection->save($record);
    }

    /*
     * @method add +1 to the cancel_tot in the customers collection
     */
    function addCanceledTotal($tp){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        /* If a record doesn't exist create new else update*/
        if(!isset($record['tot_cancel'])){
            $record["tot_cancel"] = 1;
        }
        else {
            $record["tot_cancel"]++;
        }
        $collection->save($record);
    }

    /*
     * @method add +1 to the inqCall in the customers collection
     */
    function addInquireCall($tp , $refId){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery = array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        $record["history"][$stat["index"]]["inqCall"]++;
        $collection->save($record);
    }

    /*
     * @returns similar tp numbers that matches the input
     */
    function getSimilar($tp){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $regex = new MongoRegex("/^$tp/i");
        $cursor = $collection->find(array('tp' => $regex));
        $data= array();
        $int = 0;
        foreach ($cursor as $doc) {
            $data[$int]= $doc["tp"];
            $int++;
        }
        return $data;
    }

    /*
    * @returns null if record doesn't exist , if exist sends the first record
    */
    function getCustomer($tp){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');
        $searchQuery = array('tp' => $tp);

        return $collection->findOne($searchQuery);
    }

    /*
     *@method return the status of a given order
     */
    function getStatus($tp , $refId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery = array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        return $record["history"][$stat["index"]]["status"];
    }

    /*
     *@Returns the status of a given order
     */
    function getBooking($tp , $refId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery = array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        return $record["history"][$stat["index"]];
    }

    /*
    * @method updates the customer information
    * {"tp" => "", type => "", "Name" => "", "title" => "", "designation" => "" }
    * DO NOT UPDATE THE HISTORY[ORDERS] WITH THIS METHOD
    */
    function updateCustomer($tp , $data){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        foreach ($data as $key => $value){
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }

    /*
     * Updates the order details
     */
    function updateBooking($tp,$refId,$data){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        foreach($data as $key => $value){
            $record["history"][$stat["index"]][$key] = $data [$key];
        }

        $collection->save($record);
    }

    /*
     * Updates the fee after the travel is finished
     */
    function updateFee( $tp , $refId , $fee ){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        $record["history"][$stat["index"]]["fee"]=$fee;

        $collection->save($record);
    }

    /*
     * Adds or Updates the cabID assigned for a order
     */
    function updateCabId($tp,$refId,$cabId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        $collection->update($searchQuery ,array('$set' => array('history.'.$stat["index"].'.cabId' => $cabId)));
    }

    /*
     * Add or Updates the driverID assigned for a order
     */
    function updateDriverId($tp,$refId,$driverId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        $collection->update($searchQuery ,array('$set' => array('history.'.$stat["index"].'.driverId' => $driverId)));
    }

    /*
    * Adds a new booking entry to the history array in the customer collection
    * @parameters $tp= customer to number $refId = order id $address = {'number' =>'', 'road' =>'', 'city' =>'',
    * 'town' => '', 'landmark' => ''}
    */
    function updateAddress($tp , $refId , $address){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        $collection->update($searchQuery ,array('$set' => array('history.'.$stat["index"].'.address' => $address)));

    }

    /*
     * Adds a new booking entry to the history array in the customer collection
     * @parameters $tp=customer tp  , $refId = order Id , $status = status to be assigned
     */
    function updateStatus($tp , $refId , $status)
    {

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');

        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        $collection->update($searchQuery ,array('$set' => array( 'history.'.$stat["index"].'.status' => $status)));
    }



    /*
    * @Method Returns the array index for the customer order id [ref_id]
    */
    function getIndex($record ,$refId , $stat )
    {

        foreach ($record as $key => $value)
        {
            if (is_array($value) && $stat["found"]==false)

                $stat = $this->getIndex($value,$refId,$stat);
            else {

                if($key == "refId") {
                    $stat["index"]++;
                    if($record[$key] == $refId){
                        $stat["found"]=true;
                    }
                }
            }

        }
        return $stat;
    }

}


