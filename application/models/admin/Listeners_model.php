<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listeners_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function getAllListeners()
    {
    	$qry = "select * from listener_detail order by priority asc;";
    	$query = $this->db->query($qry);
    	$resutls = $query->result();
    	$count = count($resutls);
    	if ($count > 0){
    		return $resutls;
    	}
    	return array();
    }
    
    public function addListener($data){
    	$this->db->insert('listener_detail', $data);
    	return $this->db->insert_id();
    }
    
    public function updateListener($id, $data){
    	$this->db->where('id', $id);
    	$this->db->update('listener_detail', $data);
    	return $id;
    }
    
    public function getListenerDetails($id){
    	$this->db->where('id', $id);
    	$query = $this->db->get('listener_detail');
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	}
    	return array();
    }
    
    public function getAssocCategoryDetails($id){
    	$this->db->where('id', $id);
    	$categories = array();
    	$query = $this->db->query('select c.* from categories c, cat_listener_assoc cla where cla.catid = c.id and cla.listenerid = '.$id);
    	if ($query->num_rows() > 0) {
    		$res_array = $query->result_array();
    		foreach ($res_array as $catd){
    			$categories[] =  $catd['id'];
    		}
    	}
    	return $categories;
    }
    
    public function assocCatListener($categories, $lid) {
    	if($lid){
    		$this->db->where('listenerid', $lid);
    		$this->db->delete('cat_listener_assoc');
    		foreach ($categories as $catk=>$catv){
    			$this->db->insert('cat_listener_assoc', array('catid'=>$catv, 'listenerid'=>$lid));
    		}
    		return 1;
    	}
    	return 0;
    }
    
}