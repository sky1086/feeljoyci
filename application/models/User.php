<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model{
	function __construct() {
		$this->tableName = 'users';
		$this->primaryKey = 'id';
		$this->load->model('user_model');
	}
	public function checkUser($data = array()){
		$this->db->select($this->primaryKey);
		$this->db->from($this->tableName);
		$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
		
		if($prevCheck > 0){
			$prevResult = $prevQuery->row_array();
			$data['modified'] = date("Y-m-d H:i:s");
			$update = $this->db->update($this->tableName,$data,array('id'=>$prevResult['id']));
			$userID = $prevResult['id'];
			$this->updateMainUsrTable($data);
		}else{
			$data['created'] = date("Y-m-d H:i:s");
			$data['modified'] = date("Y-m-d H:i:s");var_dump($data, $this->tableName);
			$insert = $this->db->insert($this->tableName,$data);
			$userID = $this->db->insert_id();
			$this->updateMainUsrTable($data);
		}

		return $userID?$userID:FALSE;
    }
    
    public function updateMainUsrTable($userdata = array()){
    	$data = array();
    	
    	$data['contact_name'] = $userdata['first_name'].' '.$userdata['last_name'];
    	$data['email'] = $userdata['email'];
    	$data['gender'] = $userdata['gender'];
    	//$userData['locale'] = $userdata['locale'];
    	//$userData['profile_url'] = $userdata['link'];
    	$data['profile_img'] = $userdata['picture_url'];
    	if($this->user_model->isUserEmailExists($userdata['email'])){
    		$data['edited_date'] = date("Y-m-d H:i:s");
    		$update = $this->db->update('user_detail',$data,array('email'=>$data['email']));
    	}else{
    		$data['created_date'] = date("Y-m-d H:i:s");
    		$data['edited_date'] = date("Y-m-d H:i:s");
    		$data['user_type'] = 'User';
    		$insert = $this->db->insert('user_detail',$data);
    	}
    }
}
