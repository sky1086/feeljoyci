<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'application/libraries/aws/aws-autoloader.php';
use Aws\Ses\SesClient;

class Mail{
	
	public function send($to, $subject, $message){
		
		define('SENDER', 'noreply@feeljoy.in');
		
		// Replace recipient@example.com with a "To" address. If your account
		// is still in the sandbox, this address must be verified.
		define('RECIPIENT', $to);
		
		// Replace us-west-2 with the AWS region you're using for Amazon SES.
		define('REGION','us-east-1');
		//define('REGION','ap-south-1');
		
		define('SUBJECT', $subject);
		define('BODY',$message);
		
		
		$client = SesClient::factory(array(
				'profile' => SESUSERPROFILE,
				'version'=> 'latest',
				'region' => REGION
		));
		
		//print_r($client->verifyEmailAddress(['EmailAddress' => 'skya.1086@gmail.com']));
		//print_r($client->listVerifiedEmailAddresses());
		
		$request = array();
		$request['Source'] = SENDER;
		$request['Destination']['ToAddresses'] = array(RECIPIENT);
		$request['Message']['Subject']['Data'] = SUBJECT;
		$request['Message']['Body']['Html']['Data'] = BODY;
		
		try {
			$result = $client->sendEmail($request);
			$messageId = $result->get('MessageId');
			//echo("Email sent! Message ID: $messageId"."\n");
			return 1;
			
		} catch (Exception $e) {
			return 0;
			//echo("The email was not sent. Error message: ");
			//echo($e->getMessage()."\n");
		}
	}
}
?>