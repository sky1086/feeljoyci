<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(0);
class Chat extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$frndid = (int)$this->uri->segment(4);
		if($frndid)
			$this->session->set_userdata('listenerid', $frndid);
		$this->authentication->isLoggedIn(array(ACCOUNT_USER));
		//$this->load->model(array('chat/chat_model'));
	}
	
	public function index($id){
		if(!$id){
			redirect('user/listeners');
		}
		$data['list_id'] = $id;
		$this->load->view('user/chat_view1', $data);
	}
}




?>