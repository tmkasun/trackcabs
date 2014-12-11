<?php

class Counters_dao extends CI_Model
    /**
     * sample structure:
     * {
     * "_id":"productid",
     * "sequence_value": 0
     * }
     * */
{

    function __construct()
    {

        parent::__construct();
        $this->mongodb = new MongoClient();
    }

    function get_collection($collection = 'counters')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }

    function getNextId($modelName)
    {

        $refSequence = $this->mongodb->track->counters->findAndModify(
                array('_id' => $modelName),
                array(
                    '$inc' => array('sequence_value' => 1)
                ),null,
                array('new' => true,
                    'upsert' => true)
            );
        // TODO: do error handling
        return (int)$refSequence['sequence_value'];
    }

    function resetNextId($modelName){

        $collection = $this->get_collection();
        $result = $collection->findOne(array('_id' => $modelName));
        $result['sequence_value'] = 1;
        $collection->save($result);
    }
}