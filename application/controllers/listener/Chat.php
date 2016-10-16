<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
class Chat extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	$this->load->model(array('authentication', 'chat/chat_model'));
    	$this->authentication->isLoggedIn(array(ACCOUNT_LISTENER));
    }

    public function index($id){ 
    	$data['toid'] = (int)$id;
    	if($data['toid']){
    		$isSpamUser = $this->chat_model->isSpamUser($data['toid']);//var_dump($isSpamUser);exit;
    		if ($isSpamUser){
    			redirect(base_url().'listener/dashboard');exit;
    		}
    		$this->load->view('user/chat_view', $data);
    	}
	   }

//build advertiser form

}
?>