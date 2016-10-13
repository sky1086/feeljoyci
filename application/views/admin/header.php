<!DOCTYPE html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FeelJoy</title>
    <meta name="description" content="Material Design Mobile Template">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>img/touch/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>img/touch/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>img/touch/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>img/touch/apple-touch-icon-57x57-precomposed.png">
    <link rel="shortcut icon" sizes="196x196" href="<?php echo base_url();?>img/touch/touch-icon-196x196.png">
    <link rel="shortcut icon" href="<?php echo base_url();?>img/touch/apple-touch-icon.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="<?php echo base_url();?>img/touch/apple-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#222222">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- SEO: If mobile URL is different from desktop URL, add a canonical link to the desktop page -->
    <!--
    <link rel="canonical" href="http://www.example.com/" >
    -->

    <!-- For iOS web apps. Delete if not needed. https://github.com/h5bp/mobile-boilerplate/issues/94 -->
    <!--
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="">
    -->

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,100' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <!-- Icons -->
    <link href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" media="all" rel="stylesheet" type="text/css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url();?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/materialize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/swipebox.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css">
    <script src="<?php echo base_url();?>js/vendor/modernizr-2.7.1.min.js"></script>
    <style>
        .primary-color {
            background-color: #56B68B !important;
        }

        .meta_holder {
            width: 100%;
            height: 75px;
            position: fixed;
            ;
            bottom: 0;
            padding: 10px;
            margin-bottom: -9px;
        }

        .chat-text-holder {
            border-radius: 6px;
            height: 50px;
            background-color: rgba(86, 182, 139, 0.80);
            display: flex;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15), 0  1px 4px rgba(0,0,0,0.20);
        }

        .left {
            flex: 0 1 85%;
            height: 100%;
            padding: 5px;
            box-sizing: border-box;
        }

        .chat-text-box {
            opacity: 1 !important;
            width: 100%;
            height: 100%;
            resize: none;
            padding: 5px 5px 5px 12px;
            border: none;
            /*box-shadow: 0px 1px 3px #fff;*/
            border-radius: 3px;
            background-color: #fff;
            border-color: #fff;
            border-width: 1px;
            overflow: hidden;
        }

        .right {
            flex: 0 1 15%;
            width: 100%;
            height: 100%;
        }

        .send-button {
            background-image: url('<?php echo base_url();?>icon/send-1x.png');
            background-repeat: no-repeat;
            height: 100%;
            width: 100%;
            border: medium none;
            background-color:rgb(119, 197, 162);
            border-radius: 3px;
            background-position: center;
            background-size: 60%,60%;
        }
    </style>
    <?php $this->load->view('user/theme-common');?>
</head>

<body>

    <!-- Main Container -->
    <div id="main" class="main">
<div id="spam-overlay" onclick="toggleSpam();"></div>
        <!-- Toolbar -->
        <div id="toolbar" class="primary-color z-depth-1 theme">
            <h1 class="title">FeelJoy</h1>
            <div class="open-right" onclick="toggleSpam();">
                <i class="ion-android-alert"></i>
            </div>
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
                    <h6 class="follow-us"><a href="javascript:void(0);" >Menu-space</a></h6>
                    
                </div>

            </li>
            <li id="sidebar2" class="p-20">
            <?php 
            if(!empty($this->session->userdata('userid'))){
            	//list of contacted listener
            	$contactedListeners = $this->chat_model->getContactedListeners($this->session->userdata('userid'));
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
				<?php }?>
                <!--  div class="chat-sidebar">
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
                </div-->

                <a href="/logout" class="btn login-btn theme" style="color:#fff !important;"> <i class="large input"></i> Logout</a>
            
            <?php }else{?>
            	<img src="<?php echo base_url();?>img/ryt.png">
                <p style="padding-left:20px;"> Login to Talk to your Patient</p>

				<a href="/login" class="btn login-btn theme" style="color:#fff;"> <i class="large input"></i> Login</a>
            <?php }?>
            </li>
        </ul>
        <div id="spam-div">
        <h2>Are you sure?</h2>
        <div class="tellus">Tell us why...</div>
        <div class="spam-reason"> <i class="ion-android-mail" style="font-size:1.6rem"></i> Inappropriate Messages</div>
        <div class="spam-reason"><i class="ion-social-snapchat-outline" style="font-size:1.6rem"></i> Feels like Spam</div>
        <div class="spam-reason"><i class="ion-android-sad" style="font-size:1.6rem"></i> Bad behaviour</div>
        <div style="line-height:3em;padding-top:10px;">
        <a href="#" class="btn login-btn theme" style="color:#fff !important;border-radius:6px;width:80%;">Report User</a>
        </div>
        </div>
        