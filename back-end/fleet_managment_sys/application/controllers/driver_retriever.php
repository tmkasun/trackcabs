<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver_retriever extends CI_Controller
{

    public function index()
    {
    }

    function getDriverNavBarView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('cab_driver_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getNewFormDriverView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('new_driver_view', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getSidePanelView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('driver_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getAllDriversView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->driver_dao->getDriversByPage($input_data['limit'],$input_data['skip']);
        $data['table_content'] = $this->load->view('all_drivers_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getDriverSearchView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->driver_dao->getDriver($input_data['cabId']);

        $data['table_content'] = $this->load->view('driver_search', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }



    function authenticate(){
        //echo 'came bitch';
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
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $input_data["driverId"] = $this->ref_dao->getDriverId();

        $result = $this->driver_dao->createDriver($input_data);

        if(!$result){
            $statusMsg = 'fail';
        }

        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));

    }

    function updateDriver(){

    }

    function getDriver(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

    }

    function getDriversByPage(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->driver_dao->getDriversByPage($input_data['limit'],$input_data['skip']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }

    function getAllDrivers(){
        $result = $this->driver_dao->getAllCabs();
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }


}