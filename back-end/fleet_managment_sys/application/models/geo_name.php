<?php
class Geo_name extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * @param $geoNameId Geoname ID of a location , This is the default primary key for the geo_names collection
     * Return the
     * @return array|null
     */
    function find(){
        $connection = new MongoClient();
        $collection = $connection->geo_names->lk_test; // TODO: put this as a collection inside commonly agreed database
        $result =  $collection->findOne();
        var_dump($result);
        return $result;
    }

}