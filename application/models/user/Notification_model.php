<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    public function  getCampaigns($start_date, $end_date)
    {
    	$qry = "select campaign_name, sum(original_impression) as impressions, sum(original_clicks) as clicks, report_date from campaign_report where report_date >= ".$this->db->escape($start_date)." and report_date <= ".$this->db->escape($end_date)." and status = 1 group by campaign_name order by impressions desc;";
    	$query = $this->db->query($qry);
    	$resutls = $query->result_array();
    	$count = count($resutls);
    	if ($count > 0){
    		return $resutls;
    	}
    	return array();
    
    }
    
}