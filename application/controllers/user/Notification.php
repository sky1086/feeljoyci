<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller{
   
    function __construct(){
        parent::__construct();  
		//$this->load->model(array('notification_model'));
	    }

    public function index(){   	
		//$this->load->view('user/dashboard_view');
    	$this->load->library('email');
    	
    	$this->email->from('skya.1086@gmail.com', 'Your Name');
    	$this->email->to('skya.1086@gmail.com');
    	//$this->email->cc('another@another-example.com');
    	//$this->email->bcc('them@their-example.com');
    	
    	$this->email->subject('Email Test');
    	$this->email->message('Testing the email class.');
    	
    	$this->email->send();
	   }
}
?>