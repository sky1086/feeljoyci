<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topics extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('admin/question_model', 'admin/category_model'));
		header('Access-Control-Allow-Origin: *'); //need to remove after developement done
	    }

    public function firstclick(){
    	$data['topics'] = $this->category_model->getAllThemes();
    	$this->session->set_userdata(array('theme'=>'cssth0'));
		echo json_encode($data['topics']);
		//$this->load->view('user/topics_view', $data);
	   }
	   
	   public function secondclick($id = 0){
	   	$id = (int)$id;
	   	if($id > 0){
	   		$data['category'] = $this->category_model->getCategoryDetails($id);
	   		$data['topics'] = $this->category_model->getAllThemes($id);
	   		$this->session->set_userdata(array('theme'=>'cssth0'));
	   		//$this->load->view('user/subtopics_view', $data);
	   	}else{
			   echo 'First click id required';
			   $data = [];
		   }
		   echo json_encode($data);
	   }
	   public function thirdclick($id = 0){
	   	$id = (int)$id;
		   $data = [];
	   	if($id > 0){
	   		$data['category'] = $this->category_model->getCategoryDetails($id);
	   		$data['questions'] = $this->question_model->getAssocQuestionDetails($id);
	   		if(empty($data['category'][0]->thirdclick) && !empty($data['questions'])){
	   			$this->answer($id, $data['questions'][0]->id);
				   exit;
	   		}
	   	}
		   	echo json_encode($data);
	   }
	   
	   public function answer($catid,$id){
	   	$id = (int)$id;
		   $data = [];
	   	if($id > 0){
	   		$data['category'] = $this->category_model->getCategoryDetails($catid);
	   		$data['questions'] = $this->question_model->getQuestionDetails($id);
	   		//$this->load->view('user/answer_view', $data);
	   	}
		   echo json_encode($data);
	   }
}
?>