<?php $this->load->view('admin/header1');?>

<section class="main-sec">
        <div class="left">
        </div>
        <div class="mid">
            <div class="mid-sec">
                <div class="main">
                  <div class="signup-sec" style="text-align:center;">
                    <div class="main-head"><h5>Sign up to FeelJoy</h5></div>
                      <a class="btn ggl-su"><i class="fa fa-google-plus" aria-hidden="true"></i>
  Sign up via Google</a>
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
                        
                        <div class="extras">
                            <ul>
                                <li><a href="/">Login</a></li>
                            </ul>
                        </div>
                        <a class="waves-effect waves-light btn login-btn" onclick="return document.forms.addform.submit();">Sign up</a>
                        </form>
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
                        <a class="waves-effect waves-light btn login-btn" onclick="return document.forms.dataform.submit();">Continue</a>
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