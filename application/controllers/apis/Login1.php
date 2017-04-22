<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	 
	function __construct(){
		parent::__construct();
		//$this->authentication->isLoggedIn();
		$this->load->model(array('authentication', 'login_model', 'chat/chat_model'));
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
			// you want to allow, and if so:
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}else{
			header('Access-Control-Allow-Origin: *'); //need to remove after developement done
		}
	}
	
	public function index(){
		$username = $this->security->xss_clean($this->input->post('username'));//$_POST['username'];
		$password = $this->security->xss_clean($this->input->post('password'));//$_POST['password'];
		
		$response = [];
		if(empty($username) || empty($password) || !$username || !$password){
			$response['error'] = true;
			$response['message'] = 'Username or Password can not be empty.';
			echo json_encode($response);exit;
		}
		// Validate the user can login
		//$password = md5($password);
		$result = $this->login_model->validate($username, $password);
		if(! $result){
			// If user did not validate, then show them login page again
			$response['error'] = true;
			$response['message'] = 'Invalid username or password';
			echo json_encode($response);exit;
		}else{			
			if($this->session->userdata('validated')){//var_dump($this->session->userdata);exit;
				$userData['userid'] = $this->session->userdata('userid');
				$userData['username'] = $this->session->userdata('username');
				$userData['contactname'] = $this->session->userdata('contact_name');
				$userData['email'] = $this->session->userdata('email');
				$userData['profileimage'] = base_url().'pics_listener/'.$this->session->userdata('profile_img');
				$userData['usertype'] = $this->session->userdata('usertype');
				$response['error'] = false;
				$response['message'] = 'Login Successful!';
				$response['userdata'] = $userData;
				echo json_encode($response);exit;
			}else{
				$response['error'] = true;
				$response['message'] = 'Something went wrong.';
				echo json_encode($response);exit;
			}
		}
	}
}