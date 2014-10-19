<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cab_retriever extends CI_Controller
{

    public function index()
    {

    }

    function getNewCabView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('new_cab_view', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCabSearchView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->cab_dao->getCab($input_data['cabId']);

        $data['table_content'] = $this->load->view('cab_search', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCabNavBar(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('cab_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getSidePanelView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('cab_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getAllCabsView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->cab_dao->getCabsByPage($input_data['limit'],$input_data['skip']);
        $data['table_content'] = $this->load->view('all_cabs_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }



    function getCabEditView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->cab_dao->getCab($input_data['cabId']);
        $data['table_content'] = $this->load->view('edit_cabs', $data, TRUE);
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
        $this->cab_dao->updateCab($input_data['cabId'],$input_data['details']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }
}