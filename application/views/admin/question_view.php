<?php $this->load->view('admin/backend-header');?>
        
 <!-------------------------------------------------------------------------->
 <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
 <style>
 .select2-container .select2-selection--multiple {
  max-height:40%;
  max-width:100%;
}
 </style>
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
              		//get associated categories
              		$cat_assoc = $this->category_model->getAssocCategoryDetails($quiz->id);
              		$theme_status = ($quiz->status == 1?'<font color="green">Active</font>':'<font color="red">Inactive</font>');
              		echo '<tr>
 							<td style="padding-top:20px;color:blue;" colspan="2">'.ucfirst($quiz->question).' &nbsp;&nbsp;&nbsp;&nbsp;(<a href="'.base_url().'admin/question/edit/'.$quiz->id.'">Edit</a>)<hr style="margin:0 0 5px 0;"></td>
     					  </tr>
     					  <tr>
 							<td colspan="2">'.ucfirst($quiz->answer).'</td>
     					  </tr>
              			  <tr>
 							<td colspan="2"><b>Status: </b>'.$theme_status.'</td>
     					  </tr>
              		      <tr>
 							<td> <b>Linked Categories: </b></td>
              					<td><select name="categories" class="linkCat" id="linkCat'.$quiz->id.'" multiple="multiple" style="height:40px;">';
              				foreach ($cat_data as $category){
              						echo '<option value="'.$category->id.'" '.(in_array($category->id, $cat_assoc)?'selected':'').'>'.$category->name.'</option>';
              				}
              			echo	'</select>
              				</td>
     					  </tr>
 									<tr>
 									<td></td>
 									<td>
										<input class="waves-light btn" type="button" onclick="saveCatLink(\''. $quiz->id .'\');" name="Add" value="Save" /> <span id="saveMsg'.$quiz->id.'"></span>
 									</td></tr>';
              	}
              	}else{
              		Echo '<tr><td colspan="4">No Record Found</td></tr>';
              	}?>
              </table>
          </div>
          </div>
       </div>
      </div>
      <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<script type="text/javascript">
		$(".linkCat").select2();
		var BASE_URL = '<?php echo base_url();?>';
		function saveCatLink(qid){
			var str = $('#linkCat'+qid).val();
	        $.ajax({
	            type: "POST",
	            cache: false,
	            data: {categories: str, qid: qid}, //csrf_token_name: getCookie("csrf_cookie_name")
	            url: BASE_URL + "admin/question/catassoc",
	            beforeSend: function(){
	            	$("#saveMsg"+qid).text("Saving...");
	            },     
	            success: function(res){
	                try{	
	                        if(res == 1)
	                        {
	                            $("#saveMsg"+qid).html("<b style=\"color:green;\">Saved successfully.</b>");
	                            return false
	                        }
	                        else
	                        {
	                        	$("#saveMsg"+qid).html("<b style=\"color:red;\">Something went wrong.</b>");                           
	                        }
	                        
	                }catch(e) {		
	                        console.log(e.message);
	                }
	            },
	            error: function(){
	                console.log("Error");
	            }
	        });
		}
	</script>
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