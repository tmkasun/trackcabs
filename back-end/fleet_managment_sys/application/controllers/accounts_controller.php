<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_controller extends CI_Controller
{
    function getAllAccountsView()
    {
        $data = $this->history_dao->getBookingFees();
        $data['table_content'] = $this->load->view('admin/accounts/all_accounts_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getAccountsViewByDriverId($driverId)
    {
        $data = $this->history_dao->getBookingFeesByDriverId($driverId);
        $data['table_content'] = $this->load->view('admin/accounts/all_accounts_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function updateFee()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->history_dao->updateBookingChargeByRef($input_data['refId'],$input_data['bookingCharge']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }
}