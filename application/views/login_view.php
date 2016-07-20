<?php 
$attributes = 'name="login" class="col s12" onsubmit="return processInput();" autocomplete="off"';
?>
<?php $this->load->view('admin/header1');?>
    <section class="main-sec">
        <div class="left">
        </div>
        <div class="mid">
            <div class="mid-sec">
                <div class="main">
                  <div class="signup-sec" style="text-align:center;">
                    <div class="main-head"><h5>Log in to FeelJoy</h5></div>
                      <a class="btn ggl-su"><i class="fa fa-google-plus" aria-hidden="true"></i>
  Sign up via Google</a>
                  </div>
                    <div class="details row" style="margin-bottom:0">
                        <?php echo validation_errors(); ?>
                        <?php echo form_open('login/process',$attributes); ?>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="email" name="username" type="email" class="validate">
                                    <label class="active" for="email">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="password" name="password" type="password" class="validate">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                        
                        <div class="extras">
                            <ul>
                                <!-- li><a>Forgot Password?</a></li-->
                                <li><a href="signup/user">Sign Up</a></li>
                            </ul>
                        </div>
                        <a class="waves-effect waves-light btn login-btn" onclick="processInput();">Login</a>
                        </form>
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
        <script type='text/javascript' src='<?php echo base_url();?>js/md5-min.js'> </script>
<script>
    function processInput(){
    	document.getElementById('email').style.border = '';
    	document.getElementById('password').style.border = '';
        if(document.getElementById('email').value == ''){
            document.getElementById('email').style.border = '1px solid red'; 
    		return false;
        }else if(document.getElementById('password').value == ''){
        	document.getElementById('password').style.border = '1px solid red'; 
        	return false;
        }else{
        	if(document.getElementById('password').value != '')document.getElementById('password').value = hex_md5(document.getElementById('password').value);
        	document.forms.login.submit();
        }
    }
    </script>
</body>

</html>
