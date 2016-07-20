<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Passwordrecovery extends CI_Controller {
 
/********************************************************
* This is the index page for this controller 
class Passwordrecovery extends CI_Controller {
********************************************************/
     function __construct(){
		 parent::__construct(); 

$this->load->model('passwordrecovery_model');
$this->load->library(array('form_validation'));
if($this->session->userdata('validated'))
		{
           redirect('publisher/loginview');           
        }
    }
    public function index($usertype='', $RecoveryID='')
    {
    	
    	$this->load->library('session');		
    	if(!empty($RecoveryID))
		{
			$this->resetform($usertype, $RecoveryID);
		}
		else
		{
			$this->requestform($usertype);
		}
	}
	
private function resetform($RecoveryID)
	{
		if($this->passwordrecovery_model->recoveryidvalidation($RecoveryID))
		{
			$data['RecoveryID'] =  $RecoveryID;
			$this->load->view('admin/changepassword_view', $data);
		}
		else
		{
			$this->requestform($usertype);
		}
	}
public function requestform()
{
	$success = 0;
	if ($this->input->post()){
			$UserEmail = $this->input->post('UserLoginEmail');
			$result = $this->passwordrecovery_model->validate($UserEmail);
			if($result == true)
				{
				
					$data = $this->passwordrecovery_model->sendrecoverymail($UserEmail);
					$success = 1;
					$this->load->view('success_view.php',$data);
				}
				else
				{
					$data['error'] = 'Given Email address is not registered with us.';
				}
				}
				
				if ($success != 1)
				{				
					$this->load->view('passwordrecovery_view', $data);
				}
			}
			
public function userpassword()
{
	$UserID = (int)$UserID;
	$submit = $this->security->xss_clean($this->input->post('next'));
	if($submit == 'save')
				{
					$this->form_validation->set_rules('NPassword', 'New Password', 'required|isIllegalHtmlTagPresent');
					$this->form_validation->set_rules('RPassword', 'Re-enter Password', 'required|isIllegalHtmlTagPresent');
				if ($this->form_validation->run() == TRUE)
					{
						$user['usertype']  	 	= $this->security->xss_clean($this->input->post('usertype'));
						$user['RecoveryID']  	 = $this->security->xss_clean($this->input->post('RecoveryID'));
						$user['NPassword']  	 = $this->security->xss_clean($this->input->post('NPassword'));
						$user['RPassword']  	 = $this->security->xss_clean($this->input->post('RPassword'));
						if($user['NPassword'] == $user['RPassword'])
						{
							if($UserID = $this->passwordrecovery_model->recoveryidvalidation($user['RecoveryID']))
							{
								$data = $this->passwordrecovery_model->changepassword($UserID);
								redirect('login');
						}
						
						}
					}
					}
		}
}

?>