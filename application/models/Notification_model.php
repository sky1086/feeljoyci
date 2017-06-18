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
    
    public function updateSubscriber($data, $subid){
    	if($subid){
    		$this->db->where('userid', $subid);
    		$this->db->update('notification_users', $data);
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
    	$query = $this->db->query('select * from notification_users where userid = '.$userid.' and status = 1' );
    	if ($query->num_rows() > 0) {
    		$row = $query->result_array();
    		return $row[0];
    	}
    	else
    	{
    		return 0;
    	}
    }
}
