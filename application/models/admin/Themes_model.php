<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Themes_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function getAllCategories(){
    	$this->db->order_by('priority', 'asc');
    	$query = $this->db->get('categories');
    	if ($query->num_rows() > 0) {
            return $query->result();
        }
        return array();
    }
    
    public function getAllThemes($id = 0){
    	if($id > 0){
    		$this->db->where('parentid', $id);
    	}else{
    		$this->db->where('parentid', 0);
    	}
    	$this->db->where('status', 1);
    	$this->db->order_by('priority', 'asc');
    	
    	$query = $this->db->get('categories');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function getAllSubCategories(){
    	$this->db->where('parentid != 0');
    	$this->db->order_by('priority', 'asc');
    	$query = $this->db->get('categories');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function addCategory($data){
    	$this->db->insert('categories', $data);
    	return $this->db->insert_id();
    }
    
    public function updateCategory($id, $data){
    	$this->db->where('id', $id);
    	$this->db->update('categories', $data);
    	return $id;
    }
    
    public function getCategoryDetails($id){
    	$this->db->where('id', $id);
    	$query = $this->db->get('categories');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function getAssocCategoryDetails($queid){
    	$this->db->where('id', $queid);
    	$categories = array();
    	$query = $this->db->query('select c.* from categories c, cat_question_assoc cqa where cqa.catid = c.id and cqa.questid = '.$queid);
    	if ($query->num_rows() > 0) {
    		$res_array = $query->result_array();
    		foreach ($res_array as $catd){
    			$categories[] =  $catd['id'];
    		}
    	}
    	return $categories;
    }
    
    public function assocCatQuestion($categories, $qid) {
    	if($qid){
    		$this->db->where('questid', $qid);
    		$this->db->delete('cat_question_assoc');
    		foreach ($categories as $catk=>$catv){
    			$this->db->insert('cat_question_assoc', array('catid'=>$catv, 'questid'=>$qid));
    		}
    		return 1;
    	}
    	return 0;
    }
}
?>