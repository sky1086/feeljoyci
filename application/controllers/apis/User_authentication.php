<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_Authentication extends CI_Controller
{
    function __construct() {
		parent::__construct();
		// Load user model
		$this->load->model(array('user','login_model'));
		ini_set('display_errors', 'On');
		error_reporting('E_ALL');
    }
    
    public function index(){
		// Include the google api php libraries
		include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
		
		// Google Project API Credentials
		$clientId = '679180648415-fch3v2k0t3qns5vml3hf1qp0drcspb6e.apps.googleusercontent.com';
        //$clientSecret = 'r-03D8jBEPpmi_WWWA2rN-IK';
        $clientSecret = '0mkKChGTnJHuPvU1LSlE5sDv';
        $redirectUrl = 'https://api.feeljoy.in/apis/user_authentication/';
		
		// Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('FeelJoy');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
		
        $pos = strpos($_SERVER['REQUEST_URI'], 'code=');
        
        if ($pos !== false) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            //redirect($redirectUrl);
        }
        
        $originalRedirectUrl = '';
        if(isset($_GET['state']) && !filter_var($_GET['state'], FILTER_VALIDATE_URL) === false){
        	$originalRedirectUrl = $_GET['state'];
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            // Preparing data for database insertion
			$userData['oauth_provider'] = 'google';
			$userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['given_name'];
            $userData['last_name'] = $userProfile['family_name'];
            $userData['email'] = $userProfile['email'];
			$userData['gender'] = $userProfile['gender'];
			$userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = $userProfile['link'];
            $userData['picture_url'] = $userProfile['picture'];
			// Insert or update user data
            $userID = $this->user->checkUser($userData);
            if(!empty($userID)){
                $this->login_model->forceUserLogin($userData['email']);
                $this->authentication->redirect2ApiDash($originalRedirectUrl);
            } else {
            	echo 'Something went wrong';
               $data['userData'] = array();
            }
        } else {
            $data['authUrl'] = $gClient->createAuthUrl();
        }
        exit('end');
		//$this->load->view('user_authentication/index',$data);
    }
	
	public function logout() {
		$this->session->unset_userdata('token');
		$this->session->unset_userdata('userData');
        $this->session->sess_destroy();
		redirect('https://api.feeljoy.in/apis/user_authentication');
    }
}
