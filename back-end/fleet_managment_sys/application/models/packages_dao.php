<?php
class Packages_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'packages')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createPackage($input_data){
        $collection = $this->get_collection();
        $collection->insert($input_data);
        return;
    }

    function deletePackage($packageId)
    {
        $collection = $this->get_collection();
        $searchQuery= array('packageId' => new MongoInt32($packageId) );
        $collection->remove($searchQuery);
        $record = $collection->findOne($searchQuery);
        if( $record == null){ $statusMsg=true;}
        else {$statusMsg = false;}
        return $statusMsg;
    }

    function getPackage($packageId){
        $collection = $this->get_collection();
        $searchQuery= array('packageId' => new MongoInt32($packageId) );
        $cursor = $collection->find($searchQuery);
        $packages= array('data'=> array());
        foreach ($cursor as $package) {
            $packages['data'][]= $package;
        }
        return $packages;
    }

    function getPackageForEdit($packageId){
        $collection = $this->get_collection();
        $searchQuery= array('packageId' => new MongoInt32($packageId) );
        return $collection->findOne($searchQuery);
    }

    function getAllPackages(){

        $collection = $this->get_collection();
        $cursor = $collection->find();
        $packages= array('data'=> array());
        foreach ($cursor as $package) {
            $packages['data'][]= $package;
        }
        return $packages;
    }

    function getAllAirportPackages(){

        $collection = $this->get_collection();
        $searchQuery = array('feeType' => 'airport');
        $cursor = $collection->find($searchQuery);
        $packages= array('data'=> array());
        foreach ($cursor as $package) {
            $packages['data'][]= $package;
        }
        return $packages;
    }

    function getAllDayPackages(){

        $collection = $this->get_collection();
        $searchQuery = array('feeType' => 'day');
        $cursor = $collection->find($searchQuery);
        $packages= array('data'=> array());
        foreach ($cursor as $package) {
            $packages['data'][]= $package;
        }
        return $packages;
    }


    function updatePackage($packageId , $data){
        $collection = $this->get_collection();

        $searchQuery= array('packageId' => (int)$packageId);
        $collection->update($searchQuery,array('$set' => $data ));

    }

}