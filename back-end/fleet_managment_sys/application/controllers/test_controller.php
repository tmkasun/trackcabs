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

}

