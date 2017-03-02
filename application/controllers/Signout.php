<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signout extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('authentication');
		if (isset($_SERVER['HTTP_ORIGIN'])) {
			// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
			// you want to allow, and if so:
			header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}else{
			header('Access-Control-Allow-Origin: *'); //need to remove after developement done
		}
		//$this->authentication->isLoggedIn();
	}

	public function index(){
		$logSessArr = $this->session->userdata;
		$this->session->sess_destroy();
		if(isset($_COOKIE['sp_u']) && isset($_COOKIE['sp_p'])){
			setcookie("sp_u", "", time()-60*60*24*100, "/");
			setcookie("sp_p", "", time()-60*60*24*100, "/");
		}
		//setcookie("ThemeColor", "", time()-60*60*24*100, "/");
		//redirect('login');
		echo json_encode(['error'=>null, 'message'=>'Logout successfully.']);
	}
}
?>