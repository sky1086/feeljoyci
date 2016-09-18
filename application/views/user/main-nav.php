<?php
if(isset($heading) && $heading != ''){
  $heading = $heading;
}else{
  $heading = 'FeelJoy';
}

if(isset($Theme) && $Theme != ''){
  $Theme = $Theme;
}else{
  $Theme = 'primary-color';
}
?>

        <!-- Toolbar -->
        <div id="toolbar" class="<?php echo $Theme; ?> z-depth-1">
            <h1 class="title"><?php echo $heading;?></h1>
            
            <div class="open-right" id="open-right" data-activates="slide-out">
                <i class="ion-android-menu"></i>
            </div>
        </div>
        
        <ul id="slide-out" class="side-nav">
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
                    <h6 class="follow-us"><i class="ion-social-twitter"></i> Follow us on Twitter</h6>
                    <div class="tweet">
                        <h3>@Codnauts</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <a href="#">#tempor</a>.</p>
                    </div>
                    <div class="tweet">
                        <h3>@Codnauts</h3>
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in <a href="#">#voluptate</a> culpa qui officia deserunt mollit anim.</p>
                    </div>
                    <div class="tweet">
                        <h3>@Codnauts</h3>
                        <p>At vero eos et accusamus et iusto odio <a href="#">#dignissimos</a> <a href="#">#ducimus</a> qui blanditiis praesentium.</p>
                    </div>
                </div>
                <!-- Facebook -->
                <div class="facebook">
                    <h6 class="follow-us">Notifications</h6>
                    <div class="face-notification">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <div>
                            <p>Mike Green</p>
                            <span>Sent you a message</span>
                            <span class="small">Today at 16:48</span>
                        </div>
                    </div>
                    <div class="face-notification">
                        <img src="img/user.jpg" alt="" class="cricle">
                        <div>
                            <p>Lara Connors</p>
                            <span>Post a photo with you</span>
                            <span class="small">Today at 14:26</span>
                        </div>
                    </div>
                    <div class="face-notification">
                        <img src="img/woman-avatar.png" alt="" class="cricle">
                        <div>
                            <p>Mike Green</p>
                            <span>Post something...</span>
                            <span class="small">Yesterday at 03:19</span>
                        </div>
                    </div>
                </div>

            </li>
            <li id="sidebar2" class="p-20">
                <!-- Chat -->
                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p>Mike Green</p>
                        <span>Sent you a message</span>
                        <span class="small">online</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p>Lora Bell</p>
                        <span>6 New messages</span>
                        <span class="small">online</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot orange"></span>
                    </div>
                    <div class="chat-message">
                        <p>Tony Lee</p>
                        <span>Away from keyboard.</span>
                        <span class="small">Away</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                         <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot grey"></span>
                    </div>
                    <div class="chat-message">
                        <p>Jim Connor</p>
                        <span>Is offline.</span>
                        <span class="small">offline</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p>Sara Lower</p>
                        <span>Sent you a message</span>
                        <span class="small">online</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot grey"></span>
                    </div>
                    <div class="chat-message">
                        <p>Mick Pole</p>
                        <span>Is offline.</span>
                        <span class="small">offline</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                       <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p>James Tree</p>
                        <span>Awaiting your reply.</span>
                        <span class="small">online</span>
                    </div>
                </div>
            </li>
        </ul>