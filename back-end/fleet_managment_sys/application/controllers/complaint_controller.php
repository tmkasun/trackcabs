<?php
class Complaint_controller extends CI_Controller
{
    //Rrecords a complaint with refId(booking ref id), complaint(string containing the customers complaint), complaintId and tineOfComplaint..it is better to record the userId of the CRO as well
    function record_complaint()
    {//$complaint_data = array('refId' => 1, 'complaint' => 'test complaint', 'userId_cro_complaint' => 2);//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaint_data['complaintId'] = (int)($this->counters_dao->getNextId("complaints"));
        $complaint_data['timeOfComplaint'] = new MongoDate();
        $driver_cro = $this->history_dao->get_driver_and_cro_by_refId($complaint_data['refId']);
        $complaint_data['userId_driver'] = $driver_cro['driverId'];
        $complaint_data['userId_cro_booking'] = $driver_cro['croId'];
        
        $result = $this->complaint_dao->record_complaint($complaint_data);
        
        $statusMsg = 'success';
        if(!$result){
            $statusMsg = 'fail';
        }
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));
    }    
    //get all complaints in the complaints collection
    function get_all_complaints()
    {
        $complaints = $this->complaint_dao->get_all_complaints();
        print_r($complaints);//comment the array print and load complaints to a view with jason encode
        
    }
    
    function get_all_complaints_by_driver()
    {//$complaint_data['userId_driver']//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaints_by_driver = $this->complaint_dao->get_all_complaints_by_driver($complaint_data['userId_driver']);
        var_dump($complaints_by_driver);//comment the array print and load complaints to a view with jason encode
    }
    
    function get_complaint_by_refId()
    {//$complaint_data['refId'] = 10;//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaints_by_refId = $this->complaint_dao->get_complaint_by_refId($complaint_data['refId']);
        var_dump($complaints_by_refId);//comment the array print and load complaints to a view with jason encode       
    }
    
    function get_complaint_by_complaintId()
    {//$complaint_data['complaintId'] = 12;//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaints_by_complaintId = $this->complaint_dao->get_complaint_by_complaintId($complaint_data['complaintId']);
        var_dump($complaints_by_complaintId);//comment the array print and load complaints to a view with jason encode        
    }
    
    function updatae_complaint()
    {//$complaint_data['complaintId'] = 12; $complaint_data['complaint'] = 'edited the complaint';//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaints_by_complaintId = $this->complaint_dao->update_complaint($complaint_data['complaintId'],array('complaint' => $complaint_data['complaint']));
        var_dump($complaints_by_complaintId);//comment the array print and load complaints to a view with jason encode
        
    }
}
