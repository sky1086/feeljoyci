<!DOCTYPE html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <title>FeelJoy</title>
    <meta name="description" content="Material Design Mobile Template">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/touch/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/touch/apple-touch-icon-57x57-precomposed.png">
    <link rel="shortcut icon" sizes="196x196" href="img/touch/touch-icon-196x196.png">
    <link rel="shortcut icon" href="img/touch/apple-touch-icon.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="img/touch/apple-touch-icon-144x144-precomposed.png">
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
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" media="all" rel="stylesheet" type="text/css">

    <!-- Stylesheets -->
    <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>css/style1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/materialize.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/swipebox.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css">
    <script src="<?php echo base_url();?>js/vendor/modernizr-2.7.1.min.js"></script>
    <script src="<?php echo base_url();?>js/custom.js"></script>
    <script src="<?php echo base_url();?>js/jquery-1.9.1.js"></script>
    <script type="text/javascript">setCookie('ThemeColor', '', -1);</script>
    <style>
        .primary-color {
            background-color: #7f8c8d !important;
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
    </style>
</head>

<body>
<div id="panel">
    <!-- Main Container -->
     <div id="main" class="main">

<?php 
$datas['heading'] = ucfirst($category[0]->name);
$this->load->view('user/main-nav', $datas);?>

        <!-- Page Contents -->
       <div class="wrapper">
       <div class="container-fluid">
       <div class="row">
       <?php 
       
       $numTopics = count($topics);
       
       $colors = array('25C6DA', '4DB6AC', '81C783', 'AED581', '25C6DA', '4DB6AC', '81C783', 'AED581', '25C6DA', '4DB6AC', '81C783', 'AED581', '25C6DA', '4DB6AC', '81C783', 'AED581', '25C6DA', '4DB6AC', '81C783', 'AED581');
       $theme = 1;
       $color = 0;
       $other = 0;
       foreach ($topics as $topic){
       	if(strtolower($topic->name) == 'other'){
       		$other = 1;
       		$other_data[] = $topic;
       		continue;
       	}
       	$first = reset($topics);
       if($first == $topic){
       	$class = 'eng2sec1';
       }else {
       	$class = 'eng2sec2';
       }
       	?>
       	<div style="clear: both;"></div>
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <a href="javascript:void(0);" onclick="setColorCookie('<?php echo 't'.$theme;?>', '<?php echo base_url();?>user/questions/index/<?php echo $topic->id;?>');">
        <div class="<?php echo $class;?>" style="background-color:#<?php echo $colors[$color];?>;">
        <p style="text-align:center;margin-bottom:0px;"><?php echo strtoupper($topic->name);?></p>
       </div>
       </a>
       </div>
       <?php 
       $color++;
       $theme++;
       }
       if($other){
       	$other_data = $other_data[0];
       	?>
       	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
       	<a href="javascript:void(0);" onclick="setColorCookie('<?php echo 't'.$theme;?>', '<?php echo base_url();?>user/questions/index/<?php echo $other_data->id;?>');">
       	<div class="eng2sec2" style="background-color:#<?php echo $colors[$color];?>;" onclick="setColorCookie('<?php echo 't'.$theme;?>');">
       	<p style="text-align:center;margin-bottom:0px;"><?php echo strtoupper($other_data->name);?></p>
       	       </div>
       	       </a>
       	       </div>
       <?php }
       ?>
       </div>
       </div>
       </div>
        <!-- End of Page Contents -->

    </div>
        <?php $this->load->view('user/button-float_view', array('theme'=>$this->session->userdata('theme')));?>
 
    </div>
    <!-- End of Main Container -->
    
    
    <!-- Scripts -->
    <script src="<?php echo base_url();?>js/vendor/jquery-2.1.0.min.js"></script>
    <script src="<?php echo base_url();?>js/helper.js"></script>
    <script src="<?php echo base_url();?>js/vendor/HeadsUp.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.smoothState.js"></script>
    <script src="<?php echo base_url();?>js/vendor/chart.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.mixitup.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.swipebox.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/swiper.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/materialize.min.js"></script>
    <script src="<?php echo base_url();?>js/main.js"></script>
    <script>
    	$(document).ready(function(){
    	resizeDiv();
    	});

    	window.onresize = function(event) {
    	resizeDiv();
    	}

    	function resizeDiv() {
        	var topic = <?php echo $numTopics;?>;
    	vpw = $(window).width();
    	vph = $(window).height();
    	if(topic && topic <=4){
			vph = Math.ceil(vph/topic);
        }else{
			vph = 150;
        }
    	$('.eng2sec2').css({'height': + vph + 'px'});
    	$('.eng2sec1').css({'height': + vph + 'px'});
    	$('.eng2sec2').css({'line-height': + vph + 'px'});
    	$('.eng2sec1').css({'line-height': + vph + 'px'});
    	}
    </script>
</body>

</html>
