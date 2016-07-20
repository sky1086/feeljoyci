<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(0);
class ChatM extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('authentication');
        $this->authentication->isLoggedIn();
        $this->permission->enforceAccount(ACCOUNT_USER, ACCOUNT_LISTENER);
        $this->load->model(array(
            'chat/chat_model'
        ));
        $this->load->library(array(
            'form_validation'
        ));
    }
    
    public function index()
    {
		$json = '';
		if(isset($_GET['rq'])):
		$myid = $this->session->userdata('userid');
		if (!isset($_POST['fid'])) {
			$fid = 0;
		}else{
			$fid = $_POST['fid'];
		}
		
		include_once BASEPATH.'../lib-emoji/Emoji.class.php';
			switch($_GET['rq']):
				case 'new':
					$msg = Emoji::emoji_to_html($_POST['msg']);
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
							$json = array('status' => 1, 'msg' => $this->chat_model->decodeMsg($qurGet['msg'], $qurGet['int_vec']), 'lid' => $qur, 'time' => $qurGet['time']);
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
						
						$qurGet = $this->chat_model->getMsgsWhere($msgArr);
						//$qur = mysql_query("select * from msg where `to`='$myid' && `from`='$fid' && `status`=1");
						if(count($qurGet) > 0){
							$json = array('status' => 1);
						}else{
							$json = array('status' => 0);
						}
					}
				break;
				case 'NewMsg':
					$msgArr = array('to' => $myid, 'status' => 1);
					if($fid)
						$msgArr['from'] = $fid;
					
					$qurGet = $this->chat_model->getUsrLastMsgWhere($msgArr);
					//$qur = mysql_query("select * from msg where `to`='$myid' && `from`='$fid' && `status`=1 order by id desc limit 1");
					//while($rw = mysql_fetch_array($qur)){
					$ids = array();
					if(!empty($qurGet)){
						$msg = '';
						foreach ($qurGet as $msr=>$msv){
							$decoded_msg = $this->chat_model->decodeMsg($msv['msg'], $msv['int_vec']);
							$msg .= Emoji::html_to_emoji($decoded_msg)."<br>";
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
					$msgArr = array('from' => $myid, 'status' => 0);
					if($fid)
						$msgArr['to'] = $fid;
						
					$qurGet = $this->chat_model->getUsrOldMsgWhere($myid, $msgArr, 100);
					//$qur = mysql_query("select * from msg where `to`='$myid' && `from`='$fid' && `status`=1 order by id desc limit 1");
					//while($rw = mysql_fetch_array($qur)){
					
					if(!empty($qurGet)){
						$msg = '';
						foreach ($qurGet as $msr=>$msv){
							$decoded_msg = $this->chat_model->decodeMsg($msv['msg'], $msv['int_vec']);
							$msg = Emoji::html_to_emoji($decoded_msg)."<br>";
							$qurGet[$msr]['msg'] = $msg;
							unset($qurGet[$msr]['int_vec']);
						}
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
}




?>