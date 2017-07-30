<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->authentication->isLoggedIn(array(ACCOUNT_ADMIN));
		$this->load->model(array('admin/monitor_model'));
		$this->load->library('mail');
	}
	
	public function index(){
		$data['listeners'] = $this->monitor_model->getListenersMonitoringDetails();
		$this->load->view('admin/monitor_view', $data);
	}
	
	public function notifybyemail(){
		$listenerId = 0;
		$unreadMsg = 0;
		
		if ($this->input->post('listenerId')) {
			$listenerId = $this->input->post('listenerId');
		}
		if ($this->input->post('unreadMsg')) {
			$unreadMsg = $this->input->post('unreadMsg');
		}
		
		$response = '';
		if($listenerId && $unreadMsg){
			$result = $this->monitor_model->verifyListener($listenerId);
			
			if(count($result)){
				$this->load->config('email_conf');
				$title = 'Feeljoy: you have unread message(s)';
				$mailTemplate = $this->config->item('notifyListenersHavingUnreadMsg');
				$mailTemplate = str_replace('##BUDDYNAME##', $result[0]->contact_name, $mailTemplate);
				$mailTemplate = str_replace('##UNREADMSG##', $unreadMsg, $mailTemplate);
				$mailSent = $this->mail->send($result[0]->email, $title, $mailTemplate);
				//var_dump($mailSent);
				if($mailSent){
					$response = 'Listener notified successfully.';
				}else {
					$response = 'Unable to sent email to listener.';
				}
			}else{
				$response = 'Invalid details, this listener is not registered with us.';
			}
		}
		echo $response;
	}
}
?>