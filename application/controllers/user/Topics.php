<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topics extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('admin/category_model'));
	    }

    public function index(){
    	//check desktop and redirect
    	$this -> load -> library('Mobile_Detect');
    	$detect = new Mobile_Detect();echo '<pre>';
    	if (!$detect->isMobile()  && !$detect->isTablet() && !$detect->isAndroidOS()) {
    		header("Location: ".$this->config->item('base_url')."desktop"); exit;
    	}
    	
    	
    	$data['topics'] = $this->category_model->getAllThemes();
    	$this->session->set_userdata(array('theme'=>'cssth0'));
		$this->load->view('user/topics_view', $data);
	   }
	   
	   public function sub($id = 0){
	   	$id = (int)$id;
	   	if($id > 0){
	   		$data['category'] = $this->category_model->getCategoryDetails($id);
	   		$data['topics'] = $this->category_model->getAllThemes($id);
	   		$this->session->set_userdata(array('theme'=>'cssth0'));
	   		$this->load->view('user/subtopics_view', $data);
	   	}
	   }
}
?>