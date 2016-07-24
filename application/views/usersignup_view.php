<!doctype html>

<head>
    <title>FeelJoy - Signup</title>
    <link rel="stylesheet" href="<?php echo base_url();?>css/materialize.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/font-awesome.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .nav-wrapper {
            background-color: #56B68B;
        }

        .main-sec {
            display: flex;
        }

        .left {
            flex: 0 1 10%;
        }

        .mid {
            flex: 0 1 80%;
        }

        .mid-sec {
            margin-top: 70px;
        }

        .signup-sec {}

        .main {
            margin-top: 10px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.19), 0 2px 3px rgba(0, 0, 0, 0.23);
            padding: 10px;
        }
        p{
            text-align: center;
        }

        /*.login-btn {
            float: right;
            margin-right: 10%;
            margin-top: 5%;
            background-color: #f0f0f0;

            align-self: center;
        }
        .login-btn:hover{
            background-color: #f0f0f0;
        }*/
        .signup-btn{
            width:100%;

        }

        .details{
          margin-top: 10px;
        }


        .ggl-su {
          background-color: #dd4b39;
          letter-spacing: 0.08em;
          width: 100%;
          height: 40px;
          margin-top: 10px;
        }

        .ggl-su:hover{
            background-color: #ee5c4a;
        }

        .main-head{
          margin-top: -10px;
        }

        .main-head h4{
          font-size: 20px;
          font-weight: bold;
        }

        .right {
            flex: 0 1 10%;
        }

        .main-head h5{
          font-size: 18px;
          font-weight: bold;
        }
        .user-age {
            width: 28% !important;
        }
    </style>
</head>

<body>

    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo center">FeelJoy</a>
        </div>
    </nav>
<section class="main-sec">
        <div class="left">
        </div>
        <div class="mid">
            <div class="mid-sec">
                <div class="main">
                  <div class="signup-sec" style="text-align:center;">
                  <?php 
                  if($step == 1){?>
                    <div class="main-head"><h4>Sign up for FeelJoy</h4></div>
                      <a class="btn ggl-su"><i class="fa fa-google-plus" aria-hidden="true"></i>
  Sign up via Google</a>
                  <?php 
                  }elseif($step == 2){?>
                  <div class="main-head"><h5>Just a few more details...</h5></div>
                  <?php }?>
                  </div>
                    <div class="details row" style="margin-bottom:0">
                    <?php 
					$error = validation_errors();
					?>
					<?php if($successmsg){?>
					<div style="color:green;padding-left:22px;" ><?php echo $successmsg; ?></div>
					<?php }elseif($error != '' || $errmsg != ''){?>
					<div style="color:red;padding-left:22px;"><?php echo $error, $errmsg; ?></div>
					<?php }
					if($step == 1){
					?>
                    	<?php echo form_open(base_url().'signup/adduser', 'class="col s12" id="addform" name="addform"');?>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="email" name="email" type="email" required class="validate" value="<?php echo set_value('email'); ?>">
                                    <label class="active" for="email">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="password" name="password" type="password" class="validate" required>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <input name="step" type="hidden" value="1">
                        </form>
                        <a class="waves-effect waves-light btn signup-btn" onclick="return document.forms.addform.submit();">Sign up</a>
                        <p>Already have an account? <a href="login.html"><span style="color:blue;">Login</span></a></p>
                        <?php }elseif ($step ==2){?>
                        <?php echo form_open(base_url().'signup/adduser', 'class="col s12" id="dataform" name="dataform"');?>
                            <div class="row">
                                <div class="input-field col s12">
                                	<input name="step" type="hidden" value="2">
                                	<input name="email" type="hidden" value="<?php echo $n_email;?>">
                                    <input id="screenname" name="contact_name" type="text" class="validate">
                                    <label class="active" for="email">Screename</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 input-user_details">
                                    <input id="age" name="age" type="number" class="validate  user-age">
                                    <label class="active" for="email">Age</label>
                                    <input class="with-gap" type="radio" id="male" name="gender" value="Male" />
                                    <label for="male">Male</label>&nbsp;
                                    <input class="with-gap" type="radio" id="female" name="gender" value="Female" />
                                    <label for="female">Female</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">

                                </div>
                            </div>
                        <a class="waves-effect waves-light btn signup-btn" onclick="return document.forms.dataform.submit();">Continue</a>
                        </form>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="<?php echo base_url();?>js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            Materialize.updateTextFields();
        });
    </script>
</body>

</html>