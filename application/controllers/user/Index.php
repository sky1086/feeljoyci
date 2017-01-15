<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
	    }

    public function index(){
    	$this -> load -> library('Mobile_Detect');
    	$detect = new Mobile_Detect();echo '<pre>';
    	if (!$detect->isMobile()  && !$detect->isTablet() && !$detect->isAndroidOS()) {
    		header("Location: ".$this->config->item('base_url')."desktop"); exit;
    	}
		$this->load->view('user/index_view');
	   }
}
?>