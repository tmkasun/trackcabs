<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();

class Testing extends CI_Controller
{
    private $logPath; //path to the php log
    /**
     *   Class constructor
     */
//    function __construct(){
////        parent::Controller();
//        $this->logPath = ini_get('error_log');
//    }

    /**
     * index: Shows the php error log
     * @access public
     */
    public function testing(){
//        show_error('message' , 500  );
//        log_message("info","hmmm");
//        print_r();
        echo nl2br(@file_get_contents("application/logs/"));
        exit;
    }
}