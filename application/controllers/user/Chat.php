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
		$this->load->model(array('user_model'));
	}
	
	public function index($id){
		if(!$id){
			redirect('user/listeners');
		}
		
		$isSpamUser = $this->chat_model->isSpamUser($this->session->userdata('userid'));//var_dump($isSpamUser);exit;
		if ($isSpamUser){
			//redirect(base_url().'user/listeners');exit;
		}
		
		$userdata = $this->user_model->getUserDetails($id);
		
		$data['list_id'] = $id;
		$data['isSpamUser'] = $isSpamUser;
		$data['heading'] = ucfirst($userdata['contact_name']);
		$this->load->view('user/chat_view1', $data);
	}
}




?>