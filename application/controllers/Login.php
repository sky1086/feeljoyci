<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
    
	private $showCaptcha = false;
    function __construct(){
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->model('login_model');
        $this->authentication->redirect2Dash();
    }

    public function index($msg = ''){  	
    	
    	if(isset($_COOKIE['sp_u']) && isset($_COOKIE['sp_p']) && !isset($_SESSION['user_type'])){
    		$this->login_model->validate(base64_decode($_COOKIE['sp_u']), base64_decode($_COOKIE['sp_p']));
    	}
    	
        $data['error'] = $msg;
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
			    			redirect('user/dashboard');
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
