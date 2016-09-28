<?php $this->load->view('admin/backend-header');?>
        
 <!-------------------------------------------------------------------------->
        
        <section>
<div class="container-fluid">
 <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
       <div class="row">
          <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10 ">
              <div class="user-desc">
                <h5>Edit Question</h5>
              </div>
              		<?php 
					$error = validation_errors();
					?>
					<?php if($successmsg){?>
					<div style="color:green;padding-left:22px;" ><?php echo $successmsg; ?></div>
					<?php }elseif($error != '' || $errmsg != ''){?>
					<div style="color:red;padding-left:22px;"><?php echo $error, $errmsg; ?></div>
					<?php }?>
					<?php echo form_open('admin/question/edit/'.$question->id, 'method="post"')?>
              <table>
              <tr>
              	<td></td>
              	<td>Question</td>
              	<td>
              	<input type="text" name="question" value="<?php echo set_value('question', $question->question); ?>" required />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Answer</td>
              	<td>
              		<textarea name="answer" required rows="50" cols="20"><?php echo set_value('answer', $question->answer); ?></textarea>
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Priority</td>
              	<td>
              	<input type="text" name="priority" value="<?php echo set_value('priority', $question->priority); ?>" required />
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td>Status</td>
              	<td>
              	<input type="radio" name="status" value='1' <?php echo  set_radio('status', '1', ($question->status == 1)); ?> id="active"/> <label for="active">Active</label> &nbsp;&nbsp;&nbsp;&nbsp;
              	<input type="radio" name="status" value='0' <?php echo  set_radio('status', '0', ($question->status == 0)); ?> id="inactive"/> <label for="inactive">Inactive</label>
              	</td>
              </tr>
              <tr>
              	<td></td>
              	<td></td>
              	<td>
              	<input class="waves-effect waves-light btn" type="Submit" name="Add" value="Save" />
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