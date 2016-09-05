<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topics extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('user/listeners_model'));
	    }

    public function index(){
    	$data['listeners'] = $this->listeners_model->getListeners();
		$this->load->view('user/topics_view', $data);	
	   }
}
?>