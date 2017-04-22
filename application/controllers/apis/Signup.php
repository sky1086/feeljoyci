<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	//error_reporting(0);
	class Signup extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			//$this->session->set_userdata(array('redirecturl'=>null));
			//$this->authentication->redirect2Dash();
			$this->load->model(array('signup_model','login_model'));
		}

		public function user()
		{
			$data['successmsg'] = '';
			$data['errmsg'] = '';
			$data['step'] = 1;
			//$this->load->view('usersignup_view', $data);
		}

		public function index()
		{
			$data['message'] = 'Something went wrong, please try again.';
			$data['error'] = true;

			$user['email'] = $this->security->xss_clean($this->input->post('email'));
			if(empty($user['email'])){
				$data['message'] = 'Email/Username is required.';
				echo json_encode($data);
				exit;
			}
			if (filter_var($user['email'], FILTER_VALIDATE_EMAIL) === false) {
				$data['message'] = 'Enter valid email.';
				echo json_encode($data);
				exit;
			}
			
			if($this->signup_model->isUserExists($user['email'])){
				$data['message'] = 'User already exists.';
				echo json_encode($data);
				exit;
			}

			$password = $this->security->xss_clean($this->input->post('password'));
			if(!$password){
				$data['message'] = 'Password is required.';
				echo json_encode($data);
				exit;
			}
			$user['password'] = password_hash($password, PASSWORD_DEFAULT);
			$user['user_type'] = 'User';
			$user['contact_name']	= 'Anonymous';
			
			$result = $this->signup_model->addSystemUser($user);
			if($result){
				$this->login_model->forceUserLogin($user['email']);
				$data['message'] = 'User signup successfully.';
				$data['error'] = false;
				echo json_encode($data);
				exit;
			}else{
				echo json_encode($data);
				exit;
			}
		}
		
		public function details(){
			$data['message'] = 'Something went wrong, please try again.';
			$data['error'] = true;
			
			$emailid = $this->security->xss_clean($this->input->post('email'));
			if(empty($emailid)){
				$data['message'] = 'Email/Username is required.';
				echo json_encode($data);
				exit;
			}
			if (filter_var($emailid, FILTER_VALIDATE_EMAIL) === false) {
				$data['message'] = 'Enter valid email.';
				echo json_encode($data);
				exit;
			}
			
			$contact_name = $this->security->xss_clean($this->input->post('contact_name'));
			$user['contact_name']	= $contact_name?$contact_name:'Anonymous';
			$user['age']	= $this->security->xss_clean($this->input->post('age'));
			$user['gender']	= $this->security->xss_clean($this->input->post('gender'));
			$user['user_type']	= 'User';
			$result = $this->signup_model->updateSystemUserByMail($emailid, $user);
			if($result){
				if($this->session->userdata('contact_name')){
					$this->session->set_userdata(array('contact_name'=>$user['contact_name']));
				}
				$data['message'] = 'Details saved successfully.';
				$data['error'] = false;
				echo json_encode($data); exit;
			}else{
				echo json_encode($data); exit;
			}
		}
	}
	?>