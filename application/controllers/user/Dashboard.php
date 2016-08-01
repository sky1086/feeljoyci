<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	$this->authentication->isLoggedIn(array(ACCOUNT_USER));  
		$this->load->model(array('dashboard_model', 'chat/chat_model'));
	    }

    public function index(){   	
		$this->load->view('user/dashboard_view');	
	   }
}
?>