<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function getAllCategories(){
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
}
?>