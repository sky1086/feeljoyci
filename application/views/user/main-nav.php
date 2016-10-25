<?php
if(isset($heading) && $heading != ''){
  $heading = $heading;
}else{
  $heading = 'FeelJoy';
}
$align = "center";
if(strlen($heading) > 15){
	$align = 'left;padding-left:10px;font-size:1em;overflow:hidden;';
}

?>
<script>
    var colorTh = getColorTheme();
    var themeLink = document.createElement('link');
    themeLink.rel = "stylesheet";
	if(colorTh != ''){
		themeLink.href = "<?php echo base_url();?>css/themes/" + colorTh + ".css";
	}else{
		themeLink.href = "<?php echo base_url();?>css/themes/t0.css";
		}
	document.getElementById('main').appendChild(themeLink);
    </script>
    <script type="text/javascript">
    (function(p,u,s,h){
        p._pcq=p._pcq||[];
        p._pcq.push(['noTrigger',true]);
        p._pcq.push(['_currentTime',Date.now()]);
        s=u.createElement('script');
        s.type='text/javascript';
        s.async=true;
        s.src='https://cdn.pushcrew.com/js/2af3528e08af3f47d8eedf0b5be2ac28.js';
        h=u.getElementsByTagName('script')[0];
        h.parentNode.insertBefore(s,h);
    })(window,document);
</script>
        <!-- Toolbar -->
        <!-- div id="toolbar" class="theme z-depth-1"-->
        <div id="toolbar" class="theme">
            <h1 class="title" style="text-align:<?php echo $align;?>"><?php echo $heading;?></h1>
            
            <div class="open-right" id="open-right" data-activates="slide-out">
                <i class="ion-android-menu"></i>
            </div>
        </div>
        
        <ul id="slide-out" class="side-nav" style="box-shadow:none;">
            <!-- Tabs -->
            <li>
                <ul class="tabs">
                    <li class="tab col s3"><a href="#sidebar1">Menu</a></li>
                    <li class="tab col s3"><a href="#sidebar2" class="active">Chat</a></li>
                </ul>
            </li>
            <li id="sidebar1" class="p-20">
                <!-- Twitter -->
                <div class="twitter">
                    <h6 class="follow-us"><a href="javascript:void(0);" onclick="window.location='<?php echo base_url()?>user/topics';">Quality-space</a></h6>
                    <h6 class="follow-us"><a href="javascript:void(0);" onclick="window.location='<?php echo base_url()?>user/listeners';">Talk to a buddy</a></h6>
                    <h6 class="follow-us"><a onclick="_pcq.push(['triggerOptIn',{httpWindowOnly: true}]);">
GET NOTIFICATIONS
</a></h6>
                </div>

            </li>
            <li id="sidebar2" class="p-20">
            <?php 
            if(!empty($this->session->userdata('userid'))){
            	//list of contacted listener
            	$contactedListeners = $this->chat_model->getContactedListeners($this->session->userdata('userid'));
            	if(!empty($contactedListeners)){
            	foreach ($contactedListeners as $listener){
            ?>
                <!-- Chat -->
                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p><?php echo $listener['contact_name'];?></p>
                        <span>Sent you a message</span>
                        <span class="small">online</span>
                    </div>
                </div>
				<?php }}?>

                <a href="/logout" class="btn login-btn theme" style="color:#fff !important;"> <i class="large input"></i> Logout</a>
            
            <?php }else{?>
            	<img src="<?php echo base_url();?>img/ryt.png">
                <p style="padding-left:20px;"> Login to Talk to your Buddy</p>

				<a href="/login" class="btn login-btn theme" style="color:#fff;"> <i class="large input"></i> Login</a>
            <?php }?>
            </li>
        </ul>
