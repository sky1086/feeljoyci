<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Themes extends CI_Controller{
   
    function __construct(){
        parent::__construct();
		$this->load->model('authentication');
    	$this->authentication->isLoggedIn(array(ACCOUNT_ADMIN));  
		$this->load->model('admin/listener/themes_model');
		$this->load->library(array('form_validation', 'common'));
	    }

    public function index(){
    	$categoryData = $this->themes_model->getAllCategories();
    	$categories = array();
    	$categories['themes'] = '';
    	foreach ($categoryData as $catd){
    		if($catd->parentid > 0){
    			$categories[$catd->parentid][]= array('id' => $catd->id, 'name' => $catd->name, 'status' => $catd->status, 'priority' => $catd->priority, 'thirdclick' => $catd->thirdclick);
    		}elseif($catd->parentid == 0){
    			$categories['themes'][] = array('id' => $catd->id, 'name' => $catd->name, 'status' => $catd->status, 'priority' => $catd->priority, 'thirdclick' => $catd->thirdclick);
    		}
    	}
    	$data['categories'] = $categories;
    	
		$this->load->view('admin/listener/theme_view', $data);
    }
    
    public function add(){
    	$data['successmsg'] = '';
    	$data['errmsg'] = '';
    	$this->form_validation->set_rules('themetype', 'Theme', 'required');
    	$this->form_validation->set_rules('category', 'Category', 'required');
    	
    	if ($this->form_validation->run() == TRUE) {
    		$cat['parentid']  		= $this->security->xss_clean($this->input->post('themetype'));
    		$cat['name']       = $this->security->xss_clean($this->input->post('category'));
    		$cat['normalized_name']   = $this->common->getNormalizedName($cat['name']);
    		$cat['status']	= $this->security->xss_clean($this->input->post('status'));
    		$cat['priority']	= $this->security->xss_clean($this->input->post('priority'));
    		$cat['thirdclick']       = 1;
    		 
    		if(empty($data['errmsg'])){
    			$result = $this->themes_model->addCategory($cat);
    			if($result){
    				$data['successmsg'] = 'Category added successfully.';
    			}else{
    				$data['errmsg'] = 'Something went wrong, please try again.';
    			}
    		}
    	}
    	echo 1;
    	//$data['themes'] = $this->themes_model->getAllThemes();
    	//$this->load->view('admin/addcategory_view', $data);
    }
    
    public function edit(){    	
    	$id = $this->security->xss_clean($this->input->post('id'));
    	$id = (int)$id;
    	if(!empty($id)){
    	$data['successmsg'] = '';
    	$data['errmsg'] = '';
    	if($this->input->post('category')){
	    	$this->form_validation->set_rules('category', 'Category', 'required');
	    	$this->form_validation->set_rules('priority', 'Priority', 'required');
	    	$this->form_validation->set_rules('status', 'Status', 'required');
	    	 
	    	if ($this->form_validation->run() == TRUE) {
	    		$cat['parentid']  		= 0;
	    		$cat['name']       = $this->security->xss_clean($this->input->post('category'));
	    		$cat['normalized_name']   = $this->common->getNormalizedName($cat['name']);
	    		$cat['priority']       = $this->security->xss_clean($this->input->post('priority'));
	    		$cat['status']	= $this->security->xss_clean($this->input->post('status'));
	    		 
	    		if(empty($data['errmsg'])){
	    			$result = $this->themes_model->updateCategory($id, $cat);
	    			if($result){
	    				$data['errmsg'] = 'Category updated successfully.';
	    			}else{
	    				$data['errmsg'] = 'Something went wrong, please try again.';
	    			}
	    		}
	    	}
    	}
    	}else{
    		$data['errmsg'] = 'Invalid details.';
    	}
    	
    	echo $data['errmsg'];
    }
}
?>