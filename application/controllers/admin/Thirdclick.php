<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thirdclick extends CI_Controller{
	 
	function __construct(){
		parent::__construct();
		$this->load->model('authentication');
		$this->authentication->isLoggedIn(array(ACCOUNT_ADMIN));
		$this->load->model(array('admin/themes_model', 'admin/question_model', 'admin/category_model'));
		$this->load->library(array('form_validation'));
	}

	public function index($id = ''){
		$categoryData = $this->themes_model->getAllCategories();
		$categories = array();
		$categories['themes'] = '';
		foreach ($categoryData as $catd){
			if($catd->parentid > 0 && $id == $catd->parentid){
				$categories[$catd->parentid][]= array('id' => $catd->id, 'name' => $catd->name, 'status' => $catd->status, 'priority' => $catd->priority, 'thirdclick' => $catd->thirdclick);
			}elseif($catd->parentid == 0){
				$categories['themes'][] = array('id' => $catd->id, 'name' => $catd->name, 'status' => $catd->status, 'priority' => $catd->priority, 'thirdclick' => $catd->thirdclick);
			}
		}
		$data['categories'] = $categories;
		$data['id'] = $id;
		 
		$this->load->view('admin/thirdclick_view', $data);
	}

	public function add(){
		//{pid: theme, cid: secondclick, question:quest, priority: priority, status: status, answer:answer}
		
		$this->form_validation->set_rules('cid', 'Category', 'required');
		 
		if ($this->form_validation->run() == TRUE) {
			$quest['question']  		= $this->security->xss_clean($this->input->post('question'));
			$quest['answer']       = $this->security->xss_clean($this->input->post('answer'));
			$quest['status']	= $this->security->xss_clean($this->input->post('status'));
			$quest['priority']	= $this->security->xss_clean($this->input->post('priority'));
			$thirdclick	= $this->security->xss_clean($this->input->post('thirdclick'));
			
			if(!$thirdclick){
				$quest['question']  ='';
				$quest['answer']    = $this->security->xss_clean($this->input->post('answer'));
				$quest['status']	= 1;
				$quest['priority']	= 2;
			}
			$questId = $this->question_model->addQuestion($quest);
			if($questId){
				$cid	= $this->security->xss_clean($this->input->post('cid'));
				$data['thirdclick'] = $thirdclick;
				$this->category_model->updateCategory($cid, $data);
				if($cid > 0 && $questId > 0 ){
					$cats[] = $cid;
					$view_data = $this->category_model->assocCatQuestion($cats, $questId);
				}
				echo 1;
			}else{
				echo 0;
			}			
		}
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
					$cat['name']       = $this->security->xss_clean($this->input->post('category'));
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
	
	public function getSecondClicks(){
		$id = $this->security->xss_clean($this->input->post('id'));
		$id = (int)$id;
		
		$categoryData = $this->themes_model->getAllCategories($id);
		echo json_encode($categoryData);exit;
		$categories = array();
		$categories['themes'] = '';
		foreach ($categoryData as $catd){
			if($catd->parentid > 0 && $id == $catd->parentid){
				$categories[$catd->parentid][]= array('id' => $catd->id, 'name' => $catd->name, 'status' => $catd->status, 'priority' => $catd->priority, 'thirdclick' => $catd->thirdclick);
			}elseif($catd->parentid == 0){
				$categories['themes'][] = array('id' => $catd->id, 'name' => $catd->name, 'status' => $catd->status, 'priority' => $catd->priority, 'thirdclick' => $catd->thirdclick);
			}
		}
		$data['categories'] = $categories;var_dump($categories);
		$data['id'] = $id;
			
		//$this->load->view('admin/thirdclick_view', $data);
	}
}
?>