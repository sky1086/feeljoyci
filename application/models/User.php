<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model{
	function __construct() {
		$this->tableName = 'users';
		$this->primaryKey = 'id';
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
			$data['modified'] = date("Y-m-d H:i:s");
			$insert = $this->db->insert($this->tableName,$data);
			$userID = $this->db->insert_id();
			$this->updateMainUsrTable($data);
		}

		return $userID?$userID:FALSE;
    }
    
    public function updateMainUsrTable($userdata = array()){
    	$data = array();
    	
    	$data['contact_name'] = $userProfile['given_name'].' '.$userProfile['family_name'];
    	$data['email'] = $userProfile['email'];
    	$data['gender'] = $userProfile['gender'];
    	//$userData['locale'] = $userProfile['locale'];
    	//$userData['profile_url'] = $userProfile['link'];
    	$data['profile_img'] = $userProfile['picture'];
    	if($this->user_model->isUserEmailExists($userData['email'])){
    		$data['edited_date'] = date("Y-m-d H:i:s");
    		$update = $this->db->update('user_detail',$data,array('email'=>$data['email']));
    	}else{
    		$data['created_date'] = date("Y-m-d H:i:s");
    		$data['edited_date'] = date("Y-m-d H:i:s");
    		$data['user_type'] = 'user';
    		$insert = $this->db->insert('user_detail',$data);
    	}
    }
}
