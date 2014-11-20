<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Call extends CI_Controller
{

    public function index()
    {

    }


    function getLiveCalls(){

        $calls = $this->call_dao->getLiveCalls();
        $this->output->set_output(json_encode($calls));

    }
}