<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();

class Vehicle_tracking extends CI_Controller
{
    function index(){
        $this->load->view('tracking/map');
    }

    function login_message(){
        $this->load->view('tracking/modals/login_message');
    }

    function bigdata(){
        $this->load->model('bigdata_dao');
        $data_stats = $this->bigdata_dao->stats();
        $this->load->view('bigdata/index',array('data_stats' => $data_stats));
//        $this->output->set_content_type('application/json');
//        echo $data_stats;
    }
}
