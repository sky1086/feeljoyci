<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Guide extends CI_Controller {
	function __construct() {
		parent::__construct ();
		// $this->authentication->isLoggedIn();
		$this->load->model ( array (
				'admin/question_model',
				'admin/category_model' 
		) );
		$this->load->library ( array (
				'common' 
		) );
		if (isset ( $_SERVER ['HTTP_ORIGIN'] )) {
			// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
			// you want to allow, and if so:
			header ( "Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}" );
			header ( 'Access-Control-Allow-Credentials: true' );
			header ( 'Access-Control-Max-Age: 86400' ); // cache for 1 day
		} else {
			header ( 'Access-Control-Allow-Origin: *' ); // need to remove after developement done
		}
	}
	public function index() {
		$data ['topics'] = $this->category_model->getAllThemes ();
		$result = $this->processResponse ( $data ['topics'] );
		
		// var_dump($result);
		echo json_encode ( $result );
	}
	public function clicks($url, $subtopic = '', $question = '') {
		if (empty ( $url )) {
			echo json_encode ( array (
					'error' => true,
					'result' => 'Invalid URL' 
			) );
			exit ();
		}
		
		$result = [ ];
		if (! empty ( $subtopic ) && ! empty ( $question )) {
			$result = $this->processAnswerPage ( $subtopic, $question );
			echo json_encode ( $result );
			exit ();
		}
		
		if (! empty ( $subtopic )) {
			$result = $this->processSubTopic ( $subtopic );
			echo json_encode ( $result );
			exit ();
		}
		
		$data ['category'] = $this->category_model->getCategoryByNormalizedName ( $url );
		if (count ( $data ['category'] )) {
			$categoryData = $data ['category'] [0];
			$id = $categoryData->id;
			$details = $this->category_model->getAllThemes ( $id );
			$result = $this->processResponse ( $details );
		}
		echo json_encode ( $result );
		exit ();
	}
	
	public function processSubTopic($subtopic) {
		$category = $this->category_model->getCategoryByNormalizedName ( $subtopic );
		if (count ( $category )) {
			$categoryData = $category [0];
			$id = $categoryData->id;
			
			// get associated questions
			$questions = $this->question_model->getAssocQuestionDetails ( $id );
			if (! count ( $questions )) {
				return [ ];
			}
			
			if ($categoryData->thirdclick == 0) {
				// this has no thirdclik, show answer page here
				$result [0] ['answerPage'] = 1;
				$result [0] ['question'] = $questions [0]->question;
				$cards = [];
				if(!empty($questions [0]->answer)){
					$cards = explode('##$##', $questions [0]->answer);
				}
				$result [0] ['answer'] = $cards;
				
				return $result;
			}
			
			// list all associated questions
			$i = 0;
			foreach ( $questions as $question ) {
				$result [$i] ['name'] = $question->question;
				$result [$i] ['url'] = $this->common->getNormalizedName ( $question->question );
				$i ++;
			}
			return $result;
		}
	}
	function processAnswerPage($subtopic, $question = '') {
		$category = $this->category_model->getCategoryByNormalizedName ( $subtopic );
		if (count ( $category )) {
			$categoryData = $category [0];
			$id = $categoryData->id;
			// get associated questions
			$questions = $this->question_model->getAssocQuestionDetails ( $id );
			$questionCount = count ( $questions );
			if (! $questionCount) {
				return [ ];
			}
			
			for ($i = 0 ; $i < $questionCount; $i++){
				if($question == $this->common->getNormalizedName ( $questions [$i]->question)){
					$result [0] ['answerPage'] = 1;
					$result [0] ['question'] = $questions [$i]->question;
					$cards = [];
					if(!empty($questions [$i]->answer)){
						$cards = explode('##$##', $questions [$i]->answer);
					}
					$result [$i] ['answer'] = $cards;
					//$result [$i] ['answer'] = $questions [$i]->answer;
					return $result;
				}
			}
			// this has no thirdclik, show answer page here
			$result [0] ['answerPage'] = 1;
			$result [0] ['question'] = $questions [0]->question;
			$cards = [];
			if(!empty($questions [0]->answer)){
				$cards = explode('##$##', $questions [0]->answer);
			}
			$result [0] ['answer'] = $cards;
			return $result;
		}
	}
	function processResponse($data) {
		if (! count ( $data )) {
			return [ ];
		}
		
		$result = [ ];
		$i = 0;
		foreach ( $data as $topic ) {
			$result [$i] ['name'] = $topic->name;
			$result [$i] ['url'] = (! empty ( $topic->normalized_name ) ? $topic->normalized_name : $this->common->getNormalizedName ( $topic->name ));
			$i ++;
		}
		return $result;
	}
}
?>