<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pushnotification extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model(array(
        		'chat/chat_model', 'notification_model', 'user_model'
        ));
        $this->load->library('mail');
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
    	ini_set('display_errors', 'On');
		error_reporting(1);
		$newLineSeparator = '   ###   ';
		
		if (!isset($time)){
			$time = 1;
		}
    	$time = (int)$time;
    	if($time == 1){
    		$time = 2;
    	}
    	$dataToBeNotified = $this->chat_model->getUnreadMsgForNotification($time);
    	if(!$dataToBeNotified){
    		echo 'No Pending Msg(s)!';
    		exit;
    	}
    	
    	echo count($dataToBeNotified). ' Unread message(s) found.';
    	foreach ($dataToBeNotified as $notif_user => $notif_data){
    		if($notif_data['notified'] || !$notif_data['to']){
    			continue;
    		}
    		
    		//Get subscriber details
    		$subscriberData = $this->notification_model->getSubscriberDetails($notif_data['to']);
    		
    		$senderId = $notif_data['from'];
    		$receiverID = $notif_data['to'];
    		$lastNotified = $this->notification_model->getLastConversationDateTime($senderId, $receiverID);
    		if($lastNotified){
    			$to_time = strtotime($lastNotified);
    			$from_time = strtotime(date("Y-m-d H:i:s"));
    			$diffMinute = round(abs($from_time- $to_time) / 60,2);
    			echo 'Last notified '.$diffMinute.' minutes ago.'.$newLineSeparator;
    			if($diffMinute < SENDNOTIFICATION_FROM_SAMEUSER_AFTER){
    				echo 'Already notified in last '.SENDNOTIFICATION_FROM_SAMEUSER_AFTER.' minutes: Difference is - '.$diffMinute.$newLineSeparator;
    				continue;
    			}
    		}
    		
    		if(is_array($subscriberData) && sizeof($subscriberData) > 0){
    			$senderData = $this->user_model->getUserDetails($notif_data['from']);
    			//$receiverData = $this->user_model->getUserDetails($notif_data['to']);
    			
    			//notification code start here
    			$title = $senderData['contact_name']. ' has sent you message -';
    			$message = $this->chat_model->decodeMsg($notif_data['msg'], $notif_data['int_vec']);
    			$message = trim($message);
    			$subscriberId = $subscriberData['userid'];
    			
    			$logoUrl = 'https://feeljoy.in/android-chrome-192x192.png';
    			if($senderData['user_type'] == 'User'){
    				$url = 'https://buddy.feeljoy.in/chat/'.$notif_data['from'];
    				$logoUrl = 'https://buddy.feeljoy.in/android-chrome-192x192.png';
    			}else{
    				$url = 'https://feeljoy.in/chat/'.$notif_data['from'];
    			}
    			
    			$isAndroidUser = 0;
    			$updateNotificationDate = 0;
    			if($subscriberId){//ios user send notification in mail
    				$this->load->config('email_conf');
    				$mailTemplate = $this->config->item('iosEmailNotificationTemplate');
    				$mailTemplate = str_replace('##CUSTOMERNAME##', $subscriberData['contact_name'], $mailTemplate);
    				$mailTemplate = str_replace('##BUDDYNAME##', $senderData['contact_name'], $mailTemplate);
    				$mailTemplate = str_replace('##CHATPAGELINK##', $url, $mailTemplate);
    				echo 'Sending mail to IOS subscriber'.$newLineSeparator;
    				$mailSent = $this->mail->send($subscriberData['email'], $title, $mailTemplate);
    				if($mailSent){
    					//update notified status on success
    					$this->updateNotificationAction($notif_data['id'], $senderId, $receiverID);
    					$updateNotificationDate = 1;
    				}
    				continue;
    			}
    			if(($subscriberData['operatingsystem'] != 'ios' && $subscriberData['operatingsystem'] != 'IOS' && $subscriberData['operatingsystem'] != 1)){
    				$isAndroidUser = 1;
    			}
    			
    			if($subscriberId && $isAndroidUser){
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
    							"message"=> trim($message), // Message
    									"title"=> $title, // title
    							"redirectURL"=> $url, // URL on which user should be redirected on click.
    							"iconURL"=> $logoUrl, // URL for the icon to be displayed
    							"fallback"=>[ //  replica of the complete dict in case there is personalization failure.
    					]
    					]
    					]
    				];
    				
    				$data_string = json_encode($data_string);
    				var_dump($data_string);
    				$httpHeadersArray = Array();
    				$httpHeadersArray[] = 'Content-Type: application/json';
    				$httpHeadersArray[] = 'Content-Length: ' . strlen($data_string);
    				echo 'Pushing web notification'.$newLineSeparator;
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
					 //echo $resultArray['message'];
					 if($resultArray['status'] == 'success' || $resultArray['status'] == 'Success') {
					 	if(!$updateNotificationDate){
					 		//update notified status on success
					 		$this->updateNotificationAction($notif_data['id'], $senderId, $receiverID);
					 	}
					 	}
	    			else if($resultArray['status'] == 'failure') {
	    				echo 'Moengage messaging failed.'.$newLineSeparator;
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
    	$d_type = (int)$_POST['d_type'];
    	$status = (int)$_POST['status'];
    	$os = $_POST['os'];
    	if($subid){
    		$this->notification_model->addSubscriber($subid, $d_type, $status, $os);
    		echo 1;
    	}
    }
    
    private function updateNotificationAction($notificationId, $senderId, $receiverId) {
    	$this->chat_model->updateNotifiedStatus($notificationId);
    	//update subscriber data last modified
    	$this->notification_model->updateSubscriber($senderId, $receiverId);
    }
}
?>
