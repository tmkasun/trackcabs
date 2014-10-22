<?php
class Users_dao extends CI_Model
{

    function __construct()
    {

    }

    /*
    * @returns null if record doesn't exist , if exist sends the first record
    */
    function authenticate($uName , $pass){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('users');
        $searchQuery = array('uName' => $uName , 'pass' => $pass );

        return $collection->findOne($searchQuery);
    }



}