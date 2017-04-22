<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guide extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('admin/question_model', 'admin/category_model'));
		$this->load->library(array('common'));
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
			// you want to allow, and if so:
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}else{
			header('Access-Control-Allow-Origin: *'); //need to remove after developement done
		}
	    }

    public function index(){
    	$data['topics'] = $this->category_model->getAllThemes();
    	if(!count($data['topics'])){
    		$response['error'] = null;
    		$response['result'] = 'No data found';
    		echo json_encode($response);
    		exit();
    	}
    	
    	$result = [];
    	$i = 0;
    	foreach ($data['topics'] as $topic){
    		$result[$i]['name'] = $topic->name;
    		$result[$i]['url'] = (!empty($topic->normalized_name)?$topic->normalized_name:$this->common->getNormalizedName($topic->name));
    		$i++;
    	}
    	//var_dump($result);
    	echo json_encode($result);
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