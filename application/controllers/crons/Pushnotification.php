<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pushnotification extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model(array(
        		'chat/chat_model', 'notification_model', 'user_model'
        ));
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

    public function index($time){
    	//ini_set('display_errors', 'On');
		//error_reporting(E_ALL);
    	$time = (int)$time;
    	if($time == 1){
    		$time = 2;
    	}
    	$dataToBeNotified = $this->chat_model->getUnreadMsgForNotification($time);
    	foreach ($dataToBeNotified as $notif_user => $notif_data){
    		if($notif_data['notified'] || !$notif_data['to']){
    			continue;
    		}
    		
    		//Get subscriber details
    		$subscriberData = $this->notification_model->getSubscriberDetails($notif_data['to']);
    		
    		if(is_array($subscriberData) && sizeof($subscriberData) > 0){
    			$senderData = $this->user_model->getUserDetails($notif_data['from']);
    			//$receiverData = $this->user_model->getUserDetails($notif_data['to']);
    			
    			//notification code start here
    			$title = $senderData['contact_name']. ' has sent you message -';
    			$message = $this->chat_model->decodeMsg($notif_data['msg'], $notif_data['int_vec']);
    			if($senderData['user_type'] == 'Listener'){
    				$url = base_url().'chat?id='.$notif_data['from'];
    			}else{
    				$url = 'https://buddy.feeljoy.in/chat?id='.$notif_data['from'];
    			}
    			
    			//$subscriberId = empty($subscriberData['subscriberid_desktop'])?$subscriberData['subscriberid_mob']:$subscriberData['subscriberid_desktop'];
    			$subscriberId = $subscriberData['userid'];
    			if($subscriberId){
	    			/* $apiToken = $this->config->item('push_notification_api_token');
	    			 
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
	    			$result = curl_exec($ch); */
    				$campaignName = 'Feeljoy_'.$subscriberId.'_'.time();
    				
    				$appId = $this->config->item('push_notification_api_token');
    				
    				$signatureToken = $appId.'|'.$campaignName .'|'.$this->config->item('MOE_SECRET_KEY');
    				$signature = hash('sha256', $signatureToken, false);
    				
    				$curlUrl = 'https://pushapi.moengage.com/v2/transaction/sendpush';
    				
    				//set POST variables
    				$data_string= [
    						"appId"=>$appId,
    					"signature"=>$signature,
    						"campaignName"=> $campaignName,
    						"targetPlatform"=> [
    								"WEB"
    						],
    					"targetAudience"=>"User",
    					"targetUserAttributes"=>[
    					"attribute"=> "USER_ATTRIBUTE_UNIQUE_ID",
    					"comparisonParameter"=> "is",
    					"attributeValue"=> $subscriberId
    					],
    					"payload" => [
    							"WEB"=> [
    							"message"=> $message, // Message
    									"title"=> $title, // title
    							"redirectURL"=> $url, // URL on which user should be redirected on click.
    							"iconURL"=>"", // URL for the icon to be displayed
    							"fallback"=>[ //  replica of the complete dict in case there is personalization failure.
    					]
    					]
    					]
    				];
    				
    				$data_string = json_encode($data_string);
    				
    				$httpHeadersArray = Array();
    				$httpHeadersArray[] = 'Content-Type: application/json';
    				$httpHeadersArray[] = 'Content-Length: ' . strlen($data_string);
    				
    				//open connection
    				$ch = curl_init();
    				
    				//set the url, number of POST vars, POST data
    				curl_setopt($ch, CURLOPT_URL, $curlUrl);
    				curl_setopt($ch, CURLOPT_POST, true);
    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    				curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeadersArray);
    				
    				//execute post
    				$result = curl_exec($ch);
    				var_dump($result);
	    			$resultArray = json_decode($result, true);
					 echo $resultArray['message'];
					 if($resultArray['status'] == 'success' || $resultArray['status'] == 'Success') {
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
    	//$subid = $_POST['subid'];
    	$subid = $this->session->userdata('userid');
    	$d_type = $_POST['d_type'];
    	$status = $_POST['status'];
    	if($subid){
    		$this->notification_model->addSubscriber($subid, $d_type, $status);
    		echo 1;
    	}
    }
}
?>
