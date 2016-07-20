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
    		$this->db->where('from = '.$where['from'].' and to = '.$where['to']);
    		$this->db->or_where('from = '.$where['to'].' and to = '.$where['from']);
    		
    		$query = $this->db->get('msg');
    		 
    		if(count($query->result()))
    		{
    			$msgs = array();
    			foreach ($query->result_array() as $row){
    				if($myid == $row['from']){
    					$row['clsname'] = 'm-rply';
    					$msgs[$row['id']] = $row;
    				}else{
    					$row['clsname'] = 'f-rply';
    					$msgs[$row['id']] = $row;
    				}
    			}
    			krsort($msgs);
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

}
?>