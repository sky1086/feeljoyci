<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My404 extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header('404');
		include_once('/404.html');	
	}
}