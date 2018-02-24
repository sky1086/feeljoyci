<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thirdclick extends CI_Controller{
	 
	function __construct(){
		parent::__construct();
		$this->load->model('authentication');
		$this->authentication->isLoggedIn(array(ACCOUNT_ADMIN));
		$this->load->model(array('admin/listener/themes_model', 'admin/listener/question_model', 'admin/listener/category_model'));
		$this->load->library(array('form_validation'));
		error_reporting(0);
	}

	public function index($id = ''){
		$id = (int)$id;
		$thirdclick = 1;
		if($id){
			$queData = $this->question_model->getQuestionCompleteDetails($id);
			$data['questiondata'] = $queData;
			$thirdclick = $queData['thirdclick'];
		}
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
		$data['thirdclick'] = $thirdclick;
		 //var_dump($data);exit;
		$this->load->view('admin/listener/thirdclick_view', $data);
	}

	public function add(){
		//{pid: theme, cid: secondclick, question:quest, priority: priority, status: status, answer:answer}
		$this->form_validation->set_rules('cid', 'Category', 'required');
		 
		if ($this->form_validation->run() == TRUE) {
			$id  		= $this->security->xss_clean($this->input->post('questionid'));
			$quest['question']  		= $this->security->xss_clean($this->input->post('question'));
			$quest['answer']       = $this->input->post('answer');
			$quest['status']	= $this->security->xss_clean($this->input->post('status'));
			$quest['priority']	= $this->security->xss_clean($this->input->post('priority'));
			$thirdclick	= $this->security->xss_clean($this->input->post('thirdclick'));
			
			if(!$thirdclick && !$id){
				$quest['question']  ='';
				$quest['answer']    = $this->input->post('answer');
				$quest['status']	= 1;
				$quest['priority']	= 2;
			}
			if($id > 0){
				$this->question_model->updateQuestion($id, $quest);
				$questId = $id;
			}else{
				$questId = $this->question_model->addQuestion($quest);
			}
			
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
	
	public function listing($id = 0){
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
			
		$this->load->view('admin/listener/thirdclicklist_view', $data);
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
		$data['categories'] = $categories;
		$data['id'] = $id;
			
		//$this->load->view('admin/thirdclick_view', $data);
	}
	
	public function getThirdClicks($cid = 0){
		$cid = (int)$cid;
		
		if(!$cid){
			$res['data'] = [];
			echo json_encode($res);
			exit;
		}
		
		$data = $this->question_model->getAssocQuestionDetailsAll($cid);
		$result = [];
		$showAnsDiv = '';
		foreach ($data as $row){
			$title = empty($row->question)?'-N-A-':$row->question;
			$link = '<a href="'.base_url().'admin/listener/thirdclick/index/'.$row->id.'" onclick="window.location=this.href;"><i class="ion-edit" style="font-size:18px;"></i>&nbsp;Edit</a>';
			$showAns = '<a class="js-open-modal" href="javascript:void(0);" onclick="applyPopup()" data-modal-id="answer'.$row->id.'">Show Answer</a>';
			$showAnsDiv .= '<div id="answer'.$row->id.'" class="modal-box">
  <header> <a href="#" class="js-modal-close close">x</a>
    <h3>Answer</h3>
  </header>
  <div class="modal-body">
    <p>'.$row->answer.'</p>
  </div>
  <footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>
</div>';
			$resArr = [$row->id, $title, $showAns, $row->priority, $row->status, $link];	
			$result[] = $resArr;
		}
		$res['data'] = $result;
		$res['popupDiv'] = $showAnsDiv;
		echo json_encode($res);
	}
}
?>
