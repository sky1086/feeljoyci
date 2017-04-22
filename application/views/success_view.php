<?php 
$attributes = 'name="login" onsubmit="return processInput();" autocomplete="off"';
?>
<!doctype html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> 	<html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	<!-- Force Latest IE rendering engine -->
	<title>PasswordRecovery</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
	
	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?php echo base_url();?>css/base.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/skeleton.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/layout.css">
	<script type='text/javascript' src='<?php echo base_url();?>js/md5-min.js'> </script>
    <script type='text/javascript' src='<?php echo base_url();?>js/validation_mod.js'> </script>
	<script>
    function processInput(){
        if(isEmptyField(document.getElementById('username'),'username') || isEmptyField(document.getElementById('password'),'password'))
        {
    		return false;
        }
        else
        {
        	if(document.getElementById('password').value != '')document.getElementById('password').value = document.getElementById('password').value;
        	return true;
        }
    }
    </script>

<?php
$cssClass = "class='current'";
?>

<div class="round_wrapper">
<?php	
$error = validation_errors();
	if($error != '')
	{
		$errblock = 'block';
	}
	else
	{
		$errblock = 'none';
	}
?>
<style>
body { 
		background: url(../images/forgot_pwd_bg.jpg) #eaedf3;
		font: 14px/21px "Arial", "sans-serif", Helvetica, Arial, sans-serif;
		color: #444; 
		-webkit-font-smoothing: antialiased; /* Fix for webkit rendering */
		-webkit-text-size-adjust: none;
 }
</style>



<body>

	<div class="notice">
    <p style="margin-top:8px;"> <img src="<?php echo base_url();?>images/ibibo_ads_server.jpg"> </p>
	</div>

<div class="container">
	<div class="success-bg">
    An e-mail has been sent to you, which includes a link that will allow you to re-set your password and log in.
Please allow a few minutes for the e-mail to arrive.
If you do not receive the e-mail, please check your spam folder.
    <div class="warning2"></div>
</div>
</div>

<?php $this->load->view('admin/footer');?>
