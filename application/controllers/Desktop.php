<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Desktop extends CI_Controller{
	 
	function __construct(){
		parent::__construct();
		/*$this->load->model('authentication');
		$this->authentication->isLoggedIn();
		$this->load->model('myaccount_model');
		$this->load->library(array('form_validation'));*/
		}

				
public function index()
{
    $this->load->view('desktop_view');
}
}