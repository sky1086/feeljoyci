<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('admin/question_model', 'admin/category_model'));
	    }

	   public function index($id = 0){
	   	$id = (int)$id;
	   	if($id > 0){
	   		$data['category'] = $this->category_model->getCategoryDetails($id);
	   		$data['questions'] = $this->question_model->getAssocQuestionDetails($id);
	   		if(empty($data['category'][0]->thirdclick) && !empty($data['questions'])){
	   			$this->answer($id, $data['questions'][0]->id);
	   		}else{
	   			$this->load->view('user/questions_view', $data);
	   		}
	   	}
	   }
	   
	   public function answer($catid,$id){
	   	$id = (int)$id;
	   	if($id > 0){
	   		$data['category'] = $this->category_model->getCategoryDetails($catid);
	   		$data['questions'] = $this->question_model->getQuestionDetails($id);
	   		$this->load->view('user/answer_view', $data);
	   	}
	   }
}
?>