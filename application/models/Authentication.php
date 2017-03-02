<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
	public function isLoggedIn($allowed){
		//valid users who can login into system interface
		$allowedUser = array(ACCOUNT_USER, ACCOUNT_ADMIN, ACCOUNT_LISTENER);
		
		if(!empty($allowed))
		$allowedUser = $allowed;
		
		$validusers = in_array($this->session->userdata('usertype'),$allowedUser);
		//var_dump($validusers, $this->session->userdata());exit;
        if(!$this->session->userdata('validated') || empty($this->session->userdata('userid')) || !$validusers){
        	//store url to redirect in case of not logged in
        	$redirecturl = $_SERVER['REQUEST_URI'];
        	if($this->session->userdata('usertype') && !$validusers)
        	{
        		$this->session->sess_destroy();
        	}
        	if(!empty($redirecturl) && stripos($redirecturl, 'login') === FALSE)
        	{//exclude login and datatable page requests
        		$this->session->set_userdata(array('redirecturl'=>base_url().substr($redirecturl,1)));
        	}
            redirect('login');
        }else {
        	$this->setUseridSession();
        	//echo 'loggedin';exit;
        }
    }
    
    public function getCurrentUser()
    {
    	if ($this->session->userdata('username')) {
    		return $this->session->userdata;
    	} 
    	return false;
    }
    
    public function setUseridSession(){
    	$this->db->like('data', '__ci_last_regenerate|i:'.$this->session->userdata('__ci_last_regenerate'), 'after');
    	$this->db->update($this->config->item('sess_save_path'), array('userid'=>$this->session->userdata('userid')));
    }
    
    public function redirect2Dash() {
    	$redirecturl = $this->session->userdata('redirecturl');
    	if(!empty($redirecturl))
    	{
    		$this->session->set_userdata(array('redirecturl'=>null));
    		redirect($redirecturl);
    	}
    	if($this->session->userdata('validated')){//var_dump($this->session->userdata);exit;
    		if($this->session->userdata('usertype') == ACCOUNT_USER){
    			redirect('user/listeners');
    		}elseif($this->session->userdata('usertype') == ACCOUNT_LISTENER){
    			redirect('listener/dashboard');
    		}elseif($this->session->userdata('usertype') == ACCOUNT_ADMIN){
    			redirect('admin/dashboard');
    		}
    	}
    }
    
    public function redirect2ApiDash() {
    	$redirecturl = $this->session->userdata('redirecturl');
    	if(!empty($redirecturl))
    	{
    		$this->session->set_userdata(array('redirecturl'=>null));
    		redirect($redirecturl);
    	}
    	if($this->session->userdata('validated')){//var_dump($this->session->userdata);exit;
    		if($this->session->userdata('usertype') == ACCOUNT_USER){
    			redirect('listeners?');
    		}elseif($this->session->userdata('usertype') == ACCOUNT_LISTENER){
    			header('location: https://buddy.feeljoy.in');
    		}elseif($this->session->userdata('usertype') == ACCOUNT_ADMIN){
    			redirect('admin/dashboard');
    		}
    	}
    }
    
    public function checkLogin($allowed){
    	//valid users who can login into system interface
    	$allowedUser = array(ACCOUNT_USER, ACCOUNT_ADMIN, ACCOUNT_LISTENER);
    
    	if(!empty($allowed))
    		$allowedUser = $allowed;
    
    		$validusers = in_array($this->session->userdata('usertype'),$allowedUser);
    		//var_dump($validusers, $this->session->userdata());exit;
    		if(isset($_COOKIE['sp_u']) && isset($_COOKIE['sp_p']) && !isset($_SESSION['user_type'])){
    			//$this->login_model->validate(base64_decode($_COOKIE['sp_u']), base64_decode($_COOKIE['sp_p']));
    		}
    		
    		if(!$this->session->userdata('validated') || empty($this->session->userdata('userid')) || !$validusers){
    			//store url to redirect in case of not logged in
    			$redirecturl = $_SERVER['REQUEST_URI'];
    			if($this->session->userdata('usertype') && !$validusers)
    			{
    				$this->session->sess_destroy();
    			}
    			if(!empty($redirecturl) && stripos($redirecturl, 'login') === FALSE)
    			{//exclude login and datatable page requests
    				//$this->session->set_userdata(array('redirecturl'=>base_url().substr($redirecturl,1)));
    			}
    			//redirect('login');
    			return false;
    		}else {
    			//$this->setUseridSession();
    			$userData['userid'] = $this->session->userdata('userid');
    			$userData['username'] = $this->session->userdata('username');
    			$userData['contactname'] = $this->session->userdata('contact_name');
    			$userData['email'] = $this->session->userdata('email');
    			$userData['profileimage'] = base_url().'pics_listener/'.$this->session->userdata('profile_img');
    			$userData['usertype'] = $this->session->userdata('usertype');
    			
    			return $userData;
    			//echo 'loggedin';exit;
    		}
    }
}
?>