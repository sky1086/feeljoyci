<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 class Logout extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('authentication');
        $this->authentication->isLoggedIn();
    }
    
    public function index(){
    	$logSessArr = $this->session->userdata;
        $this->session->sess_destroy();
        if(isset($_COOKIE['sp_u']) && isset($_COOKIE['sp_p'])){
        	setcookie("sp_u", "", time()-60*60*24*100, "/");
        	setcookie("sp_p", "", time()-60*60*24*100, "/");
        }
        redirect('login');
    }        
 }
 ?>