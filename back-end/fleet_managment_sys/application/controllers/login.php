<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!isset($_SESSION)) {
	session_start();
}

class Login extends CI_Controller {

	public function index() {

        $user = $this->session->userdata('user');
        if (is_user_logged_in()) {
            if($user['user_type']=='dispatcher')
                redirect('dispatcher', 'refresh');
            if($user == 'admin'){
                redirect('admin', 'refresh');
            }
            if($user['user_type'] == 'cro'){
                redirect('cro_controller', 'refresh');
            }
            if($user['user_type'] == 'admin'){
                redirect('admin', 'refresh');
            }
		} else {
            $this -> load -> helper(array('form'));
			$this -> load -> view('login/index');
		}
	}

	public function logout() {
		$this -> session -> unset_userdata('logged_in');
        $this -> session -> unset_userdata('user');
        $this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}

    public function authenticate(){

        $userName = $this->input->post('username');
        $pass = $this->input->post('password');
        if($userName=='admin' && $pass=='admin'){
            $result = array('user_type' => 'admin' , 'uName' => 'admin');
        }else{
            $result = $this->user_dao->authenticate($userName,$pass);
        }
        if($result != null ){
            if(isset($result["blocked"]) && $result["blocked"] == 'true'){
                $this->session->set_userdata('blocked', true);
              }else{
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('user', $result);
              }

        }else{
            $this->session->set_userdata('blocked', false);
        }

        $this->index();
    }

    public function isAdmin(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $statusMsg = "false";
        if($input_data['pass'] == 'admin'){
            $statusMsg = "true";
        }
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));
    }

}
?>