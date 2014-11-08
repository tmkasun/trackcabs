<?php
class Test_controller extends CI_Controller
{//var cro = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp };
    function createUser()
    {
        $userId = $this->counters_dao->getNextId('test_collection');echo $userId;
        $user_details = array('userId' => $userId, 'name' => 'test_user_1', 'uName' => 'uname1', 'pass' => '1234', 'nic' => '852003674', 'tp' => '665488105', 'state'=> 'inactive');
        $this->test_dao->createUser($user_details);
    }
    
    function getUSer(){}
    function getAllUSer()
    {
        $users = $this->test_dao->getAllUsers();
        print_r($users);
    }
    function update_and_get_user()
    {
        $user_data = $this->test_dao->update_and_get_user(array('address' => ''),array('address' => 'test address 2'));
        print_r($user_data);
    }
    function getCRONavBarView(){       
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/cro/cro_navbar', $table_data, TRUE);//, $table_data, TRUE
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    function getDriverNavBarView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/driver/driver_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    
     function getAllUsersView(){

        //$input_data = json_decode(trim(file_get_contents('php://input')), true);
        //$limit = $input_data['limit'];
        //$skip = $input_data['skip'];
        $user_type = 'cro';//$input_data['user_type'];
        
        
        $data = $this->test_dao->getUsersByPage_by_type();
        print_r($data);
        //$data['table_content'] = $this->load->view('admin/'.$user_type.'/all_'.$user_type.'_view', $data, TRUE);
        //$this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }
    function getNewFormUserView(){
        //$table_data['x'] = 1;
        
        //$input_data = json_decode(trim(file_get_contents('php://input')), true);
        $user_type = 'driver';
        $cab_ids = array();
        if($user_type === 'driver')
            {
                $cursor = $this->cab_dao->get_unassigned_cabs();
                foreach($cursor as $cab_id){$cab_ids[] = $cab_id;}
            }
            print_r($cab_ids);
             $this->load->view('admin/'.$user_type.'/new_'.$user_type.'_view',array('cab_ids' => $cab_ids,TRUE));// ,array('cab_ids' => $cab_ids), TRUE
            //var_dump($var);
//        $data['table_content'] = $this->load->view('admin/'.$user_type.'/new_'.$user_type.'_view', array('cab_ids' => $cab_ids), TRUE);
//        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    function getFees()
    {
        $data = $this->history_dao->getBookingFees();
        var_dump($data);
    }
}

