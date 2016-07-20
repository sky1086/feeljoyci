<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_Model extends CI_Model{
	
	private $rdb;
	
    function __construct(){
    	$this->rdb = $this->load->database('rdb',TRUE);
        parent::__construct();     
	  }

public function getPieChartImp($AdvertiserID)
	{
		$lastthirtydays = date('Y-m-d', strtotime('-29 day'));
		$query = $this->rdb->query($this->query->geoImpPieGraph,array($lastthirtydays,$AdvertiserID));
		if ($query->num_rows() > 0) 
			{
				 $rows = $query->result_array();
				 return $this->getPieChartData($rows, 'Impressions', 'Region');
			}
			return false;
		
	}

public function getPieChartClick($AdvertiserID)
	{
		$lastthirtydays = date('Y-m-d', strtotime('-29 day'));
		$query = $this->rdb->query($this->query->geoClickPieGraph,array($lastthirtydays,$AdvertiserID));
		if ($query->num_rows() > 0) 
			{
				 $rows = $query->result_array();
				 return $this->getPieChartData($rows, 'Clicks', 'Region');
			}
			return false;
		
	}

public function getPieChartConv($AdvertiserID)
	{
		$lastthirtydays = date('Y-m-d', strtotime('-29 day'));
		$query = $this->rdb->query($this->query->geoConvPieGraph,array($lastthirtydays,$AdvertiserID));
		if ($query->num_rows() > 0) 
			{
				 $rows = $query->result_array();
				 return $this->getPieChartData($rows, 'Conversions', 'Region');
			}
			return false;
		
	}		
	
private function getPieChartData($stats,$stat_type = '',$geoType = 'Region'){
		if(empty($stat_type)){
			return false;
		}
		
		//code tobe removed after region correction start here
		$countries = $this->config->item('Countries');
		$IA_Geo_FIPS = $this->config->item('IA_Geo_FIPS');
		$regCodeArr = array();
		foreach ($stats as $data){
			if(strlen($data['Region']) == 2){
				$countryCode = array_search($data['Country'], $countries);
				$regionName = $IA_Geo_FIPS[$countryCode][$data['Region']];
				$data['Region']= $regionName;
				$regCodeArr[] = $data;
			}else{
				$regArr[] = $data;
			}
		}
		//var_dump($regCodeArr, $regArr);
		$finalRegArr = array();
		if(!empty($regCodeArr)){
			foreach ($regArr as $regKey=>$regionData){
				foreach ($regCodeArr as $regCodeKey=>$rCodeData){
					if($regionData['Region'] == $rCodeData['Region']){
						$finalRegArr[] = array('Region'=>$regionData['Region'], $stat_type=>(string)($rCodeData[$stat_type] + $regionData[$stat_type]));
						unset($regCodeArr[$regCodeKey]);
						unset($regArr[$regKey]);
					}
				}
			}
			$finalRegArr = array_merge($regCodeArr, $regArr, $finalRegArr);
		}else{
			$finalRegArr = $regArr;
		} 
		//code tobe removed after region correction end here
		
		$str = '';
		for($i=0;$i<5;$i++)
		{
			$str .= "['".addslashes($finalRegArr[$i][$geoType])."',   ".addslashes($finalRegArr[$i][$stat_type])."],";
		}
		
		return trim($str,',');
	}

public function  getImp($AdvertiserID)
		{
		$today = date('Y-m-d').' 23:59:59';
		$yesterday = date('Y-m-d', strtotime('-1 day'));
		$query = $this->rdb->query($this->query->impVal,array($today, $yesterday,$AdvertiserID));
		if ($query->num_rows > 0)
		{
			foreach ($query->result_array() as $row){
				if($row['ACDateTime'] == date('Y-m-d'))
				{
					$data[1] = $row['ACImpressions'];
				}
				else
				{
					$data[] = $row['ACImpressions'];
				}
			}
			return $data;
		}
		return false;	
}

public function  getClick($AdvertiserID)
		{
		$today = date('Y-m-d').' 23:59:59';
		$yesterday = date('Y-m-d', strtotime('-1 day'));
		$query = $this->rdb->query($this->query->clickVal,array($today, $yesterday,$AdvertiserID));
		if ($query->num_rows > 0)
		{
			foreach ($query->result_array() as $row){
				if($row['ACDateTime'] == date('Y-m-d'))
				{
					$data[1] = $row['ACClicks'];
				}
				else
				{
					$data[] = $row['ACClicks'];
				}
			}
			return $data;
		}
		return false;	
}

public function  getConv($AdvertiserID)
		{
		$today = date('Y-m-d').' 23:59:59';
		$yesterday = date('Y-m-d', strtotime('-1 day'));
		$query = $this->rdb->query($this->query->convVal,array($today, $yesterday,$AdvertiserID));
		if ($query->num_rows > 0)
		{
			foreach ($query->result_array() as $row){
				if($row['ACDateTime'] == date('Y-m-d'))
				{
					$data[1] = $row['ACConversions'];
				}
				else
				{
					$data[] = $row['ACConversions'];
				}
			}
			return $data;
		}
		return false;	
}
public function  getRev($AdvertiserID)
		{
		$today = date('Y-m-d').' 23:59:59';
		$yesterday = date('Y-m-d', strtotime('-1 day'));
		$query = $this->rdb->query($this->query->revVal,array($today, $yesterday,$AdvertiserID));
		//echo $this->rdb->last_query();
		if ($query->num_rows > 0)
		{
			foreach ($query->result_array() as $row){
				if($row['ACDateTime'] == date('Y-m-d'))
				{
					$data[1] = $row['ACTotalRevenue'];
				}
				else
				{
					$data[] = $row['ACTotalRevenue'];
				}
			}
			return $data;
		}
		return false;	
}

public function getGraphData($AdvertiserID)
	{
		$this->rdb->select ('sum(ACImpressions) AS Impression,sum(ACClicks) AS Click,sum(ACConversions) AS Conversion, date(ACDateTime) AS ACDateTime');
		$this->rdb->where('ACDateTime >= ', date("Y-m-d", strtotime("-14 day")));
		$this->rdb->where('ACAdvertiserID', $AdvertiserID);	
		$this->rdb->where('ACType', 1);
		$this->rdb->group_by('ACDateTime');
		$this->rdb->order_by('ACDateTime', 'asc');
		for($n = 14;$n>=0;$n--)
		{
			$dates[] = date ('Y-m-d', strtotime ( '-'.$n.' day' . $now ) );
		}
		$query = $this->rdb->get('AggCampaignReport');
		if ($query->num_rows > 0){
			$graphdata = array();
			$impression = array();
			$click = array();
			$conversion = array();
			foreach ($query->result() as $row)
			{
				$impression[$row->ACDateTime] = $row->Impression;
				$click[$row->ACDateTime] = $row->Click;
				$conversion[$row->ACDateTime] = $row->Conversion;
				
			}
		}
		foreach($dates as $date)
		{
			$keyDates = array_keys($impression);
			if(in_array($date, $keyDates))
			{
				$graphdata[0][date('d M',strtotime($date))] = (int)$impression[$date];
				$graphdata[1][date('d M',strtotime($date))] = (int)$click[$date];
				$graphdata[2][date('d M',strtotime($date))] = (int)$conversion[$date];
				
			}
			else
			{
				$graphdata[0][date('d M',strtotime($date))] = 0;
				$graphdata[1][date('d M',strtotime($date))] = 0;
				$graphdata[2][date('d M',strtotime($date))] = 0;
			}
		}
		return $graphdata;
		
}
//
public function  getImpression()
	{
		$today = date('Y-m-d').' 23:59:59';
		$yesterday = date('Y-m-d', strtotime('-29 day'));
		$query = $this->rdb->query($this->query->dashboardRev,array($today, $yesterday));
		if ($query->num_rows > 0){
			foreach ($query->result_array() as $row){
				if($row['ACDateTime'] == date('Y-m-d')){
					$data[1] = $row['ACTotalRevenue'];
				}else{
			$data[] = $row['ACTotalRevenue'];
			}
			}
			return $data;
		}
		return false;	
    }
}
?>