<?php $this->load->view('admin/backend-header');?>
        
 <!-------------------------------------------------------------------------->
        
        <section>
<div class="container-fluid">
 <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
       <div class="row">
          <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 ">
              <div class="user-desc">
                <h5>Add Listener</h5>
              </div>
              		<?php 
					$error = validation_errors();
					?>
					<?php if($successmsg){?>
					<div style="color:green;padding-left:22px;" ><?php echo $successmsg; ?></div>
					<?php }elseif($error != '' || $errmsg != ''){?>
					<div style="color:red;padding-left:22px;"><?php echo $error, $errmsg; ?></div>
					<?php }?>
					<?php echo form_open('admin/listeners/add', 'method="post"')?>
              <table>
              <tr>
              	<td></td>
              	<td>Name</td>
              	<td>
              	<input type="text" name="name" value="<?php echo set_value('name'); ?>" required />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Interests</td>
              	<td>
              	<input type="text" name="interests" value="<?php echo set_value('interests'); ?>" />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Tagline</td>
              	<td>
              	<input type="text" name="tagline" value="<?php echo set_value('tagline'); ?>" />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Qualification</td>
              	<td>
              	<input type="text" name="qualification" value="<?php echo set_value('qualification'); ?>" required />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Priority</td>
              	<td>
              	<input type="text" name="priority" value="<?php echo set_value('priority'); ?>" required />
              	</td>
              </tr>	
              <tr>
              	<td></td>
              	<td>Mobile</td>
              	<td>
              	<input type="text" name="mobile" value="<?php echo set_value('mobile'); ?>" />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Username/Email</td>
              	<td>
              	<input type="email" name="email" value="<?php echo set_value('email'); ?>" required />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Password</td>
              	<td>
              	<input type="password" name="password" value="" required />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Age</td>
              	<td>
              	<input type="text" name="age" value="<?php echo set_value('age'); ?>" required />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Gender</td>
              	<td>
              	<input type="radio" name="gender" value='Male' <?php echo  set_radio('gender', 'Male', 1); ?> id="male"/> <label for="male">Male</label> &nbsp;&nbsp;&nbsp;&nbsp;
              	<input type="radio" name="gender" value='Female' <?php echo  set_radio('gender', 'Female', 0); ?> id="female"/> <label for="female">Female</label>
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Status</td>
              	<td>
              	<input type="radio" name="status" value='1' <?php echo  set_radio('status', '1', 1); ?> id="active"/> <label for="active">Active</label> &nbsp;&nbsp;&nbsp;&nbsp;
              	<input type="radio" name="status" value='0' <?php echo  set_radio('status', '0', 0); ?> id="inactive"/> <label for="inactive">Inactive</label>
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Description</td>
              	<td>
              		<textarea name="description" required cols="20" style="height: 100px;"><?php echo set_value('description'); ?></textarea>
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td></td>
              	<td>
              	<input type="submit" class="waves-button-input" name="Add" value="Save" onclick="this.form.submit();"/>
              	</td>
              </tr>
              </table>
              </form>
          </div>
          </div>
       </div>
      </div>
	
</div>
</section>

<!------------------------------------------------------------------------------------------>

<section>
<div class="container-fluid about">

</div>
</section>
        <!-- End of Page Contents -->

       <?php $this->load->view('admin/menu');?> 

    </div>
    
    <!-- End of Main Container -->
  
<?php $this->load->view('admin/backend-footer');?>