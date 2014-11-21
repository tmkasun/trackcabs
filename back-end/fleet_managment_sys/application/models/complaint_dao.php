<?php
class Complaint_dao extends CI_Model
{
    function get_collection($collection = 'complaints')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }
    
    function record_complaint($complaint_data)
    {
        $collection = $this->get_collection();
        $collection->insert($complaint_data);
        return true;              
    }
    
    function get_all_complaints()
    {
        $collection = $this->get_collection();
        $complaints_cursor = $collection->find();
        $complaints = array();
        foreach($complaints_cursor as $comlaint){$complaints[] = $comlaint;}
        return $complaints;
    }
    function get_all_complaints_by_driver($userId_driver)
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId_driver' => $userId_driver);
        $complaints_cursor_by_driver = $collection->find($searchQuery);
        $complaints_by_driver = array();
        foreach($complaints_cursor_by_driver as $complaint_by_driver){$complaints_by_driver[] = $complaint_by_driver;}
        return $complaints_by_driver;
    }
    function get_complaint_by_refId($refId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('refId' => $refId);
        $complaints_cursor_by_refId = $collection->find($searchQuery);
        $complaints_by_refId = array();
        foreach($complaints_cursor_by_refId as $complaint_by_refId){$complaints_by_refId[] = $complaint_by_refId;}
        return $complaints_by_refId;
    }
    function get_complaint_by_complaintId($complaintId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('complaintId' => $complaintId);
        $complaint_by_refId = $collection->findOne($searchQuery);
        return $complaint_by_refId;
    }
    
    function update_complaint($complaintId,$edited_complaint)
    {
        $collection = $this->get_collection();
        $searchQuery = array('complaintId' => $complaintId);
        $collection->update($searchQuery,array('$set' => $edited_complaint));
    }
  
}
