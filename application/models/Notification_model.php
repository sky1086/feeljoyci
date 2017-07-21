<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification_model extends CI_Model{
	function __construct() {
		$this->load->model('user_model');
	}
	
	public function addSubscriber($subid, $d_type, $status, $os){
		
		if(!$subid)
			return 0;
		
		$myid = $this->session->userdata('userid');
		$email = $this->session->userdata('email');
		$data = array();
		$data['device_type'] = $d_type;
		if(!empty($os)){
			$data['operatingsystem'] = $os;
		}
		if($d_type == 1){//mobile
			$data['subscriberid_mob'] =  $subid;
		}else{
			$data['subscriberid_desktop'] =  $subid;
		}
		//If user exists
		if($this->subscriberExists($myid)){
			$data['updated_time'] =  date('Y-m-d H:i:s');
			$data['status'] =  $status;
			$this->db->where('userid', $myid);
			$this->db->update('notification_users', $data);
			return 1;
		}else {
			$data['userid'] =  $myid;
			$data['email'] =  $email;
			$data['status'] =  $status;
			$data['updated_time'] =  date('Y-m-d H:i:s');
			$this->db->insert('notification_users', $data);
			return 1;
		}
    }
    
    public function updateSubscriber($sender, $receiver){
    	if($receiver && $sender){
    		$query = "insert into last_notified (sender, receiver, notified_datetime) values ($sender, $receiver, '".date('Y-m-d H:i:s')."') on duplicate key update notified_datetime = '".date('Y-m-d H:i:s')."'";
    		$this->db->query($query);
    	}	
    }
    
    public function subscriberExists($userid){
    	$query = $this->db->query('select userid from notification_users where userid = '.$userid);
		if ($query->num_rows() > 0) {
			return true;
		}
		else
		{
			return false;
		}
    }
    
    public function getSubscriberDetails($userid){
    	$query = $this->db->query('select nouser.*, ud.contact_name from notification_users nouser, user_detail ud  where nouser.userid = '.$userid.' and nouser.userid = ud.userid and nouser.status = 1' );
    	if ($query->num_rows() > 0) {
    		$row = $query->result_array();
    		return $row[0];
    	}
    	else
    	{
    		return 0;
    	}
    }
    
    public function getLastConversationDateTime($sender, $receiver){
    	$query = $this->db->query('select notified_datetime from last_notified where sender = '.$sender.' and receiver = '.$receiver);
    	if ($query->num_rows() > 0) {
    		$row = $query->result_array();
    		return $row[0]['notified_datetime'];
    	}
    	else
    	{
    		return 0;
    	}
    }
}
