<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!isset($_SESSION)) {
	session_start();
}

class Login extends CI_Controller {

	public function index() {

        $user = $this->session->userdata('user');
//        var_dump($user['user_type']);
        if (is_user_logged_in()) {
            if($user['user_type']=='dispatcher')
                redirect('dispatcher', 'refresh');
            if($user['user_type'] == 'admin'){
                redirect('admin', 'refresh');
            }
            if($user['user_type'] == 'cro'){
                redirect('cro_controller', 'refresh');
            }
		} else {
            $this -> load -> helper(array('form'));
			$this -> load -> view('login/index');
		}
	}

	public function logout() {
		$this -> session -> unset_userdata('logged_in');
		session_destroy();
		redirect(base_url(), 'refresh');
	}

    public function authenticate(){

        $userName = $this->input->post('username');
        $pass = $this->input->post('password');
        $result = $this->user_dao->authenticate($userName,$pass);

        if($result != null ){
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('user', $result);
        }

        $this->index();
    }

}
?>