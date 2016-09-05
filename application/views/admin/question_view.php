<?php $this->load->view('admin/backend-header');?>
        
 <!-------------------------------------------------------------------------->
        
        <section>
<div class="container-fluid">
 <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
       <div class="row">
          <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10" style="background-color: white; color:#000;">
              <div class="user-desc">
                <h5>Questions/Answers</h5>
              </div>
              <table>
              	<?php if(!empty($quiz_data)){
              	foreach ($quiz_data as $quiz){
              		$theme_status = ($quiz->status == 1?'<font color="green">Active</font>':'<font color="red">Inactive</font>');
              		echo '<tr>
 							<td style="padding-top:20px;color:blue;">'.ucfirst($quiz->question).' &nbsp;&nbsp;&nbsp;&nbsp;(<a href="'.base_url().'admin/question/edit/'.$quiz->id.'">Edit</a>)<hr style="margin:0 0 5px 0;"></td>
     					  </tr>
     					  <tr>
 							<td>'.ucfirst($quiz->answer).'</td>
     					  </tr>
              			  <tr>
 							<td><b>Status: </b>'.$theme_status.'</td>
     					  </tr>
              		      <tr>
 							<td> <b>Linked Categories: </b></td>
     					  </tr>';
              	}
              	}else{
              		Echo '<tr><td colspan="4">No Record Found</td></tr>';
              	}?>
              </table>
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