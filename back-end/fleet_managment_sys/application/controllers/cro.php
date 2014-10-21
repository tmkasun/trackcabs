<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro extends CI_Controller
{

    public function index()
    {
        $this->load->view('cro/cro_main');
    }

}