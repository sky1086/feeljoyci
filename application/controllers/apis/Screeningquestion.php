<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Screeningquestion extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		//$this->authentication->isLoggedIn();
		$this->load->model(array('admin/screening_model'));
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
	
	public function get($type){
		ini_set('display_errors', 'On');
		error_reporting('E_ALL');
		if(!empty($type)){
			$data['questions'] = $this->screening_model->getAllScreenQuestOfType($type);
			echo json_encode($data['questions']);
		} else {
			echo json_encode(['error'=> true, 'login'=>'Screen type parameter is required']);
		}
	}
}
?>