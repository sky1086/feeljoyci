<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listeners extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	$this->authentication->isLoggedIn(array(ACCOUNT_ADMIN));  
		$this->load->model(array('admin/listeners_model','admin/category_model', 'user_model'));
		$this->load->library(array('form_validation'));
	    }

    public function index(){
    	$categoryData = $this->category_model->getAllSubCategories();
    	$data['listeners'] = $this->listeners_model->getAllListeners();
    	$data['categories'] = $categoryData;
		$this->load->view('admin/listener_view', $data);	
	   }
	   
	   public function add(){
   		$data['successmsg'] = '';
   		$data['errmsg'] = '';
   		if($this->input->post('name')){
   			//$this->form_validation->set_rules('qualification', 'Qualification', 'required');
   			$this->form_validation->set_rules('name', 'Name', 'required');
   			$this->form_validation->set_rules('priority', 'Priority', 'required');
   			$this->form_validation->set_rules('status', 'Status', 'required');
   			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
   			$this->form_validation->set_rules('age', 'Age', 'required');
   			$this->form_validation->set_rules('gender', 'Gender', 'required');
   			$this->form_validation->set_rules('description', 'Description', 'required');
   			
   			if ($this->form_validation->run() == TRUE) {
   				//$listData['qualification']  		= $this->security->xss_clean($this->input->post('qualification'));
   				$listData['name']       = $this->security->xss_clean($this->input->post('name'));
   				$listData['interests']       = $this->security->xss_clean($this->input->post('interests'));
   				$listData['tagline']       = $this->security->xss_clean($this->input->post('tagline'));
   				$listData['priority']       = $this->security->xss_clean($this->input->post('priority'));
   				$listData['status']	= $this->security->xss_clean($this->input->post('status'));
   				$listData['age']	= $this->security->xss_clean($this->input->post('age'));
   				$listData['gender']	= $this->security->xss_clean($this->input->post('gender'));
   				$listData['description']	= $this->security->xss_clean($this->input->post('description'));
   				//$listData['mobile']	= $this->security->xss_clean($this->input->post('mobile'));   				
   				$user['email']	= $this->security->xss_clean($this->input->post('email'));
   				$user['contact_name']	= $listData['name'];
   				$user['password']	= $this->security->xss_clean($this->input->post('password'));
   				$user['user_type']	= 'Listener';
   				
   				if(!$user['password']){
   					unset($user['password']);
   				}
   				
   				if(isset($user['password']) && !empty($user['password'])){
   					$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
   				}
   				
   
   				if(empty($data['errmsg'])){
   					$result = $this->user_model->addSystemUser($user);
   					if($result){
   						$listData['id'] = $result;
   						$this->listeners_model->addListener($listData);
   						$data['successmsg'] = 'Listener added successfully.';
   					}else{
   						$data['errmsg'] = 'Something went wrong, please try again.';
   					}
   				}
   			}
   		}
	   	
	   	$this->load->view('admin/listeneradd_view', $data);
	   }
	   
	   public function edit($id){
	   	if(!empty($id)){
	   		$data['successmsg'] = '';
	   		$data['errmsg'] = '';
	   		if($this->input->post('name')){
	   			//$this->form_validation->set_rules('qualification', 'Qualification', 'required');
	   			$this->form_validation->set_rules('name', 'Name', 'required');
	   			$this->form_validation->set_rules('priority', 'Priority', 'required');
	   			$this->form_validation->set_rules('status', 'Status', 'required');
	   			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	   			$this->form_validation->set_rules('age', 'Age', 'required');
	   			$this->form_validation->set_rules('gender', 'Gender', 'required');
	   			$this->form_validation->set_rules('description', 'Description', 'required');
	   			
	   			if ($this->form_validation->run() == TRUE) {
	   				//$listData['qualification']  		= $this->security->xss_clean($this->input->post('qualification'));
	   				$listData['name']       = $this->security->xss_clean($this->input->post('name'));
	   				$listData['interests']       = $this->security->xss_clean($this->input->post('interests'));
	   				$listData['tagline']       = $this->security->xss_clean($this->input->post('tagline'));
	   				$listData['priority']       = $this->security->xss_clean($this->input->post('priority'));
	   				$listData['status']	= $this->security->xss_clean($this->input->post('status'));
	   				$listData['age']	= $this->security->xss_clean($this->input->post('age'));
	   				$listData['gender']	= $this->security->xss_clean($this->input->post('gender'));
	   				$listData['description']	= $this->security->xss_clean($this->input->post('description'));
	   				//$listData['mobile']	= $this->security->xss_clean($this->input->post('mobile'));
	   				$user['email']	= $this->security->xss_clean($this->input->post('email'));
	   				$user['contact_name']	= $listData['name'];
	   				$user['password']	= $this->security->xss_clean($this->input->post('password'));
	   				
	   				if(!$user['password']){
	   					unset($user['password']);
	   				}else{
   						//$user['password'] = md5($user['password']);
	   					$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
   					}
	   
	   				if(empty($data['errmsg'])){
	   					$result = $this->listeners_model->updateListener($id, $listData);
	   					if($result){
	   						$this->user_model->updateSystemUser($id, $user);
	   						$data['successmsg'] = 'Listener updated successfully.';
	   					}else{
	   						$data['errmsg'] = 'Something went wrong, please try again.';
	   					}
	   				}
	   			}
	   		}
	   	}else{
	   		$data['errmsg'] = 'Invalid details.';
	   	}
	   	$data['listener'] = $this->listeners_model->getListenerDetails($id);
	   	$data['listener'] = $data['listener'][0]; 
	   	$userData = $this->user_model->getUserDetails($id);
	   	$data['listener']->email = $userData['email'];
	   	
	   	$this->load->view('admin/listeneredit_view', $data);
	   }
	   
	   public function catassoc(){
	   	$categories = '';
	   	$lid = '';
	   	 
	   	if ($this->input->post('qid')) {
	   		$lid = $this->input->post('qid');
	   	}
	   	if ($this->input->post('categories')) {
	   		$string = $this->input->post('categories');
	   	}
	   	 
	   	$view_data = $this->listeners_model->assocCatListener($string, $lid);
	   	echo $view_data;
	   }
}
?>