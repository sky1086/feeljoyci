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
                <h5>Listeners</h5>
              </div>
              <table style="width:100%;">
              	<?php if(!empty($listeners)){
              	foreach ($listeners as $listener){
              		//get associated categories
              		$cat_assoc = $this->listeners_model->getAssocCategoryDetails($listener->id);
              		$theme_status = ($listener->status == 1?'<font color="green">Active</font>':'<font color="red">Inactive</font>');
              		echo '<tr>
 							<td style="padding-top:20px;padding-left:20px;color:blue;" colspan="3">'.ucfirst($listener->name).' &nbsp;&nbsp;&nbsp;&nbsp;(<a href="'.base_url().'admin/listeners/edit/'.$listener->id.'">Edit</a>)<hr style="margin:0 0 5px 0;"></td>
     					  </tr>
     					  <tr>
          					<td rowspan="5" style="width:20%;padding-left:20px;padding-top:5px;vertical-align:top;"><img src="'.base_url().'pics_listener/'.$listener->profile_img.'" style="width:100px; height:100px;" /></td>
 							<td colspan="2">'.ucfirst($listener->interests).'</td>
     					  </tr>
              			  <tr>
 							<td colspan="2"><b>Status: </b>'.$theme_status.'</td>
     					  </tr>
              			  <tr>
 							<td colspan="2"><b>Priority: </b>'.$listener->priority.'</td>
     					  </tr>
              		      <tr>
 							<td width="20%"> <b>Linked Categories: </b></td>
              					<td><select name="categories" class="linkCat" id="linkCat'.$listener->id.'" multiple="multiple" style="height:40px;width:80%;">';
              				foreach ($categories as $category){
              						echo '<option value="'.$category->id.'" '.(in_array($category->id, $cat_assoc)?'selected':'').'>'.$category->name.'</option>';
              				}
              			echo	'</select>
              				</td>
     					  </tr>
 									<tr>
 									<td></td>
 									<td style="padding-top:5px;">
										<input class="waves-light btn" type="button" onclick="saveCatLink(\''. $listener->id .'\');" name="Add" value="Save" /> <span id="saveMsg'.$listener->id.'"></span>
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
	            url: BASE_URL + "admin/listeners/catassoc",
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