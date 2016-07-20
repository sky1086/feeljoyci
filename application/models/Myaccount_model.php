<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Myaccount_model extends CI_Model{
    function __construct(){
        parent::__construct();
	  }

public function userdetails($userid)
	{
		$query = $this->db->query('Select userid, username from user_detail where userid = '.$userid);
    	if($query->num_rows > 0)
        {
            $row = $query->row();
            return $row;
        }
        return false;
	}	 
public function validate($userid , $password){
		$query = $this->db->query('select userid from user_detail where userid = '.$userid.' and password = "'.$password.'";');
		$result = $query->result();
    	if(!empty($result))
        {
            return true;
        }
			return false;
		}

public function changepassword($user)
	{
		$sql = "UPDATE  user_detail SET Password=? where userid=?";
		$this->db->query($sql, array($user['npassword'], $user['userid']));
		return $user['userid'];
	}	
}
?>