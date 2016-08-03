<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Listener_model extends CI_Model{
	var $rdb = '';
	
    function __construct(){
        parent::__construct();
    }
    
    public function getDetailByID($id){    	
    	$this->db->where('id', $id);
		$query = $this->db->get('listener_detail');
		
        if(count($query->result()))
        {
            $row = $query->result_array();
            return $row[0];
        }
        return false;    	
    }
    public function getPerformingCampaign($pubId){
    	$today = date('Y-m-d');
    	$startDate = date('Y-m-d', strtotime($today .' -30 day')); 
    	$endDate = date('Y-m-d').' 23:59:59';
    	$query = $this->rdb->query($this->query->getPerformingCampaign, array($pubId,$startDate,$endDate));
    	if ($query->num_rows > 0){
    		return $data = $query->result_array();
    	}
    	return false; 
    	
    }
    public function getPublisherRevenue($pubId){
    	$query = $this->rdb->query($this->query->getPublisherInterfaceRevenue, array($pubId,date("Y-m-d", strtotime("-30 day"))));
    	if ($query->num_rows > 0){
    		$payArr = array();
    		$Total = 0;
    		foreach ($query->result() as $row)
    		{
    			$Total += $row->APCTotalPayout;
    			if($row->Date == date('Y-m-d'))
    			{
    				$payArr['today'] = $row->APCTotalPayout;
    			}
    			elseif($row->Date == date('Y-m-d', strtotime("-1 day")))
    			{
    				$payArr['yesterday'] = $row->APCTotalPayout;
    			}
    			elseif($row->Date >= date('Y-m-d', strtotime("-6 day")))
    			{
    				$payArr['last7days'] = $Total;
    			}
    		}
    		$payArr['last30days'] = $Total;
    		return $payArr;
    	}
    	return false;
    }
    
    public function getTotalPublisherRevenue($pubId){
    	$currmonth = date('m');
    	$currYear = date('Y');
    	if($currmonth < 4)
    	{
    		$currYear = $currYear -1;
    	}    	 
    	$last_financial_year = date("Y-m-d", strtotime(date($currYear."-04-01")));
    	$query = $this->rdb->query($this->query->getTotalPublisherRevenue, array($last_financial_year,$pubId));
    	if($query->num_rows > 0)
    	{
    		$row = $query->row();
    		return $row->Total;
    	}
    	return false;
    }
    
	public function getGraphData()
	{
		for($n = 6;$n>=0;$n--)
		{
			$dates[] = date ( 'Y-m-d', strtotime ( '-'.$n.' day' . $now ) );
		}
		$query = $this->rdb->query($this->query->getGraphData, array(date("Y-m-d", strtotime("-6 day")),$this->session->userdata('publisherid')));
		if ($query->num_rows > 0){
			$graphdata = array();
			
			$revenue = array();
			foreach ($query->result() as $row)
			{
				$revenue[$row->ReportDateTime] = $row->TotalPayout;
			}
			
		}	
		foreach($dates as $date)
			{
				$keyDates = array_keys($revenue);
				if(in_array($date, $keyDates))
				{
					$graphdata[date('d M y',strtotime($date))] = (int)$revenue[$date];
				}
				else
				{
					$graphdata[date('d M y',strtotime($date))] = 0;					
				}
				
			}
			return $graphdata;	
		
	}
	
}
	