<?php $this->load->view('admin/header');?>
<div class="container">
<div class="mws-panel grid_8" id="changpwddiv">
                	<div class="mws-panel-header">
                    	<span>Change Password</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    <?php 
					$error = validation_errors();
					?>
					<?php if($successmsg){?>
					<div class="mws-form-message success" ><?php echo $successmsg; ?></div>
					<?php }elseif($error != '' || $errmsg != ''){?>
					<div class="mws-form-message error"><?php echo $error, $errmsg; ?></div>
					<?php }?>
                    	<?php echo form_open(base_url().'myaccount/userpassword', 'class="mws-form" id="changepassword"');?> 
                        	<div class="mws-form-inline">
                            	<div class="mws-form-row">
                                	<label class="mws-form-label">Current Password</label>
                                	<div class="mws-form-item">
                                    	<input type="password" class="small" minlength="6" name="password" id="password">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                	<label class="mws-form-label">New Password</label>
                                	<div class="mws-form-item">
                                    	<input type="password" class="small" minlength="6" name="npassword" id="npassword">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                	<label class="mws-form-label">Confirm Password</label>
                                	<div class="mws-form-item">
                                    	<input type="password" class="small" minlength="6" name="cpassword" id="cpassword">
                                    </div>
                                </div>
                                <div class="mws-form-row">
                                	<div class="mws-form-item">
                                		<input type="submit" value="Change" name="changepass" class="btn btn-primary btn-small">
                                	</div>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>    	
                </div>
                <script>
                (function($) {
                	$(document).ready(function() {	
                		$("#changepassword").validate({
                			rules: {
                				password: {required: true}, 
                				npassword: {required: true},
                				cpassword: {required: true, equalTo: "#npassword"}
                			},
                			errorPlacement: function(error, element) {  
                			}, 
                			invalidHandler: function(form, validator) {
                				if($.fn.effect) {
                					$("#changpwddiv").effect("shake", {distance: 6, times: 2}, 35);
                				}
                			}
                		});
                		
                		$.fn.placeholder && $('[placeholder]').placeholder();
                	});
                }) (jQuery);
                </script>
</div>
<?php $this->load->view('admin/footer');?>
