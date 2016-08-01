<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(0);
class Chat extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->authentication->isLoggedIn(array(ACCOUNT_USER));
		$this->load->model(array('chat/chat_model'));
	}
	
	public function index(){
		$this->load->view('user/chat_view1');
	}
}




?>