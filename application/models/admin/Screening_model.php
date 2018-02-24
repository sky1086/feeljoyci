<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Screening_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function getAllScreeningQuestions(){
		$this->db->order_by('weightage', 'desc');
		$query = $this->db->get('screening_questions');
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return array();
	}
	
	public function getAllScreenQuestOfType($type){
		if(!empty($type)){
			$this->db->where('q_type', $type);
		}
		$this->db->where('q_status', 1);
		$this->db->order_by('weightage', 'desc');
		$query = $this->db->get('screening_questions');
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return array();
	}
}
?>