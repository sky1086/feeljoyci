<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor_model extends CI_Model{
    function __construct(){
        parent::__construct();
        ini_set('display_errors', 'On');
        error_reporting(1);
    }
    
    public function getListenersMonitoringDetails()
    {
    	$qry = "select userid, contact_name, last_login, email from user_detail where status = 1 and user_type= 'Listener' order by contact_name asc;";
    	$query = $this->db->query($qry);
    	$resutls = $query->result();
    	$count = count($resutls);
    	for($i = 0; $i < $count; $i++){
    		//var_dump($this->getListenerUnreadMsg($resutls[$i]->userid));
    		$resutls[$i]->unreadMsg = $this->getListenerUnreadMsg($resutls[$i]->userid);
    		$resutls[$i]->caseLoad = $this->getListenerCaseLoad($resutls[$i]->userid);
    	}
    	if (count($resutls)){
    		return $resutls;
    	}
    	return array();
    }
    
    public function getListenerUnreadMsg($id){
    	$qry = "select count(*) as unreadMsg from msg where status = 1 and msg.to = $id;";
    	$query = $this->db->query($qry);
    	if ($query->num_rows() > 0) {
    		$resArr = $query->result();
    		return $resArr[0]->unreadMsg;
    	}
    	return 0;
    }
    
    public function getListenerCaseLoad($id){
    	$qry = "select count(DISTINCT(msg.from)) as caseLoad from msg where msg.to = $id";
    	$query = $this->db->query($qry);
    	if ($query->num_rows() > 0) {
    		$resArr = $query->result();
    		return $resArr[0]->caseLoad;
    	}
    	return 0;
    }
    
    public function verifyListener($listenerId, $email = ''){
    	$where = ' where user_type = "Listener" ';
    	if($listenerId){
    		$where .= ' and userid = '.$listenerId.' ';
    	}
    	if($email){
    		$where .= 'and email = '.$email.' ';
    	}
    	
    	$qry = "select email, contact_name from user_detail". $where. " limit 1";
    	$query = $this->db->query($qry);
    	if ($query->num_rows() > 0) {
    		$resArr = $query->result();
    		return $resArr;
    	}
    	return array();
    }
}