<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Doodle_model extends CI_Model{
	function __construct() {
	}
	
	public function updateLikes($likeData, $userId){
		$data = array();
		$this->db->insert('user_detail',$likeData);
		if($this->db->insert_id()){
			//update count in doodles
		}
		return 1;
	}
}
