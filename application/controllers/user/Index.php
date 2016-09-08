<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
	    }

    public function index(){
		$this->load->view('user/index_view');
	   }
}
?>