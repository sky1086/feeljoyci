<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
class Dashboard extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	$this->load->model(array('authentication', 'chat/chat_model'));
    	$this->authentication->isLoggedIn(array(ACCOUNT_LISTENER));
    }

    public function index(){ 
    	$this->load->view('listener/dashboard_view');	
	   }

//build advertiser form

}
?>