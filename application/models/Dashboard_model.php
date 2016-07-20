<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_model extends CI_Model{
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
	
public function  getProperties($start_date, $end_date)
		{
		$qry = "select property_id, property_name, sum(original_impression) as impressions, sum(original_clicks) as clicks, report_date from campaign_report where report_date >= ".$this->db->escape($start_date)." and report_date <= ".$this->db->escape($end_date)." and status = 1 group by property_id order by impressions desc;";
		$query = $this->db->query($qry);
		$resutls = $query->result_array();
		$count = count($resutls);
		if ($count > 0){
			return $resutls;
		}
		return array();
}

public function  getOsBreakdown($start_date, $end_date)
		{
			$qry = "select sum(original_impression) as impressions, system_os from campaign_report where report_date >= ".$this->db->escape($start_date)." and report_date <= ".$this->db->escape($end_date)." and status = 1 group by system_os limit 10;";
			$query = $this->db->query($qry);
			$resutls = $query->result_array();
			$count = count($resutls);
			if ($count > 0){
				foreach ($resutls as $row){
					$osArr[] = array('label'=>$row['system_os'], 'data'=>(int)$row['impressions']); 
				}
			}else{
				$osArr[] = array('label'=>'Unknown', 'data'=>0);
			}
			return json_encode($osArr);
}

public function  getDeviceBreakdown($start_date, $end_date)
		{
		$qry = "select sum(original_impression) as impressions, device_name from campaign_report where report_date >= ".$this->db->escape($start_date)." and report_date <= ".$this->db->escape($end_date)." and status = 1 group by device_name limit 10;";
			$query = $this->db->query($qry);
			$resutls = $query->result_array();
			$count = count($resutls);
			if ($count > 0){
				foreach ($resutls as $row){
					$osArr[] = array('label'=>$row['device_name'], 'data'=>(int)$row['impressions']); 
				}
			}else{
				$osArr[] = array('label'=>'Unknown', 'data'=>0);
			}
			return json_encode($osArr);	
}

public function getGraphData($start_date, $end_date)
{
	$qry = "select sum(original_impression) as impressions, sum(original_clicks) as clicks, report_date from campaign_report where report_date >= ".$this->db->escape($start_date)." and report_date <= ".$this->db->escape($end_date)." and status = 1 group by report_date order by report_date;";
	$query = $this->db->query($qry);
	$resutls = $query->result_array();
	$count = count($resutls);
	$graphdata = array();
	
	$datetime1 = date_create($start_date);
	$datetime2 = date_create($end_date);
	$interval = date_diff($datetime1, $datetime2);
	
	$numDays = $interval->format('%a');
	
	if ($count > 0){
		$nowtime = strtotime($end_date);
		for($n = $numDays;$n>=0;$n--)
		{
			$dates[] = date ('Y-m-d', strtotime ( '-'.$n.' day', $nowtime) );
		}
		
		$impressions = array();
		$clicks = array();
		foreach ($resutls as $row)
		{
			$impressions[$row['report_date']] = array($row['report_date'], $row['impressions']);
			$clicks[$row['report_date']] = array($row['report_date'], $row['clicks']);
		}
		
		foreach($dates as $date)
		{
			$keyDates = array_keys($impressions);
			$time = strtotime($date.'00:00:00')*1000;
			if(in_array($date, $keyDates))
			{
				$graphdata[0][] = array($time, $impressions[$date][1]);
				$graphdata[1][] = array($time, $clicks[$date][1]);
			}
			else
			{
				$graphdata[0][] = array($time, 0);
				$graphdata[1][] = array($time, 0);
			}
		}
	}
		return $graphdata;
		
}
}
?>