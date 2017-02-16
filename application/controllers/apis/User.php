<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('authentication', 'admin/question_model', 'admin/category_model', 'user/listeners_model'));
		header('Access-Control-Allow-Origin: *'); //need to remove after developement done
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
}
?>