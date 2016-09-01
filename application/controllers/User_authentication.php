<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_Authentication extends CI_Controller
{
    function __construct() {
		parent::__construct();
		// Load user model
		$this->load->model(array('user','login_model'));
    }
    
    public function index(){
		// Include the google api php libraries
		include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
		
		// Google Project API Credentials
		$clientId = '679180648415-fch3v2k0t3qns5vml3hf1qp0drcspb6e.apps.googleusercontent.com';
        $clientSecret = 'r-03D8jBEPpmi_WWWA2rN-IK';
        $redirectUrl = base_url().'user_authentication/';
		
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
            } else {
               $data['userData'] = array();
            }
        } else {
            $data['authUrl'] = $gClient->createAuthUrl();
        }
		//$this->load->view('user_authentication/index',$data);
    }
	
	public function logout() {
		$this->session->unset_userdata('token');
		$this->session->unset_userdata('userData');
        $this->session->sess_destroy();
		redirect('/user_authentication');
    }
}
