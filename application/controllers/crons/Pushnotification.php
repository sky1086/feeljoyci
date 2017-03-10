<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pushnotification extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model(array(
        		'chat/chat_model', 'notification_model', 'user_model'
        ));
    }

    public function index(){
    	ini_set('display_errors', 'On');
		error_reporting(E_ALL);
    	$dataToBeNotified = $this->chat_model->getUnreadMsgForNotification();echo '<pre>'; var_dump('$dataToBeNotified  ', $dataToBeNotified);
    	foreach ($dataToBeNotified as $notif_user => $notif_data){
    		if($notif_data['notified']){
    			continue;
    		}
    		var_dump('$notif_data   ', $notif_data);
    		//Get subscriber details
    		$subscriberData = $this->notification_model->getSubscriberDetails($notif_data['to']);
    		var_dump('subscriberData    ', $subscriberData);
    		if(!empty($subscriberData)){
    			$senderData = $this->user_model->getUserDetails($notif_data['from']);
    			//$receiverData = $this->user_model->getUserDetails($notif_data['to']);
    			
    			//notification code start here
    			$title = $senderData['contact_name']. ' has sent you message -';
    			$message = $this->chat_model->decodeMsg($notif_data['msg'], $notif_data['int_vec']);
    			if($senderData['user_type'] == 'Listener'){
    				$url = base_url().'user/chat/index/'.$notif_data['from'];
    			}else{
    				$url = base_url().'listener/chat/index/'.$notif_data['from'];
    			}
    			
    			$subscriberId = empty($subscriberData['subscriberid_desktop'])?$subscriberData['subscriberid_mob']:$subscriberData['subscriberid_desktop'];
    			 var_dump('subscriberId   ', $subscriberId);
    			if($subscriberId){
	    			$apiToken = $this->config->item('push_notification_api_token');
	    			 
	    			$curlUrl = 'https://pushcrew.com/api/v1/send/individual/';
	    			 
	    			//set POST variables
	    			$fields = array(
	    					'title' => $title,
	    					'message' => $message,
	    					'url' => $url,
	    					'subscriber_id' => $subscriberId
	    			);
	    			 
	    			$httpHeadersArray = Array();
	    			$httpHeadersArray[] = 'Authorization: key='.$apiToken;
	    			 
	    			//open connection
	    			$ch = curl_init();
	    			 
	    			//set the url, number of POST vars, POST data
	    			curl_setopt($ch, CURLOPT_URL, $curlUrl);
	    			curl_setopt($ch, CURLOPT_POST, true);
	    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
	    			curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeadersArray);
	    			 
	    			//execute post
	    			$result = curl_exec($ch);
	    			 
	    			$resultArray = json_decode($result, true);
	    			 var_dump('resultArray', $resultArray);
					 echo $resultArray['message'];
	    			if($resultArray['status'] == 'success') {
	    				//update notified status on success
	    				$this->chat_model->updateNotifiedStatus($notif_data['id']);
	    			}
	    			else if($resultArray['status'] == 'failure') {
	    				//failure
	    			}
	    			else {
	    				//failure
	    			}
    			}
    			//notification code ends here
    		}
    	}
    	echo 'Done';
    }
    
    public function upsertNotificationUser() {
    	$subid = $_POST['subid'];
    	$d_type = $_POST['d_type'];
    	if($subid){
    		$this->notification_model->addSubscriber($subid, $d_type);
    		echo 1;
    	}
    }
}
?>
