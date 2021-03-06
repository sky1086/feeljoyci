<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
class Userlist extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	$this->load->model(array('authentication'));
    	$this->authentication->isLoggedIn(array(ACCOUNT_LISTENER));
    }

    public function index(){ 
    	$contactedUsers = $this->chat_model->getContactedUsers($this->session->userdata('userid'));
    	$data['contactedUsers'] = $contactedUsers;
    	$this->load->view('listener/userlist_view', $data);	
	   }

//build advertiser form

}
?>