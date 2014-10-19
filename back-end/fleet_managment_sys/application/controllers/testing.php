<?php
/*
 * This controller is for testing purpose only ,
 * You may use this for check the log files,
 * do testing with Code Igniter or anything you wish but,
 * please make sure that no other controller or file make dependence on this controller
 * again this controller is ONLY FOR TESTING PURPOSE!!!!
 * */
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