<?php //$this->load->view('admin/header');?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FeelJoy</title>
<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto|Titillium+Web' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="wrapper">
<header>
	<div class="header-in">
    	<h2 class="text-center">FeelJoy</h2>
    
    </div>

</header>
  <div class="head-top"> </div>
  <div class="container">
  
  <!--------------------------------------- 1st row-------------------------------------->
  <?php if(!empty($listeners) && count($listeners) > 0){
  foreach ($listeners as $listener){
  	?>
   <div class="box-style">
    <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
       <div class="row">
      <div class="img-sty">
          <div class="col-md-2 col-lg-2 col-sm-2 col-xs-4" style="width:25%;padding-right: 0px;">
          	
           <img src="<?php echo base_url();?>pics_listener/<?php echo $listener['profile_img']?>" class="img-responsive pic"/>
            <div class="star-group">
              <!--  ul class="star">
                <li><img src="<?php echo base_url();?>images/star1.png" class="img-responsive"/></li>
                <li><img src="<?php echo base_url();?>images/star1.png" class="img-responsive"/></li>
                <li><img src="<?php echo base_url();?>images/star1.png" class="img-responsive"/></li>
                <li><img src="<?php echo base_url();?>images/star2.png" class="img-responsive"/></li>
                <li><img src="<?php echo base_url();?>images/star2.png" class="img-responsive"/></li>
              </ul-->
            </div>
          </div>
          </div>
          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-4" style="width:45%;">
            <div class="border-right">
              <div class="short-desc">
                <h5><a href="<?php echo base_url();?>listener/details/index/<?php echo $listener['id'];?>"><?php echo $listener['name'];?></a></h5>
                <p><?php echo $listener['qualification'];?></p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-lg-3 col-sm-3 col-xs-4" style="width:25%;">
            <div class="line">
              <div class="mesg"> <a href="<?php echo base_url();?>user/chat/index/<?php echo $listener['id'];?>"><img src="<?php echo base_url();?>images/mesg.png" class="img-responsive "/> </a></div>
            </div>
          </div>
       </div>
       </div>
      </div>
      
      </div>
	
	<!--------------------------------------- 1st row-------------------------------------->
	
    <div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        	<div class="mid-img">
        		<img src="<?php echo base_url();?>images/line.png" class="img-responsive" style="width: 40%;">
    		</div>
    	</div>
    </div>
    <?php }}else{?>
    <div class="box-style">
    <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
       <div class="row">
              <div class="short-desc">
                <h5 style="font-size: 25px;font-weight: 600;padding: 20px 0 30px 40px; text-align: left;">No records found</h5>
              </div>
       </div>
       </div>
      </div>
      
      </div>	
    <?php }?>  
  
  </div>
</div>
</body>
</html>


<?php //$this->load->view('admin/footer');?>