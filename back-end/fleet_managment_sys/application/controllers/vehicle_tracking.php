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
}
