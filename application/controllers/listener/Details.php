<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
class Details extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	$this->load->model(array('authentication', 'listener/listener_model'));
    	//$this->authentication->isLoggedIn(array(ACCOUNT_USER));
    }

    public function index($id){ 
    	$data['listener'] = $this->listener_model->getDetailByID($id);
    	$this->load->view('listener/details_view', $data);	
	   }

    public function details($id){ 
    		
	   }

//build advertiser form

}
?>