<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listener extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
    	error_reporting(0);
        $this->load->model(array('authentication', 'chat/chat_model', 'listener/listener_model', 'user/listeners_model'));
        if (isset($_SERVER['HTTP_ORIGIN'])) {
        	// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        	// you want to allow, and if so:
        	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        	header('Access-Control-Allow-Credentials: true');
        	header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }else{
        	header('Access-Control-Allow-Origin: *'); //need to remove after developement done
        }
        header("X-Frame-Options: SAMEORIGIN");
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
	    
	    public function details($id){
	    	$id = (int)$id;
	    	if(empty($id)){
	    		echo json_encode(array('error'=> true, 'msg'=>'Invalid parameters.'));
				exit;
	    	}
	    	
	    	$data = $this->listener_model->getDetailByID($id);
	    	if(isset($data['id'])){
	    		$data['profile_img'] = base_url().'pics_listener/'.$data['profile_img'];	    		
	    	}
	    	echo json_encode(array('error'=> false, 'data'=>$data));	    	
	    }
	    
	    public function markSpamUser(){
	    	$data = array();
	    	$id = (int)$_POST['uid'];
	    	$data['userid'] = $id;
	    	if($id > 0 && $this->session->userdata('userid') > 0){
	    		$data['Listenerid'] = $this->session->userdata('userid');
	    		$data['comment'] = $_POST['comments'];
	    		$this->listeners_model->addSpamUser($data);
	    		echo json_encode(array('error'=> false, 'msg'=>'User spamed.'));
	    	}else{
	    		echo json_encode(array('error'=> true, 'msg'=>'Invalid Parameters.'));
	    	}
	    }
	    
	    public function userlistUnreadMsg(){
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
	    		
	    	$userMsgDetails = $this->chat_model->getLastMsgFromUsr($user['userid'], $this->session->userdata('userid'));
	    	$userUnreadMsgCount = $this->chat_model->getUnreadMsgFromUsr($user['userid'], $this->session->userdata('userid'));
	    	$userMsgDetails['msg'] = $this->chat_model->decodeMsg($userMsgDetails['msg'], $userMsgDetails['int_vec']);
	    	//var_dump($userMsgDetails);
	    	if($userMsgDetails){
	    		$row['time'] = date('c', strtotime($userMsgDetails['time']));
	    		$row['lastMsg'] = trim($userMsgDetails['msg']);
	    	}else{
	    		$row['time'] = date('c', strtotime($userMsgDetails['time']));
	    		$row['lastMsg'] = trim($userMsgDetails['msg']);
	    	}
	    	
	    	
	    	$row['unreadMsgCount'] = $userUnreadMsgCount;
	    	
	    	$result[$row['time']] = $row;	    	
	    }
	    krsort($result);
	    $finalresult = [];
	    foreach ($result as $resRow){
	    	$finalresult[] = $resRow;
	    }
	    echo json_encode(['error'=> false, 'result'=>$finalresult]);
	    exit;
	    }
}
?>