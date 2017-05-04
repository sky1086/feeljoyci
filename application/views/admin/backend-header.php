<!DOCTYPE html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <title>FeelJoy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
<link href="<?php echo base_url();?>css/jqueryeditable/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css">
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
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" media="all" rel="stylesheet" type="text/css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url();?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/admin/materialize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css">
    <link rel="stylesheet" href="<?php echo base_url();?>jQuery-edit/jquery-te-1.4.0.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/jquery.dataTables.min.css">    
    
    <!-- script src="<?php echo base_url();?>js/vendor/modernizr-2.7.1.min.js"></script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <!-- script src="https://code.jquery.com/jquery.min.js"></script-->    
    <script src="<?php echo base_url();?>js/jquery.tabledit.js"></script>
    <script src="<?php echo base_url();?>jQuery-edit/uncompressed/jquery-te-1.4.0.js"></script>
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
            background-image: url('icons/send-1x.png');
            background-repeat: no-repeat;
            height: 100%;
            width: 100%;
            border: medium none;
            background-color:rgb(119, 197, 162);
            border-radius: 3px;
            background-position: center;
            background-size: 60%,60%;
        }
        a{
        text-decoration:none; 
        color:blue;
        }
        .tabledit-input{
			width:200px;
		}
    </style>
</head>

<body style="height: 100%;">

    <!-- Main Container -->
    <div id="main" class="main">

        <!-- Toolbar -->
        <div id="toolbar" class="primary-color z-depth-1">
            <div class="open-left" id="open-left" data-activates="slide-out-left">
                <i class="ion-android-menu"></i>
            </div>
            <h1 class="title">FeelJoy</h1>
            <div class="open-right">
            </div>
            <!-- div class="open-right" id="open-right" data-activates="slide-out">
                <i class="ion-android-person"></i>
            </div-->
        </div>
        <!-- End of Toolbar -->

        <!-- Page Contents -->
        <div class="page animated fadeinup">

        </div>