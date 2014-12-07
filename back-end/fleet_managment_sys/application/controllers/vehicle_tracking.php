<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();

class Vehicle_tracking extends CI_Controller
{
    function index(){
        $this->load->view('tracking/map');
    }
}
