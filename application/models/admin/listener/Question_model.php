<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function getAllQuestions(){
    	$this->db->order_by('priority', 'asc');
    	$query = $this->db->get('listener_questions');
    	if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function addQuestion($data){
    	$this->db->insert('listener_questions', $data);
    	return $this->db->insert_id();
    }
    
    public function updateQuestion($id, $data){
    	$this->db->where('id', $id);
    	$this->db->update('listener_questions', $data);
    	return $id;
    }
    
    public function getQuestionDetails($id){
    	$this->db->where('id', $id);
    	$query = $this->db->get('listener_questions');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function getAssocQuestionDetails($catid){
    	$query = $this->db->query('select q.* from listener_questions q, listener_cat_question_assoc cqa where cqa.questid = q.id and cqa.catid = '.$catid.' and q.status = 1 order by q.priority asc');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function getAssocQuestionDetailsAll($catid){
    	$query = $this->db->query('select q.* from listener_questions q, listener_cat_question_assoc cqa where cqa.questid = q.id and cqa.catid = '.$catid.' order by q.priority asc');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function getAssocCatDetails($queid){
    	$query = $this->db->query('select c.* from listener_categories c, listener_cat_question_assoc cqa where cqa.questid = '.$queid.' and cqa.catid = c.id');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function getQuestionCompleteDetails($id){
    	$question = $this->getQuestionDetails($id);
    	$category = $this->getAssocCatDetails($id);
    	
    	$question = $question[0];
    	$category = $category[0];
    	if($question->id && $category->id){
    		$result = [
    				'questionid'=>$question->id,
    				'question'=>$question->question,
    				'answer'=>$question->answer,
    				'priority'=>$question->priority,
    				'status'=>$question->status,
    				'categoryid'=>$category->id,
    				'parentid'=>$category->parentid,
    				'categoryname'=>$category->name,
    				'thirdclick'=>$category->thirdclick,    				
    		];
    		return $result;
    	}else{
    		return array();
    	}
    	
    }
}
?>