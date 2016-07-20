<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(0);
class Signup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->authentication->redirect2Dash();
        $this->load->model(array('signup_model','login_model'));
        $this->load->library(array(
            'form_validation'
        ));
    }
    
    public function user()
    {
    	$data['successmsg'] = '';
    	$data['errmsg'] = '';
    	$data['step'] = 1;
    	$this->load->view('usersignup_view', $data);
    }
    
    public function adduser()
    {
        $submitAdd     = $this->security->xss_clean($this->input->post('step'));
        $data['successmsg'] = '';
        $data['errmsg'] = '';
        $submitAdd = (int)$submitAdd;
        if($submitAdd == 0){
        	$submitAdd = 1;
        	$data['step'] = '1';
        }
        
        if ($submitAdd == '1') {
        	$this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
	        if ($this->form_validation->run() == TRUE) {
	        	$user['email']  		= $this->security->xss_clean($this->input->post('email'));
	        	if($this->signup_model->isUserExists($user['email'])){
	        		$data['errmsg'] = 'User already exists.';
	        		$data['step'] = '1';
	        	}
	        	
	            $user['password']       = md5($this->security->xss_clean($this->input->post('password')));
	            $user['user_type']	= 'User';
	            $user['contact_name'] = 'Anonymous';
	            
	            if(empty($data['errmsg'])){
	           		$result = $this->signup_model->addSystemUser($user);
	           		if($result){
	           			$data['successmsg'] = 'User added successfully.';
	           			$data['step'] = '2';
	           			$data['n_email'] = $user['email'];
	           		}else{
	           			$data['errmsg'] = 'Something went wrong, please try again.';
	           		}
	            }
	      }
        }elseif ($submitAdd == '2'){
        	
        	$this->form_validation->set_rules('gender', 'Gender', 'required');
        	$this->form_validation->set_rules('age', 'Age', 'required');
        	//$this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric');
        	if ($this->form_validation->run() == TRUE) {
        		$emailid  		= $this->security->xss_clean($this->input->post('email'));
        		if(!$this->signup_model->isUserExists($emailid)){
        			$data['errmsg'] = 'Please enter valid email id.';
        		}
        		
        		if(empty($data['errmsg'])){
	        		$user['contact_name']	= $this->security->xss_clean($this->input->post('contact_name'));
	        		//$user['phone']			= $this->security->xss_clean($this->input->post('mobile'));
	        		$user['age']	= $this->security->xss_clean($this->input->post('age'));
	        		$user['gender']	= $this->security->xss_clean($this->input->post('gender'));
	        		$user['user_type']	= 'User';
	        		 
	        		if(empty($data['errmsg'])){
	        			$result = $this->signup_model->updateSystemUserByMail($emailid, $user);
	        			if($result){
	        				$this->login_model->forceUserLogin($emailid);
	        				$this->authentication->redirect2Dash();
	        				//$data['successmsg'] = 'User details added successfully.';
	        			}else{
	        				$data['errmsg'] = 'Something went wrong, please try again.';
	        			}
	        		}
        		}
        }
        }
        
        $data['menu'] = 'users';
        $this->load->view('usersignup_view', $data);
    }
}
?>