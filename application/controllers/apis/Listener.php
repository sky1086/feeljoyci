<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listener extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
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
	    	echo json_encode($contactedUsers[0]);
	    	
	    	//echo json_encode($result);	
	    }
}
?>