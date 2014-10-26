<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro extends CI_Controller
{

    public function index()
    {


        $data = $this->live_dao->getCroBookingsToday('niro');
        foreach($data as $key){
            var_dump($key);
        }


        $this->load->view('cro/cro_main');
    }

}