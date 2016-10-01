<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listeners extends CI_Controller{
   
    function __construct(){
        parent::__construct();
    	//$this->authentication->isLoggedIn();  
		$this->load->model(array('user/listeners_model'));
	    }

    public function index(){
    	$data['listeners'] = $this->listeners_model->getListeners();
		$this->load->view('user/listeners_view', $data);	
	   }
	   
	   public function lists(){
	   	$categoryData = $this->category_model->getAllCategories();
	   	$categories = array();
	   	$categories['themes'] = '';
	   	foreach ($categoryData as $catd){
	   		if($catd->parentid > 0){
	   			$categories[$catd->parentid][]= array('id' => $catd->id, 'name' => $catd->name, 'status' => $catd->status);
	   		}elseif($catd->parentid == 0){
	   			$categories['themes'][] = array('id' => $catd->id, 'name' => $catd->name, 'status' => $catd->status);
	   		}
	   	}
	   	$data['categories'] = $categories;
	   	 
	   	$this->load->view('admin/category_view', $data);
	   }
	   
	   public function add(){
	   	$data['successmsg'] = '';
	   	$data['errmsg'] = '';
	   	$this->form_validation->set_rules('themetype', 'Theme', 'required');
	   	$this->form_validation->set_rules('category', 'Category', 'required');
	   	 
	   	if ($this->form_validation->run() == TRUE) {
	   		$cat['parentid']  		= $this->security->xss_clean($this->input->post('themetype'));
	   		$cat['name']       = $this->security->xss_clean($this->input->post('category'));
	   		$cat['status']	= 1;
	   		 
	   		if(empty($data['errmsg'])){
	   			$result = $this->category_model->addCategory($cat);
	   			if($result){
	   				$data['successmsg'] = 'Category added successfully.';
	   			}else{
	   				$data['errmsg'] = 'Something went wrong, please try again.';
	   			}
	   		}
	   	}
	   	$data['themes'] = $this->category_model->getAllThemes();
	   	$this->load->view('admin/addcategory_view', $data);
	   }
	   
	   public function edit($id){
	   	if(!empty($id)){
	   		$data['successmsg'] = '';
	   		$data['errmsg'] = '';
	   		if($this->input->post('category')){
	   			$this->form_validation->set_rules('themetype', 'Theme', 'required');
	   			$this->form_validation->set_rules('category', 'Category', 'required');
	   			$this->form_validation->set_rules('priority', 'Priority', 'required');
	   			$this->form_validation->set_rules('status', 'Status', 'required');
	   	   
	   			if ($this->form_validation->run() == TRUE) {
	   				$cat['parentid']  		= $this->security->xss_clean($this->input->post('themetype'));
	   				$cat['name']       = $this->security->xss_clean($this->input->post('category'));
	   				$cat['priority']       = $this->security->xss_clean($this->input->post('priority'));
	   				$cat['status']	= $this->security->xss_clean($this->input->post('status'));;
	   
	   				if(empty($data['errmsg'])){
	   					$result = $this->category_model->updateCategory($id, $cat);
	   					if($result){
	   						$data['successmsg'] = 'Category updated successfully.';
	   					}else{
	   						$data['errmsg'] = 'Something went wrong, please try again.';
	   					}
	   				}
	   			}
	   		}
	   	}else{
	   		$data['errmsg'] = 'Invalid details.';
	   	}
	   	$data['category'] = $this->category_model->getCategoryDetails($id);
	   	$data['category'] = $data['category'][0];
	   	$data['themes'] = $this->category_model->getAllThemes();
	   	 
	   	$this->load->view('admin/editcategory_view', $data);
	   }
}
?>