<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listeners_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function getListeners($status = 1)
    {
    	$qry = "select * from listener_detail where status = ".$status." order by priority asc;";
    	$query = $this->db->query($qry);
    	$resutls = $query->result_array();
    	$count = count($resutls);
    	if ($count > 0){
    		return $resutls;
    	}
    	return array(); 
    }
    
    public function addSpamUser($data)
    {
    	$this->db->insert('spam_users', $data);
    }
    
}