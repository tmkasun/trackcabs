<?php
class Users_dao extends CI_Model
{

    function __construct()
    {

    }

    /*
    * @returns null if record doesn't exist , if exist sends the first record
    */
    function getCustomer($tp){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('customers');
        $searchQuery = array('tp' => $tp);

        return $collection->findOne(array('tp' => $searchQuery));
    }



}