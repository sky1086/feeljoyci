<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
    
	private $showCaptcha = false;
    function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('login_model');
        $this->load->model('user');
        if($this->session->userdata('validated'))
        $this->authentication->redirect2Dash();
    }

    public function index($msg = ''){  	
    	
    	if(isset($_COOKIE['sp_u']) && isset($_COOKIE['sp_p']) && !isset($_SESSION['user_type'])){
    		$this->login_model->validate(base64_decode($_COOKIE['sp_u']), base64_decode($_COOKIE['sp_p']));
    	}
    	
        $data['error'] = $msg;
        
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
        	redirect($redirectUrl);
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
        		$data['userData'] = $userData;
        		$this->session->set_userdata('userData',$userData);
        	} else {
        		$data['userData'] = array();
        	}
        } else {
        	$data['authUrl'] = $gClient->createAuthUrl();
        }
        //$this->load->view('user_authentication/index',$data);
        
        $this->load->view('login_view',$data);
    }
	
	public function process(){
        // Load the model
		$this->load->library('form_validation');		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else
		{
		        // Validate the user can login
		        $result = $this->login_model->validate();
		        // Now we verify the result
		        if(! $result){
		            // If user did not validate, then show them login page again
		        	$msg = lang('invalidLogin');
		            $this->index($msg);
		        }else{
		            // Send them to members area
		        	$redirecturl = $this->session->userdata('redirecturl');
		        	if(!empty($redirecturl))
		        	{
		        		$this->session->set_userdata(array('redirecturl'=>null));
		        		redirect($redirecturl);
		        	}
					if($this->session->userdata('validated')){//var_dump($this->session->userdata);exit;
			    		if($this->session->userdata('usertype') == ACCOUNT_USER){
			    			redirect('user/listeners');
			    		}elseif($this->session->userdata('usertype') == ACCOUNT_LISTENER){
			    			redirect('listener/dashboard');
			    		}else{
			    			redirect('admin/dashboard');
			    		}
			        }
		        }
		}
    }
    
}
?>
