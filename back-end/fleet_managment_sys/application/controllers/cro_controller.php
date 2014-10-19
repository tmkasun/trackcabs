<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro_controller extends CI_Controller
{

    public function index()
    {

    }

    function loadCustomerInfoEditView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->customer_dao->getCustomer($input_data['tp']);

        $data['table_content'] = $this->load->view('cro/customer_info_edit', $data , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
}