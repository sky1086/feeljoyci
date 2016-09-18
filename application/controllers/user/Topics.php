<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topics extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('admin/category_model'));
	    }

    public function index(){
    	$data['topics'] = $this->category_model->getAllThemes();
		$this->load->view('user/topics_view', $data);
	   }
	   
	   public function sub($id = 0){
	   	$id = (int)$id;
	   	if($id > 0){
	   		$data['category'] = $this->category_model->getCategoryDetails($id);
	   		$data['topics'] = $this->category_model->getAllThemes($id);
	   		$this->load->view('user/subtopics_view', $data);
	   	}
	   }
}
?>