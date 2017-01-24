<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listener extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
    	error_reporting(0);
        $this->load->model(array('authentication', 'chat/chat_model'));        
		header('Access-Control-Allow-Origin: *'); //need to remove after developement done
	    }
	    
	    public function isLoggedIn(){
	    	$loginData = $this->authentication->checkLogin(array(ACCOUNT_LISTENER));
	    	if(!$loginData){
	    		$loginData = ['error'=> true, 'login'=>'required'];
	    	}
	    	echo json_encode($loginData);
	    }

	    public function userlist(){
	    	$loginData = $this->authentication->checkLogin(array(ACCOUNT_LISTENER));
	    	if(!$loginData){
	    		$loginData = ['error'=> true, 'login'=>'required'];
	    		echo json_encode($loginData);
	    		exit();
	    	}
	    	
	    	$contactedUsers = $this->chat_model->getContactedUsers($this->session->userdata('userid'));
	    	if(!count($contactedUsers)){
	    		echo json_encode(['error'=> true, 'result'=>null]);
	    	}
	    	
	    	$result = [];
	    	foreach ($contactedUsers as $user){
	    		$user = $user[0];
	    		$row = [
	    				'userid'=> $user['userid'],
	    				'user_type'=> $user['user_type'],
	    				'age'=> $user['age'],
	    				'contact_name'=> $user['contact_name'],
	    				'profile_img'=> $user['profile_img'],
	    				'gender'=> $user['gender'],
	    				'chat_link'=> base_url().'listener/chat/index/'.$user['userid']
	    		];
	    		$result[] = $row;
	    	}
	    	echo json_encode(['error'=> false, 'result'=>$result]);
	    	
	    	//echo json_encode($result);	
	    }
}
?>