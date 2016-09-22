<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function getAllQuestions(){
    	$query = $this->db->get('questions');
    	if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function addQuestion($data){
    	$this->db->insert('questions', $data);
    	return $this->db->insert_id();
    }
    
    public function updateQuestion($id, $data){
    	$this->db->where('id', $id);
    	$this->db->update('questions', $data);
    	return $id;
    }
    
    public function getQuestionDetails($id){
    	$this->db->where('id', $id);
    	$query = $this->db->get('questions');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function getAssocQuestionDetails($catid){
    	$query = $this->db->query('select q.* from questions q, cat_question_assoc cqa where cqa.questid = q.id and cqa.catid = '.$catid);
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
}
?>