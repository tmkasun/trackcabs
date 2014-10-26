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
        $this->load->model('geo_name');
        $this->load->model('live_dao');
        $this->mongodb = new MongoClient();
    }

    /**
     * index: Shows the php error log
     * @access public
     */
    public function debug(){
//        show_error('message' , 500  );
//        log_message("info","hmmm");
//        print_r();
        $today = getdate();
        $logFile = "application/logs/log-".$today['year']."-".$today['mon']."-".$today['mday'].".php";
        echo nl2br(@file_get_contents($logFile,false,null,(filesize ($logFile) - 500*10)));
        exit;
    }


    function geo_names(){
        $POST = $this->input->get();
        $query = $POST['location'];
        $geo_names = $this->geo_name->find($query);
        header('Content-Type: application/json');
        echo $geo_names;
    }

    function new_orders(){
        $new_orders = $this->live_dao->getAllBookings();

        $this->load->view("panels/new_orders",array('orders'=>$new_orders));
    }

    function php_info(){
        phpinfo();
    }


    function send(){
        $this->load->library('sms');
        $sms = new Sms("Testing message");
        $sent = $sms->send("0711661919","Testing message");
        var_dump($sent);
    }

    function nextId($name){
        print_r($this->counters_dao->getNextId($name));
    }

    function createUser($uName,$pass){
        var_dump($this->users_dao->create($uName,$pass));
    }

    function userAuth($username = 'kasun', $pass = 'pasd'){
        $searchQuery = array('uName' => 'kasun', 'pass' => 'pasd');
        var_dump($this->mongodb->track->users->findOne($searchQuery));
    }
}