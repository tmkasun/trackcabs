<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver_retriever extends CI_Controller
{

    public function index()
    {
    }

    function getDriverNavBarView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/driver/driver_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getNewFormDriverView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/driver/new_driver_view', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getSidePanelView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/driver/driver_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getAllDriversView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->driver_dao->getDriversByPage($input_data['limit'],$input_data['skip']);
        $data['table_content'] = $this->load->view('admin/driver/all_drivers_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getDriverSearchView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->driver_dao->getDriver($input_data['driverId']);

        $data['table_content'] = $this->load->view('admin/driver/driver_search', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getDriverEditView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->driver_dao->getDriver($input_data['driverId']);
        $data['driver_edit_view'] = $this->load->view('admin/driver/edit_drivers', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function authenticate(){
        $statusMsg = 'fail';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->driver_dao->authenticate($input_data['uName'],$input_data['pass']);

        $data=array();
        if( $result != null ){
            $statusMsg = 'success';
            $data['driverId']=$result['driverId'];
            $data['cabId']=$result['cabId'];
        }
        $this->output->set_output( json_encode ( array ( "statusMsg" => $statusMsg , 'data' => $data )));
    }

    function createDriver(){

        $statusMsg = 'success';
        $input_data = json_decode(trim(file_get_contents('php://input')), true); //TODO: change to this structure $this->input->post(NULL,true); //

        $input_data["driverId"] = $this->counters_dao->getNextId("driver");
        $result = $this->driver_dao->createDriver($input_data);

        if(!$result){
            $statusMsg = 'fail';
        }

        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));

    }

    function updateDriver(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->driver_dao->updateDriver($input_data['driverId'],$input_data['details']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }

    function getDriver(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->driver_dao->getDriver($input_data['driverId']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));

    }

    function getDriversByPage(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->driver_dao->getDriversByPage($input_data['limit'],$input_data['skip']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }

    function getAllDrivers(){
        $result = $this->driver_dao->getAllDrivers();
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }


}