<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_controller extends CI_Controller
{
    function getAllAccountsView()
    {
        $data = $this->history_dao->getBookingFees();
        $data['table_content'] = $this->load->view('admin/accounts/all_accounts_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getAccountsViewByDriverId()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->history_dao->getBookingFeesByDriverId($input_data['driverId']);
        $data['table_content'] = $this->load->view('admin/accounts/all_accounts_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function updateFee()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->history_dao->updateBookingChargeByRef($input_data['refId'],$input_data['bookingCharge']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }
    
    function getAccountsNavBarView(){
               
        $table_data['x'] = 1;
        
//        $input_data = json_decode(trim(file_get_contents('php://input')), true);
//        $user_type = $input_data['user_type'];
        
        $data['table_content'] = $this->load->view('admin/accounts/accounts_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    
    function getSidePanelView(){
        $table_data['x'] = 1;
        
//        $input_data = json_decode(trim(file_get_contents('php://input')), true);
//        $user_type = $input_data['user_type'];
        
        $data['table_content'] = $this->load->view('admin/accounts/accounts_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getBookingsByDateRange(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $startDate = new MongoDate(strtotime($input_data['startDate']));
        $endDate = new MongoDate(strtotime($input_data['endDate']));
        $userId = $input_data['userId'];
        $cabId = $input_data['cabId'];
        $historyCursor = $this->history_dao->getBookingsByDateRange($startDate,$endDate,$userId,$cabId);
        $liveCursor = $this->live_dao->getBookingsByDateRange($startDate,$endDate,$userId,$cabId);
        $data= array('data'=> array());
        foreach ($liveCursor as $booking) {
            $data['data'][]= $booking;
        }
        foreach ($historyCursor as $booking) {
            $data['data'][]= $booking;
        }

        $data['table_content'] = $this->load->view('admin/reports/summary_table', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));
    }

    function getSummaryView(){
        $driverIds = $this->user_dao->getUserIds_by_type('driver');
        $cabIds = $this->cab_dao->getCabIds();
        $data['driverIds'] = $driverIds;
        $data['cabIds'] = $cabIds;
        $data['table_content'] = $this->load->view('admin/reports/summary_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }
}