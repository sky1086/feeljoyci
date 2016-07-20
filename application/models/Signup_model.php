<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Signup_model extends CI_Model{
    function __construct(){
        parent::__construct();
	  }

public function isUserExists($email)
	{
		$query = $this->db->query('select userid from user_detail where email = "'.$email.'"');
	    if ($query->num_rows() > 0) {
	        return true;
	    } 
		else 
		{
	        return false;
	    }
	}

public function addSystemUser($data){
		$this->db->insert('user_detail', $data);
		return $this->db->insert_id();		
	}
		
	public function updateSystemUser($userid, $data){
		//check for permission
		$allowed = 0;
		if($this->session->userdata['usertype'] == ACCOUNT_ADMIN || $this->session->userdata['usertype'] == ACCOUNT_OTHERS){
			$allowed = 1;
		}
	
		if($allowed){
			$this->db->where('userid', $userid);
			$this->db->update('user_detail', $data);
			return $userid;
		}else{
			return 0;
		}
	
	}
	
	public function updateSystemUserByMail($emailid, $data){
			$this->db->where('email', $emailid);
			$this->db->update('user_detail', $data);
			return true;
	}
	
public function changepassword($user)
	{
		$sql = "UPDATE  user_detail SET password=? where userid=?";
		$this->db->query($sql, array($user['password'], $user['userid']));
		return $user['userid'];
	}
		
public function getAllUser() {
		//select allowed users		
        $this->db->select('userid,username,contact_name,status,organization_name, user_type, email, logo_url');
	    $this->db->order_by('username', 'ASC');
		$query = $this->db->get('user_detail');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
	
public function getUserDetails($userid)
	{
        $this->db->where('userid', $userid);
		$query = $this->db->get('user_detail');
		
        if(count($query->result()))
        {
            $row = $query->result_array();
            return $row[0];
        }
        return false;
    }

}
?>