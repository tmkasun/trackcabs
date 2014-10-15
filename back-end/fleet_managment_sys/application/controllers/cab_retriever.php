<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cab_retriever extends CI_Controller
{

    public function index()
    {

    }

    function getCabView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('all_cabs', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCabEditView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('edit_cabs', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function createCab(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $input_data['cabId'] = $this->ref_dao->getCabId($input_data);
        $result = $this->cab_dao->createCab($input_data);
        if($result == true)
            $this->output->set_output(json_encode(array("statusMsg" => "success","data" => "customer created successfully ")));
        else
            $this->output->set_output(json_encode(array("statusMsg" => "fail","data" => "customer already exists")));

    }

    function getCab(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->cab_dao->getCab($input_data['cabId']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));

    }

    function getAllCabs(){
        $result = $this->cab_dao->getAllCabs();
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));

    }

    function getCabsByPage(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->cab_dao->getCabsByPage($input_data['limit'],$input_data['skip']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }

    function updateCab(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->cab_dao->updateCab($input_data['cabId'],$input_data['data']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }

    function getCanByPlate(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->cab_dao->getCabByPlate($input_data['noPlate']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }
}