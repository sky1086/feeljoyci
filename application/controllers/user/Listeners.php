<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listeners extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('user/listeners_model'));
	    }

    public function index(){
    	$data['listeners'] = $this->listeners_model->getListeners();
    	
    	$isSpamUser = $this->chat_model->isSpamUser($this->session->userdata('userid'));//var_dump($isSpamUser);exit;
    	if ($isSpamUser){
    		$data['isSpamUser'] = $isSpamUser;
    	}
		$this->load->view('user/listeners_view', $data);	
	   }
	   
   public function reportSpamUser(){
	   	$data = array();
	   	$id = (int)$_POST['uid'];
	   	$data['userid'] = $id;
	   	$data['Listenerid'] = $this->session->userdata('userid');
	   	$data['comment'] = $_POST['comments'];
	   	$this->listeners_model->addSpamUser($data);
   		echo 1;
   }
}
?>