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
	<title>Password Recovery</title>
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
        	if(document.getElementById('password').value != '')document.getElementById('password').value = hex_md5(document.getElementById('password').value);
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
 .global_msg
{
	margin: 0 auto;min-width: 100px; max-width: 600px;display: inline-block; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; z-index: 9999; text-align: left; background-color: rgb(168, 233, 190); font-size: 14px; padding: 12px 21px;;
}
</style>
	<div class="notice">
    <p style="margin-top:8px;"> <img src="<?php echo base_url();?>images/logo.jpg"> </p>
	
	<?php
$this->load->view('admin/message_view');
?>
</div>
<div class="container">
	<div class="form-bg">
    
<?php echo form_open(base_url().'passwordrecovery/requestform/'.$usertype);?> 
<input type="hidden" name="usertype" value="<?php echo $usertype;?>" />
				
				<h2>Password Recovery</h2>
				<p>
				<div align="center" style="color:red; font:12px arial;" id="errormsg"><?php echo validation_errors(); ?></div>
				</p>
				<p>
				<input  name="UserLoginEmail" type="text" value="<?php echo ($UserLoginEmail!=''?$UserLoginEmail:'');?>" id="UserLoginEmail"  placeholder="Email"/>
				</p>
				<p><input type="text" name="word" id="captcha" placeholder="Captcha Code"/></p>
                <p align="center">
				<div style="clear:both;"></div>
				<div align="center"  style="width:65%; margin:0 auto;">
                <div id="capimg" align="center" style="float:left;"><?php echo $image;?></div>
					<div style="float:left;">
					<a title="reload" class="reload-captcha" href="#" style=" margin:-5px 0 0 10px;""><img src="../../images/refresh_icon.jpg" border="0"></a>
					</div>
					
</div>
<div style="float:left; margin:-9px 0 0 15px;">
<input type="hidden" name="usertype" value="<?php echo $usertype;?>" />
                <p align="center"><input type="submit" name="submit" value="Proceed" onClick="return passwordrecovery()"/>
                </p>
                </div>
				
			<form>
		</div>
		<script src="<?php echo base_url();?>js/jquery.min.js" type="text/javascript"></script>
		<script>
     $(function(){
         var base_url = '<?php echo base_url(); ?>';
         $('.reload-captcha').click(function(event){
             event.preventDefault();
             $.ajax({
                 url:base_url+'passwordrecovery/createcaptcha/1',
                 success:function(data){
                     $('#capimg').html(data);
                 }
             });            
          });
      });
	  
function passwordrecovery()
{
	if(isEmptyField(document.getElementById('UserLoginEmail')))
	{
		showMessage("<?php echo lang('err_fieldisrequired');?>", "<?php echo lang('lbl_email');?>");
		return false;
	}
	else if(!isEmailFormat(document.getElementById('UserLoginEmail')))
	{
		 showMessage("<?php echo lang('err_fieldcontainsinvlaidemail');?>", "<?php echo lang('lbl_email');?>");
		 return false;
	}
	else if(hasIllegalHtmlTags(document.getElementById('UserLoginEmail')))
	{
		showMessage("<?php echo lang('err_fieldcontainsillegalchars');?>", "<?php echo lang('lbl_email');?>");
		return false;
	}
	else if(isEmptyField(document.getElementById('captcha')))
	{
		showMessage("<?php echo lang('err_fieldisrequired');?>", "<?php echo lang('lbl_captcha');?>");
		return false;
	}
	
}	  
</script> 
</div>
<div class="clear">&nbsp;</div>
<?php $this->load->view('admin/footer');?>
