<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function enforceAccount($accountType)
    {
    	$aArgs = is_array($accountType) ? $accountType : func_get_args();
    	$isAccount = $this->isAccount($aArgs);
    	if (!$isAccount) {
    		//$this->messages->queueMessage("You don't have access to that page. You have been re-directed.");
    		redirect('login');
    	}
    }
    
    public function isAccount($accountType)
    {
    	if ($oUser = $this->authentication->getCurrentUser()) {
    		$aArgs = is_array($accountType) ? $accountType : func_get_args();
    		return in_array($oUser['usertype'], $aArgs);
    	}
    	return false;
    }
}
?>