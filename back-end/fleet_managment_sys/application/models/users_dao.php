<?php

class Users_dao extends CI_Model
{

    function __construct()
    {

    }
    
    function get_collection()
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection('users');
        return $collection;
        
    }
            
    function createUser($user_details)
    {
        $collection = $this->get_collection();

        $statusMsg = true;
        $searchQuery = array('userId' => $user_details['userId']);
        $record = $collection->findOne($searchQuery);

        if( $record == null){ $collection->insert($user_details);}           
        else {$statusMsg = false;} 

        return $statusMsg;
    }

    function getUser($userId)
    {
        $collection = $this->get_collection();

        $searchQuery = array('userId' => $userId);
        $user = $collection->findOne($searchQuery);
        return $user;
    }

    function getAllUsers()
    {
        $collection = $this->get_collection();

        $cursor = $collection->find();
        $users= array();
        foreach ($cursor as $user) {
            $users[]= $user;
        }

        return $users;
    }
    

    function getUsersByPage($limit,$skip)
    {
        $collection = $this->get_collection();

        $cursor = $collection->find()->limit($limit)->skip($skip);
        $users= array('data' => array());
        foreach ($cursor as $user) 
        {
            $users['data'][]= $user;
        }
        return $users;
    }

    function authenticate($userName, $pass)
    {
        $collection = $this->get_collection();
        $searchQuery = array("uName" => $userName , 'pass' => $pass );
        $user = $collection->findOne($searchQuery);
        return $user;

    }

    function updateUser($userId , $edited_data)
    {
        $collection = $this->get_collection();

        $searchQuery= array('userId' => $userId);
        $user = $collection->findOne($searchQuery);

        foreach ($data as $key => $value)
        {
            $user[$key] = $edited_data[$key];
        }

        $collection->save($record);
    }
    
    //Special functions
    function getDriverByCabId()
    {

    }
    function getCabByDriverId()
    {

    }


}