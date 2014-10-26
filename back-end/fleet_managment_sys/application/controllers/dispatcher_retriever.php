<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dispatcher_retriever extends CI_Controller
{


    public function index()
    {
    }

    function getDispatcherNavBarView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/dispatcher/dispatcher_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getNewFormDispatcherView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/dispatcher/new_dispatcher_view', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getSidePanelView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/dispatcher/dispatcher_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getAllDispatchersView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->dispatcher_dao->getDispatchersByPage($input_data['limit'],$input_data['skip']);
        $data['table_content'] = $this->load->view('admin/dispatcher/all_dispatchers_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getDispatcherSearchView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->dispatcher_dao->getDispatcher($input_data['dispatcherId']);

        $data['table_content'] = $this->load->view('admin/dispatcher/dispatcher_search', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getDispatcherEditView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->dispatcher_dao->getDispatcher($input_data['dispatcherId']);
        $data['dispatcher_edit_view'] = $this->load->view('admin/dispatcher/edit_dispatchers', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function authenticate(){
        $statusMsg = 'fail';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->dispatcher_dao->authenticate($input_data['uName'],$input_data['pass']);

        $data=array();
        if( $result != null ){
            $statusMsg = 'success';
            $data['dispatcherId']=$result['dispatcherId'];
        }
        $this->output->set_output( json_encode ( array ( "statusMsg" => $statusMsg , 'data' => $data )));
    }

    function createDispatcher(){

        $statusMsg = 'success';
        $input_data = json_decode(trim(file_get_contents('php://input')), true); //TODO: change to this structure $this->input->post(NULL,true); //

        $input_data["dispatcherId"] = $this->counters_dao->getNextId("dispatcher");
        $result = $this->dispatcher_dao->createDispatcher($input_data);

        if(!$result){
            $statusMsg = 'fail';
        }

        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));

    }

    function updateDispatcher(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->dispatcher_dao->updateDispatcher($input_data['dispatcherId'],$input_data['details']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }

    function getDispatcher(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->dispatcher_dao->getDispatcher($input_data['dispatcherId']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));

    }

    function getDispatchersByPage(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->dispatcher_dao->getDispatchersByPage($input_data['limit'],$input_data['skip']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }

    function getAllDispatchers(){
        $result = $this->dispatcher_dao->getAllDispatchers();
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }


}