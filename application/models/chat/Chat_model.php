<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chat_model extends CI_Model{
    function __construct(){
        parent::__construct();
	  }

	public function insertMsg($data){	
	if(!empty($data)){
		$this->db->insert('msg', $data);
		return $this->db->insert_id();
	}else{
		return 0;
	}
		
	}

	/**
	 * 
	 * @param status $status
	 * @param array $where
	 */
	public function upChatStatus($status, $ids){

		if(!empty($ids)){
			$this->db->where_in('id', $ids);
			$this->db->update('msg', array('status' => $status));
		}else{
			return 0;
		}
	
	}
	
	public function getMsgById($id)
	{
        $this->db->where('id', $id);
		$query = $this->db->get('msg');
		
        if(count($query->result()))
        {
            $row = $query->result_array();
            return $row[0];
        }
        return false;
    }
    
    /**
     * 
     * @param array $where
     * @param string $limit
     */
    public function getMsgsWhere(array $where, $limit = '')
    {
    	if(!empty($where)){
	    	$query = $this->db->get_where('msg', $where, $limit);
	    
	    	if(count($query->result()))
	    	{
	    		$row = $query->result_array();
	    		return $row;
	    	}
    	}
    	return false;
    }
    
	/**
	 * 
	 * @param array $where
	 */
    public function getUsrLastMsgWhere(array $where)
    {
    	if(!empty($where)){
    		$this->db->order_by('id', 'asc');
    		$query = $this->db->get_where('msg', $where);
    	  
    		if(count($query->result()))
    		{
    			$row = $query->result_array();
    			return $row;
    		}
    	}
    	return false;
    }
    
    public function getUsrOldMsgWhere($myid, array $where, $limit = 0)
    {
    	if(!empty($where)){
    		$this->db->order_by('id', 'desc');
    
    		if($limit > 0){
    			$this->db->limit($limit);
    		}
   
    		$this->db->where('status = 0');
    		//$this->db->or_where('from = '.$where['to'].' and to = '.$where['from']);
    		$this->db->where('(from = '.$where['from'].' and to = '.$where['to'].') or (from = '.$where['to'].' and to = '.$where['from'].')');
    		
    		$query = $this->db->get('msg');
    		$result = $query->result_array();
    		
    		if(count($result))
    		{
    			$result = array_reverse($result);
    			$msgs = array();
    			$i = 0;
    			$lastid = '';
    			foreach ($result as $row){
    				if($lastid != $row['from']){
    					$i++;
    				}
    				
    				$decoded_msg = $this->chat_model->decodeMsg($row['msg'], $row['int_vec']);
    				$msg = Emoji::html_to_emoji($decoded_msg);
    				$row['msg'] = $msg;
    				unset($row['int_vec']);
    				if($myid == $row['from']){
    					$row['clsname'] = 'm-rply';
    					$msgs[$i][] = $row;
    				}else{
    					$row['clsname'] = 'f-rply';
    					$msgs[$i][] = $row;
    				}
    				$lastid = $row['from'];
    			}
    			//krsort($msgs);
    			//var_dump($msgs);
    			return $msgs;
    		}
    	}
    	return false;
    }
    
    public function getOnlineListeners(){
    		$this->db->order_by('timestamp', 'desc');
    		$this->db->where('timestamp > (UNIX_TIMESTAMP(now()) -'.ACTIVEINLASTSECS.' )');
    		$this->db->where('userid > 0');
    		
    		$query = $this->db->get($this->config->item('sess_save_path'));
    		 
    		if(count($query->result()))
    		{
    			$row = $query->result_array();
    			return $row;
    		}else{
    			return false;
    		}
    }
    
    public function encodeMsg($string){
    	
    	if(empty($string)) return ;
    	/*
		 * PHP mcrypt - Basic encryption and decryption of a string
		 */
    	
		$secret_key = CHATENCODESECKEY;
		
		// Create the initialization vector for added security.
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
		
		// Encrypt $string
		$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_CBC, $iv);
		
		return array($encrypted_string, $iv);
	
    }
    
    public function decodeMsg($string, $iv){
    	 
    	if(empty($string)) return ;
    	/*
    	 * PHP mcrypt - Basic encryption and decryption of a string
    	 */
    	 
    	//$string = str_replace(CHATENCODESECKEY, '', $string);
    	$secret_key = CHATENCODESECKEY;
    
    	// Create the initialization vector for added security.
    	//$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
    
    	// Decrypt $string
    	$decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_CBC, $iv);
    	
    	return $decrypted_string;
    
    }
    
    public function getContactedListeners($uid) {
    	//select distinct(msg.to) from msg where msg.from = 9 group by msg.to order by max(id) desc limit 20;
    	$this->db->select('msg.to');
    	$this->db->from('msg');
    	$this->db->where('msg.from', $uid);
    	$this->db->group_by('msg.to');
    	$this->db->order_by('max(id)', 'desc');
    	$this->db->limit(20);
    	
    	$query = $this->db->get();
    	 
    	if(count($query->result()))
    	{
    		$userdata = array();
    		$row = $query->result_array();
    		foreach ($row as $user){
    			$this->db->where('userid', $user['to']);
    			$this->db->where('user_type', 'Listener');
    			$query1 = $this->db->get('user_detail');
    			if(count($query1->result()))
    			{
    				$userdata = $query1->result_array();
    			}
    		}
    		return $userdata;
    	}else{
    		return false;
    	}
    }
    
    public function getContactedUsers($uid) {
    	//select distinct(msg.from) from msg where msg.to = 9 group by msg.from order by max(id) desc limit 20;
    	$this->db->select('msg.from');
    	$this->db->from('msg');
    	$this->db->where('msg.to', $uid);
    	$this->db->group_by('msg.from');
    	$this->db->order_by('max(id)', 'desc');
    	$this->db->limit(20);
    	 
    	$query = $this->db->get();
    
    	if(count($query->result()))
    	{
    		$userdata = array();
    		$row = $query->result_array();
    		$this->db->select('userid');
    		$qry_spamUsers = $this->db->get('spam_users');
    		
    		if(count($qry_spamUsers->result_array())){
    			$spamUsersList = $qry_spamUsers->result_array();
    			foreach ($spamUsersList as $spamUser){
    				$spamUsers[] = $spamUser['userid'];
    			}
    		}
    		
    		foreach ($row as $user){
    			$this->db->where('userid', $user['from']);
    			$this->db->where('user_type', 'User');
    			$this->db->where_not_in('userid', $spamUsers);
    			$this->db->from('user_detail');
    			$query1 = $this->db->get();
    			
    			if(count($query1->result()))
    			{
    				$userdata[] = $query1->result_array();
    			}
    		}
    		return $userdata;
    	}else{
    		return false;
    	}
    }
    
    /**
     *
     * @param array $where
     */
    public function getLastMsgFromUsr($uid, $to = 0)
    {
    	$this->db->where('from', $uid);
    	if($to){
    		$this->db->where('to', $to);
    	}
    	$this->db->order_by('id', 'desc');
    	$this->db->limit(1);
    	$query = $this->db->get_where('msg');
    		 
    	if(count($query->result()))
    	{
    		$row = $query->result_array()[0];
    		return $row;
    	}
    	return false;
    }
    
    public function isSpamUser($userid)
    {
    	$this->db->where('userid', $userid);
    	$query = $this->db->get('spam_users');
    
    	if(count($query->result()))
    	{
    		return true;
    	}
    	return false;
    }

}
?>