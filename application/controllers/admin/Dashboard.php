<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller{
   
    function __construct(){
        parent::__construct();
		$this->load->model('authentication');
    	//$this->authentication->isLoggedIn();  
		$this->load->model('dashboard_model');
	    }

    public function index(){
		$this->load->view('admin/dashboard_view');
    }
}
?>