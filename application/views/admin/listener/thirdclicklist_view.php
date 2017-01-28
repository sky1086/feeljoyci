<?php $this->load->view('admin/backend-header');?>
<link rel="stylesheet" href="<?php echo base_url();?>css/modal-popup.css">
<script src="<?php echo base_url();?>js/modal-popup.js"></script>
 <!-------------------------------------------------------------------------->
        
        <section>
<div class="container-fluid">
 <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">              
       <div class="row">
          <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10" style="background-color: white; color:#000;">
          	<div id="tablejson"></div>
              <div class="user-desc">             
                <h5>Third clicks</h5>
              </div>
              
              <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10" style="background-color: white; color:#000;">
              <div class="user-desc">
              <?php if($id > 0){?>
                <h5>Edit Third click</h5>
                <?php }else{?>
                <h5>Add Third click</h5>
                <?php }?>
              </div>
              <div class="user-desc">
              <span>Theme &nbsp;</span>
                <select name="theme" id="theme" style="width: 200px;" onchange="getSecondClicks(this.value);">
                <option value="">Select Theme</option>
	                <?php foreach ($categories['themes'] as $theme){
	                	echo '<option '.($id == $theme['id']?'selected':'').' value="'.$theme['id'].'">'.ucfirst($theme['name']).'</option>';
	                }?>
              	</select>
              </div>
              <div class="user-desc">
              <span>Second click &nbsp;</span>
                <select name="secondclick" id="secondclick" style="width: 200px;" onchange="getThirdclicksAnswers(this.value);">
                <option value="">Select 2nd Click</option>
              	</select>
              </div>
		</div>
              
              <table id="themeedit">
              <thead>
              <tr>
              	<th style="padding:10px;">Id</th>
              	<th style="padding:10px;">Third Click Title</th>
              	<th style="padding:10px;">Answer</th>
              	<th style="padding:10px;">Priority</th>
              	<th style="padding:10px;">Status</th>
              	<th style="padding:10px;">Action</th>
              </tr>
              </thead>
              <tbody>
              	</tbody>
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
  <script type="text/javascript">
<!--

function addTheme(){
	var theme = $('#theme').val();
	if(theme == ''){
		alert('Please select theme first');
		return false;
	}
	var secondclick = $('#secondclick').val();
	var hasThirdClick = $("input[name=thirdClickFlag]:checked").val();
	var quest = $('#question').val();
	var priority = $('#priority').val();
	var status = $('#status').val();
	var answer = $('#answer').val();
	$.ajax({
		type: 'post',
		url: '<?php echo base_url();?>admin/listener/thirdclick/add',
		data:  {pid: theme, cid: secondclick, thirdclick:hasThirdClick, question:quest, priority: priority, status: status, answer:answer},
		success: function(rsp){
				if(rsp == 0){
					//alert(rsp.msg);
				}else if(rsp == 1){
					alert('Added succuessfully');
				}
			}
	});
	}

function getSecondClicks(id){
	if(id > 0){
		$.ajax({
			type: 'post',
			url: '<?php echo base_url();?>admin/listener/thirdclick/getSecondClicks',
			data:  {id: id},
			success: function(rsp){
					if(rsp != 0){
				        var secondOptions = $("#secondclick");

				        secondOptions.empty();
				        rsp = JSON.parse(rsp);
				        $("<option />")
			            .attr("value", "")
			            .html("Select 2nd Click")
			            .appendTo(secondOptions);
				        $.each(rsp, function(){
				            $("<option />")
				            .attr("value", this.id)
				            .html(this.name)
				            .appendTo(secondOptions);
				        });
					}else{
						console.log('no data');
					}
				}
		});
	}
}

function getThirdclicksAnswers(cid){
	$.ajax({
		url: '<?php echo base_url();?>admin/listener/thirdclick/getThirdClicks/'+cid,
		success: function(rsp){
				if(rsp != 0){
					data = JSON.parse(rsp);
					$("#tablejson").html(data.popupDiv);
					$('#themeedit').DataTable().destroy();
					$('#themeedit').DataTable({
						data: data.data,
						"bPaginate": false,
				        "order": [ 0, "desc" ],
				        "aaSorting": []
				    });
					applyPopup();
				}else{
					console.log('no data');
				}
			}
	});
}
$(document).ready(function(){
	getThirdclicksAnswers(0);
	//var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
    //$("body").append(appendthis);
});
//-->
</script>
<?php $this->load->view('admin/backend-footer');?>