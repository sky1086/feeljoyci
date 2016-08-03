<?php //$this->load->view('admin/header');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Listenerprofile</title>
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

<!--------------------------------------------------------------------------------------------------------->
<section id="banner-bg">
</section>
<!--------------------------------------------------------------------------------------------------------------------------->
<section>
<div class="container-fluid">
 <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
       <div class="row">
      <div class="img-sty">
          <div class="col-md-3 col-lg-3 col-sm-3 col-xs-4">
           <img src="<?php echo base_url();?>pics_listener/<?php echo $listener['profile_img']?>" class="img-responsive propic"/>
		   <p class="userrating">User Rating:</p>
		   
            <div class="pro-star-group">
              <ul class="pro-star">
                <li><img src="<?php echo base_url();?>/images/star1.png" class="img-responsive"/></li>
                <li><img src="<?php echo base_url();?>/images/star1.png" class="img-responsive"/></li>
                <li><img src="<?php echo base_url();?>/images/star1.png" class="img-responsive"/></li>
                <li><img src="<?php echo base_url();?>/images/star2.png" class="img-responsive"/></li>
                <li><img src="<?php echo base_url();?>/images/star2.png" class="img-responsive"/></li>
				
              </ul>
            </div>
          </div>
          </div>
          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-4 ">
              <div class="user-desc">
                <h5><?php echo $listener['name']?></h5>
                <p><?php echo $listener['qualification']?></p>
              </div>
          </div>
          </div>
       </div>
      </div>
	
</div>
</section>


<!------------------------------------------------------------------------------------------------------------------------------------------------------->
<section>
<div class="container-fluid about">
<div class="row">
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 col-md-offset-1">
<div class="heading">
<h5>Practice areas</h5>
<p class="">Family, Marriage</p>
</div>
</div>
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 col-md-offset-1">
<div class="heading">
<h5>About Me</h5>
<p><?php echo $listener['description']?></p>
</div>
</div>

</div>
</section>
</body>
</html>
