<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('authentication', 'admin/question_model', 'admin/category_model', 'user/listeners_model', 'user_model'));
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
	    
	    public function isLoggedIn(){
	    	$loginData = $this->authentication->checkLogin(array(ACCOUNT_USER));
	    	if(!$loginData){
	    		$loginData = ['error'=> true, 'login'=>'required'];
	    	}
	    	echo json_encode($loginData);
	    }

	    public function listeners(){
	    	$data = $this->listeners_model->getListeners();
	    	 
	    	/*$isSpamUser = $this->chat_model->isSpamUser($this->session->userdata('userid'));//var_dump($isSpamUser);exit;
	    	if ($isSpamUser){
	    		$data['isSpamUser'] = $isSpamUser;
	    	}*/
	    	$result = [];
	    	foreach ($data as $row){
	    		$resultRow = [];
	    		
	    		$resultRow['id'] = $row['id'];
	    		$resultRow['name'] = $row['name'];
	    		$resultRow['qualification'] = $row['qualification'];
	    		$resultRow['profile_img'] = base_url().'pics_listener/'.$row['profile_img'];
	    		$resultRow['link'] = base_url().'user/chat/index/'.$row['id'];	
	    		$resultRow['profile_link'] = base_url().'listener/details/index/'.$row['id'];
	    		$resultRow['priority'] = $row['priority'];
	    		$result[] = $resultRow;
	    	}
	    	echo json_encode($result);	
	    }
	    
	    public function details($id){
	    	$id = (int)$id;
	    	if(empty($id)){
	    		echo json_encode(array('error'=> true, 'msg'=>'Invalid parameters.'));
				exit;
	    	}

			$loginData = $this->authentication->checkLogin(array(ACCOUNT_USER));
	    	if(!$loginData){
	    		$loginData = ['error'=> true, 'login'=>'required'];
	    	}
	    	echo json_encode($loginData);
			exit;
	    
	    	$data = $this->user_model->getUserDetails($id);
	    	$result = [];
	    	if(isset($data['userid'])){
	    		$result['userid'] = $data['userid'];
	    		$result['contact_name'] = $data['contact_name'];
	    		$result['email'] = $data['email'];
	    		$result['gender'] = $data['gender'];
	    		$result['age'] = $data['age'];
	    		$result['user_type'] = $data['user_type'];
	    		$result['username'] = $data['username'];	    		
	    	}
	    	echo json_encode(array('error'=> false, 'data'=>$result));
	    	exit;
	    }
}
?>