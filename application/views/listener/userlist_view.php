<?php $this->load->view('admin/header');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<style>
.theme {
    background-color: rgba(112, 197, 159, 0.8) !important;
}
</style>
<div class="page animated">
<?php 
if(!empty($contactedUsers)){
foreach ($contactedUsers as $user){
	$user = $user[0];
	$userMsgDetails = $this->chat_model->getLastMsgFromUsr($user['userid'], $this->session->userdata('userid'));
	$userUnreadMsgCount = $this->chat_model->getUnreadMsgFromUsr($user['userid'], $this->session->userdata('userid'));
	$userMsgDetails['msg'] = $this->chat_model->decodeMsg($userMsgDetails['msg'], $userMsgDetails['int_vec']);
	if(empty($user['profile_img']) && ($user['gender'] == 'Male' || empty($user['gender']))){
		$user['profile_img'] = 'man.png';
	}elseif(empty($user['profile_img']) && $user['gender'] == 'Female'){
		$user['profile_img'] = 'woman.png';
	}
	if(strpos($user['profile_img'], 'http') !== false){
		$user['profile_img'] = $user['profile_img'];
	}else {
		$user['profile_img'] = base_url().'img/'.$user['profile_img'];
	}
	
	?>
<div class="userlist">
	<div class="user-left">
		<img src="<?php echo $user['profile_img'];?>" class="img-thumb">
	</div>
	<div class="user-middle"> 
		<b style="font-size: 3.5vw;"><a onclick="window.location = '<?php echo base_url().'listener/chat/index/'.$user['userid'];?>'"><?php echo $user['contact_name'];?></a></b><br />
		<span class="chat-time"><?php echo $userMsgDetails['msg'];?></span>
	</div>
	<div class="user-right" align="center"> 
		<span class="chat-time" title="<?php echo date('Y-m-d H:i A', strtotime($userMsgDetails['time']));?>"><?php echo date('H:i A', strtotime($userMsgDetails['time']));?></span>
		<div class="chat-time" style="background-color: #53C6DA;color:white;width:20px;">
			<?php echo ($userUnreadMsgCount?$userUnreadMsgCount:'');?>
		</div>
	</div>
</div>
<div class="sepa-line"></div>
<?php 
unset($user);
}
}else{
	echo 'No User contacted';
}
?>

</div>
<?php $this->load->view('admin/footer');?>