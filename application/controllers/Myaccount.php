<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myaccount extends CI_Controller{
	 
	function __construct(){
		parent::__construct();
		$this->load->model('authentication');
		$this->authentication->isLoggedIn();
		$this->load->model('myaccount_model');
		$this->load->library(array('form_validation'));
		}

				
public function userpassword()
{
	$data['title'] = lang('spidio').' - '."Change Password";
	$data =  $this->authentication->getCurrentUser();
	$data['menu'] = 'users';
	$data['successmsg'] = '';
	$data['errmsg'] = '';
	$submit = $this->security->xss_clean($this->input->post('changepass'));
		if($submit == 'Change')
				{
				
				$this->form_validation->set_rules('password', 'Password', 'required');
				$this->form_validation->set_rules('npassword', 'New Password', 'required|matches[cpassword]');
				$this->form_validation->set_rules('cpassword', 'Re-enter Password', 'required');
				if ($this->form_validation->run() == TRUE)
					{
						$user['userid']      = $data['userid'];
						$user['password']  	 = $this->security->xss_clean($this->input->post('password'));
						$user['npassword']  	 = $this->security->xss_clean($this->input->post('npassword'));
						if($this->myaccount_model->validate($user['userid'], md5($user['password'])))
						{
							$user['npassword'] = md5($user['npassword']);//encrypt password before save
							$result = $this->myaccount_model->changepassword($user);
						if($result)
						{
						if($result > 0)
							{
								$UserID  = $result;
							}
							
							$data['successmsg'] = 'Password has been changed successfully.';
							//redirect('myaccount/userpassword');
						}
					}else
					{
						$data['errmsg'] = 'Please enter correct password';
					}
				}
					}
					
				$this->load->view('admin/myaccountpassword_view', $data);
		}
}

?>