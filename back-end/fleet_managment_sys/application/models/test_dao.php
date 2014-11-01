<?php

class Test_dao extends CI_Model
{
    function get_collection()
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection('users');
        return $collection;
        
    }
    
    function createUser($user_details)
    {
        $collection = $this->get_collection();
        $collection->insert($user_details);
    }
    
    function getUser($userId)
    {
        $collection = $this->get_collection();
        $query = array('userId' => $userId);
        $result = $collection->findOne($query);
        return $result;
    }
    
    function getAllUsers()
    {
        $collection = $this->get_collection();
        $cursor = $collection->find();
        $users= array();
        foreach ($cursor as $user)
        {
            $users[]= $user;
        }

        return $users;
    }
    
    function getUsersByPage_by_type($type)
    {
        $collection = $this->get_collection();
        echo $type;
        $user_type = array('user_type' => $type);
        $cursor = $collection->find();//$user_type
        $users= array('data' => array());
        foreach ($cursor as $user) 
        {
            $users['data'][]= $user;
        }
        return $users;
    }
    
}