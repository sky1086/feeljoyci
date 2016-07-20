<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function validate($username = '', $password = '', $skipPass = 0){
        // grab user input
        $username = (!empty($username)?$username:$this->security->xss_clean($this->input->post('username')));
        $password = (!empty($password)?$password:$this->security->xss_clean($this->input->post('password')));
        $this->db->select('userid, email, username, contact_name, user_type');
        $this->db->from('user_detail');
        $this->db->where('email', $username);
        if($skipPass == 0)
        $this->db->where('password', $password);
        
        $this->db->where('status', 1);
        $query = $this->db->get();
        $row = $query->row();
        if($row)
        {
            // If there is a user, then create session data
            $this->session->set_userdata(array());
            $accounts = $this->config->item('account_type');
            $data = array(
                    'userid' => $row->userid,
                    'username' => $row->email,
            		'contact_name' => $row->contact_name,
            		'email' => $row->email,
            		'validated'=> true,
            		'usertype' => $accounts[$row->user_type]
                    );
            $this->session->set_userdata($data);
            if($this->input->post('remember') == 1){
            	setcookie("sp_u", base64_encode($row->userid), time()+60*60*24*100, "/");
            	setcookie("sp_p", base64_encode($password), time()+60*60*24*100, "/");
            }
            return true;
        }
        return false;
    }
    
    public function forceUserLogin($emailid){
    	if($emailid)
    	$this->validate($emailid, '', 1);
    }
}
?>