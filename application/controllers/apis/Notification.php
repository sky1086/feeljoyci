<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller{
	 
	function __construct(){
		parent::__construct();
		//$this->authentication->isLoggedIn();
		error_reporting(0);
		$this->load->model(array('authentication', 'notification_model'));
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

	public function isSubscribed(){
		$loginData = $this->authentication->checkLogin(array(ACCOUNT_LISTENER, ACCOUNT_USER));
		if(!$loginData){
			$loginData = ['error'=> true, 'login'=>'required'];
			echo json_encode($loginData);
			exit();
		}

		$contactedUsers = $this->notification_model->getSubscriberDetails($this->session->userdata('userid'));
		if($contactedUsers){
			echo json_encode(['error'=> false, 'result'=>true]);
		}else{
			echo json_encode(['error'=> false, 'result'=>false]);
		}
	}
}
?>