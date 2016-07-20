<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller{
   
    function __construct(){
        parent::__construct();
		$this->load->model('authentication');
    	//$this->authentication->isLoggedIn();  
		$this->load->model('dashboard_model');
	    }

    public function index(){
    	$data['menu'] = 'dashboard';
    	$data['successmsg'] = '';
    	$data['errmsg'] = '';
    	$data['showosdevice'] = 0;
    	//date initialization
    	$today = date('Y-m-d');
    	$data['today'] = $today;
    	$data['yesterday'] = date('Y-m-d', strtotime('-1 days'));
    	$data['last7days'] = date('Y-m-d', strtotime('-7 days'));
    	$data['thismonth'] = date('Y-m-01');
    	$data['lastmonth'] = date('Y-m-01', strtotime('-1 months'));
    	$data['lastmonth_end'] = date('Y-m-d', strtotime('last day of previous month'));
    	$data['rType'] = 'thismonth';
    	
    	if(!empty($_POST)){
    		$data['rType'] = $this->security->xss_clean($this->input->post('range'));
    	}
    	
    	//initialize start and end date
    	switch ($data['rType']){
    		case 'today':
    			$data['start_date'] = $data['today'];
    			$data['end_date'] = $data['today'];
    			break;
    		case 'yesterday':
    			$data['start_date'] = $data['yesterday'];
    			$data['end_date'] = $data['yesterday'];
    			break;
    		case 'last7days':
    			$data['start_date'] = $data['last7days'];
    			$data['end_date'] = $data['yesterday'];
    			break;
    		case 'thismonth':
    			$data['start_date'] = $data['thismonth'];
    			$data['end_date'] = $data['today'];
   				break;
   			case 'lastmonth':
   				$data['start_date'] = $data['lastmonth'];
   				$data['end_date'] = $data['lastmonth_end'];
   				break;
   			case 'specific':
   				$data['start_date'] = date('Y-m-d', strtotime($this->security->xss_clean($this->input->post('start_date'))));
   				$data['end_date'] = date('Y-m-d', strtotime($this->security->xss_clean($this->input->post('end_date'))));
   				break;
   			default:
    			$data['start_date'] = $data['today'];
    			$data['end_date'] = $data['today'];
    			break;
    	}
    	
    	if($this->input->post('showosdevice') == 1){
    		$data['showosdevice'] = 1;
    		$data['osbreakdown']= $this->dashboard_model->getOsBreakdown($data['start_date'], $data['end_date']);
    		$data['devicebreakdown']= $this->dashboard_model->getDeviceBreakdown($data['start_date'], $data['end_date']);
    	}
    	
		$data['campaigncount']= $this->dashboard_model->getCampaigns($data['start_date'], $data['end_date']);
		$data['propertycount'] = $this->dashboard_model->getProperties($data['start_date'], $data['end_date']);
		$data['graphdata'] = $this->dashboard_model->getGraphData($data['start_date'], $data['end_date']);
		if(empty($data['graphdata'])){
			$data['graphImpData'] = '[]';
			$data['graphClicksData'] = '[]';
		}else{
			$data['graphImpData'] = json_encode($data['graphdata'][0]);
			$data['graphClicksData'] = json_encode($data['graphdata'][1]);
		}
		
		$this->load->view('admin/dashboard_view', $data);	
	   }
}
?>