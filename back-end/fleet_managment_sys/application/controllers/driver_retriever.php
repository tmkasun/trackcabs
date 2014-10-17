<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver_retriever extends CI_Controller
{

    public function index()
    {
    }

    function authenticate(){

        $statusMsg = 'fail';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->driver_dao->authenticate($input_data['userName'],$input_data['pass']);

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

        $result = $this->driver_dao->createDriver($input_data["driverId"] , $input_data);

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

    function getAllDrivers(){

    }


}