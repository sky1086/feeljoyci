<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends CI_Controller{
   
    function __construct(){
        parent::__construct();
		$this->load->model('authentication');
    	$this->authentication->isLoggedIn(array(ACCOUNT_ADMIN));  
		$this->load->model('admin/question_model');
		$this->load->library(array('form_validation'));
	    }

    public function index(){
    	$queData = $this->question_model->getAllQuestions();
    	$data['quiz_data'] = $queData;
    	
		$this->load->view('admin/question_view', $data);
    }
    
    public function add(){
    	$data['successmsg'] = '';
    	$data['errmsg'] = '';
    	$this->form_validation->set_rules('question', 'Question', 'required');
    	$this->form_validation->set_rules('answer', 'Answer', 'required');
    	
    	if ($this->form_validation->run() == TRUE) {
    		$cat['question']  		= $this->security->xss_clean($this->input->post('question'));
    		$cat['answer']       = $this->security->xss_clean($this->input->post('answer'));
    		$cat['status']	= 1;
    		 
    		if(empty($data['errmsg'])){
    			$result = $this->question_model->addQuestion($cat);
    			if($result){
    				$data['successmsg'] = 'Question added successfully.';
    			}else{
    				$data['errmsg'] = 'Something went wrong, please try again.';
    			}
    		}
    	}
    	$this->load->view('admin/questionadd_view', $data);
    }
    
    public function edit($id){
    	if(!empty($id)){
    	$data['successmsg'] = '';
    	$data['errmsg'] = '';
    	if($this->input->post('question')){
	    	$this->form_validation->set_rules('question', 'Question', 'required');
	    	$this->form_validation->set_rules('answer', 'Answer', 'required');
	    	$this->form_validation->set_rules('status', 'Status', 'required');
	    	 
	    	if ($this->form_validation->run() == TRUE) {
	    		$detail['id']  		= $id;
	    		$detail['question']       = $this->security->xss_clean($this->input->post('question'));
	    		$detail['answer']       = $this->security->xss_clean($this->input->post('answer'));
	    		$detail['status']	= $this->security->xss_clean($this->input->post('status'));;
	    		 
	    		if(empty($data['errmsg'])){
	    			$result = $this->question_model->updateQuestion($id, $detail);
	    			if($result){
	    				$data['successmsg'] = 'Question updated successfully.';
	    			}else{
	    				$data['errmsg'] = 'Something went wrong, please try again.';
	    			}
	    		}
	    	}
    	}
    	}else{
    		$data['errmsg'] = 'Invalid details.';
    	}
    	$data['question'] = $this->question_model->getQuestionDetails($id);
    	$data['question'] = $data['question'][0];
   
    	$this->load->view('admin/questionedit_view', $data);
    }
}
?>