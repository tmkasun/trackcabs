<?php
 if (!defined('BASEPATH'))
     exit('No direct script access allowed');
 session_start();
 class Monitor extends CI_Controller {

     public function index() {
         if (!is_user_logged_in()) {
             $this -> load -> view('monitor/index');
         } else {
             //If no session, redirect to login page
             $this -> load -> library('form_validation');
             $this -> form_validation -> set_message('check_database', 'Invalid username or password');
             redirect('login', 'refresh');
         }
     }
 }