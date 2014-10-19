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
    function __construct(){
        parent::__construct();
        $this->logPath = ini_get('error_log');
    }

    /**
     * index: Shows the php error log
     * @access public
     */
    public function debug(){
//        show_error('message' , 500  );
//        log_message("info","hmmm");
//        print_r();
        echo nl2br(@file_get_contents("application/logs/log-2014-10-19.php"));
        exit;
    }


    function geo_names(){
        $this->load->model('geo_name');
        $geo_names = $this->geo_name->find(12321);

    }

    function php_info(){
        phpinfo();
    }
}