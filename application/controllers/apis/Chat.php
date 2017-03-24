<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	//error_reporting(0);
	class Chat extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('authentication');
			//$this->authentication->isLoggedIn();
			//$this->permission->enforceAccount(ACCOUNT_USER, ACCOUNT_LISTENER);
			$this->load->model(array(
					'chat/chat_model'
			));
			$this->load->library(array(
					'form_validation'
			));
			if (isset($_SERVER['HTTP_ORIGIN'])) {
				// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
				// you want to allow, and if so:
				header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
				header('Access-Control-Allow-Credentials: true');
				header('Access-Control-Max-Age: 86400');    // cache for 1 day
			}else{
				header('Access-Control-Allow-Origin: *'); //need to remove after developement done
			}
		}

		public function index()
		{
			$json = '';
			if(isset($_POST['rq'])):
			$myid = isset($_POST['myid'])?(int)$_POST['myid']:0;
			if(!$myid){
				$myid = $this->session->userdata('userid');
			}
			
			if (!isset($_POST['fid'])) {
				$fid = 0;
			}else{
				$fid = $_POST['fid'];
			}
			if (!isset($_POST['lastid'])) {
				$lid = 0;
			}else{
				$lid = $_POST['lastid'];
			}

			//include_once BASEPATH.'../lib-emoji/Emoji.class.php';
			switch($_POST['rq']):
			case 'new':
				$msg = trim($_POST['msg']);
				if(empty($msg)){
					$json = array('status' => 0, 'msg'=> 'Enter your message!.');
				}else{
					//$qur = mysql_query('insert into msg set `to`="'.$fid.'", `from`="'.$myid.'", `msg`="'.$msg.'", `status`="1"');
					$enc_data = $this->chat_model->encodeMsg($msg);
					$msgArr = array('to' => $fid, 'from' => $myid, 'msg' => $enc_data[0], 'int_vec' => $enc_data[1], 'status' => 1, 'time' => date('Y-m-d H:i:s'));
					$qur = $this->chat_model->insertMsg($msgArr);
					if($qur){
						//$qurGet = mysql_query("select * from msg where id='".mysql_insert_id()."'");
						$qurGet = $this->chat_model->getMsgById($qur);
						$json = array('status' => 1, 'msg' => trim($this->chat_model->decodeMsg($qurGet['msg'], $qurGet['int_vec'])), 'lid' => $qur, 'time' => $qurGet['time']);
						//while($row = mysql_fetch_array($qurGet)){
						//$json = array('status' => 1, 'msg' => $row['msg'], 'lid' => mysql_insert_id(), 'time' => $row['time']);
						//}
					}else{
						$json = array('status' => 0, 'msg'=> 'Unable to process request.');
					}
				}
				break;
			case 'msg':
				if(empty($myid)){

				}else{
					//print_r($_POST);
					$msgArr = array('to' => $myid, 'status' => 1);
					if($fid)
						$msgArr['from'] = $fid;
						if($lid)
							$msgArr['lid'] = $lid;

							$qurGet = $this->chat_model->getMsgsWhere($msgArr);
							//$qur = mysql_query("select * from msg where `to`='$myid' && `from`='$fid' && `status`=1");
							if($qurGet != false && count($qurGet) > 0){
								unset($msgArr['lid']);
								$qurGetMsg = $this->chat_model->getUsrLastMsgWhere($msgArr, $lid);
								//$qur = mysql_query("select * from msg where `to`='$myid' && `from`='$fid' && `status`=1 order by id desc limit 1");
								//while($rw = mysql_fetch_array($qur)){
								$ids = array();
								if(!empty($qurGetMsg)){
									$msg = '';
									foreach ($qurGetMsg as $msr=>$msv){
										$decoded_msg = $this->chat_model->decodeMsg($msv['msg'], $msv['int_vec']);
										$decoded_msg = trim($decoded_msg);
										$msg .= $decoded_msg;
										$ids[] = $msv['id'];
									}
									$json = array('status' => 1, 'msg' => $msg, 'lid' => end($ids), 'time'=> $msv['time'], 'from' => $msv['from']);
								}else{
									$json = array('status' => 0);
								}
								//}
								// update status
								//$whrArr = array('id' => $qurGet['id']);
								if(!empty($ids))
									$this->chat_model->upChatStatus(0, $ids);
							}else{
								$json = array('status' => 0);
							}
				}
				break;
			case 'NewMsg':
				$msgArr = array('to' => $myid, 'status' => 1);
				if($fid)
					$msgArr['from'] = $fid;
						
					$qurGet = $this->chat_model->getUsrLastMsgWhere($msgArr, $lid);
					//$qur = mysql_query("select * from msg where `to`='$myid' && `from`='$fid' && `status`=1 order by id desc limit 1");
					//while($rw = mysql_fetch_array($qur)){
					$ids = array();
					if(!empty($qurGet)){
						$msg = '';
						foreach ($qurGet as $msr=>$msv){
							$decoded_msg = $this->chat_model->decodeMsg($msv['msg'], $msv['int_vec']);
							$decoded_msg = trim($decoded_msg);
							$msg .= $decoded_msg;
							$ids[] = $msv['id'];
						}
						$json = array('status' => 1, 'msg' => $msg, 'lid' => end($ids), 'time'=> $msv['time'], 'from' => $msv['from']);
					}else{
						$json = array('status' => 0);
					}
					//}
					// update status
					//$whrArr = array('id' => $qurGet['id']);
					if(!empty($ids))
						$this->chat_model->upChatStatus(0, $ids);
						//$up = mysql_query("UPDATE `msg` SET  `status` = '0' WHERE `to`='$myid' && `from`='$fid'");
						break;
			case 'oMsg':
				$msgArr = array('from' => $myid);
				if($fid)
					$msgArr['to'] = $fid;

					$qurGet = $this->chat_model->getUsrOldMsgWhere($myid, $msgArr, 100);
					//$qur = mysql_query("select * from msg where `to`='$myid' && `from`='$fid' && `status`=1 order by id desc limit 1");
					//while($rw = mysql_fetch_array($qur)){
						
					if(!empty($qurGet)){
						/*foreach ($qurGet as $msr=>$msv){
							$decoded_msg = $this->chat_model->decodeMsg($msv['msg'], $msv['int_vec']);
							$msg = Emoji::html_to_emoji($decoded_msg);
							$qurGet[$msr]['msg'] = $msg;
							if($ms_num > 1){
							$qurGet[$msr]['cls'] = '';
							if($msv == reset($qurGet))
								$qurGet[$msr]['cls'] = 'first';
								if($msv == end($qurGet))
									$qurGet[$msr]['cls'] = 'last';
									}
									unset($qurGet[$msr]['int_vec']);
									}*/
								$json = array('status' => 1, 'msgData' => $qurGet);
					}else{
						$json = array('status' => 0);
					}
					break;
					endswitch;
					endif;

					//header('Content-type: application/json');
					echo json_encode($json);
		}
		
		public function like(){
			$json = '';
			$myid = isset($_POST['myid'])?(int)$_POST['myid']:0;
			if(!$myid){
				$myid = $this->session->userdata('userid');
			}
				
			if (!isset($_POST['fid'])) {
				$fid = 0;
			}else{
				$fid = $_POST['fid'];
			}
			if (!isset($_POST['msgid'])) {
				$lid = 0;
			}else{
				$lid = $_POST['msgid'];
			}
			$likeStatus = isset($_POST['status'])?(int)$_POST['status']:0;
			
			if(!$lid || !$fid || !$myid){
				$json = array('error' => true, 'msg'=> 'Invalid parameters');
				echo json_encode($json);
				exit;
			}
			
			$qur = $this->chat_model->updateLikedStatus($lid, $myid, $fid, $likeStatus);
			
			if($qur){
				$json = array('error' => false, 'msg'=> 'Updated successfully');
			}else{
				$json = array('error' => true, 'msg'=> 'Something went wrong');
			}
			
			echo json_encode($json);
		}
		
		public function unreadMsgCount(){
			$json = '';
			$uid = $this->session->userdata('userid');
			if(!$uid){
				$json = array('error' => true, 'msg'=> 'Invalid user id');
				echo json_encode($json);
				exit;
			}
				
			$msgCount = $this->chat_model->unreadMsgCount($uid);

			$json = array('error' => false, '$msgCount'=> $msgCount);	
			echo json_encode($json);
		}
		
		public function recentLikedMsg($myid, $fid){
			$json = '';
			$myid = (int)$myid;
			$fid = (int)$fid;
			if(!$fid || !$myid){
				$json = array('error' => true, 'msg'=> 'Invalid parameters');
				echo json_encode($json);
				exit;
			}
		
			$msgDetails = $this->chat_model->getRecentlyLikedMsg($myid, $fid);
		
			$json = array('error' => false, 'result'=> $msgDetails);
			echo json_encode($json);
		}
	}