<?php $this->load->view('admin/backend-header');?>

 <!-------------------------------------------------------------------------->
        
        <section>
<div class="container-fluid">
 <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
     <div class="row">
     	<div class="col-md-10 col-lg-10 col-sm-10 col-xs-10" style="background-color: white; color:#000;">
              <div class="user-desc">
                <h5>Add Third click</h5>
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
                <select name="secondclick" id="secondclick" style="width: 200px;">
                <option value="">Select 2nd Click</option>
              	</select>
              </div>
              <div class="user-desc">
              <span>Third click &nbsp;</span>
                <input type="radio" name="thirdClickFlag" id="tcFlagTrue" checked value='1' onclick="toggelThirdClick(1);"> <label for="tcFlagTrue"> Yes</label>
                <input type="radio" name="thirdClickFlag" id="tcFlagFalse" value='0' onclick="toggelThirdClick(0);"> <label for="tcFlagFalse"> No</label>
              </div>
              
              <table>
              <tr id="questionRow">
              	<td><input type="text" style="width: 200px;" name="question" id="question" placeholder="Title" required />&nbsp;&nbsp;&nbsp;&nbsp;</td>
              	<td><input type="text" style="width: 200px;" name="priority" id="priority" placeholder="Priority in number" required />&nbsp;&nbsp;&nbsp;&nbsp;</td>
              	<td>
              		<select name="status" id="status" style="width: 200px;">
              			<option value="1">Active</option>
              			<option value="0">Inactive</option>
              		</select>&nbsp;&nbsp;&nbsp;&nbsp;
              	</td>
              	<td>
              		
				</td>
              </tr>
              <tr>
              <td colspan="3" style="text-align: left;">
              Answer
              </td>
              </tr>
              <tr>
              <td colspan="3" style="text-align: left;">
              <textarea name="answer" class="jqt-editor" id="answer" rows=50 id="category" style="width: 50%;height:100px;"></textarea>
              </td>
              </tr>
              <tr>
              <td><input type="submit" name="add" onclick="addTheme();" value="Save" style="width: 100px;" /></td>
              <td colspan="2"></td>
              </tr>
              </table>
		</div>
	</div>
              
       <div class="row">
          <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10" style="background-color: white; color:#000;">
          	<div id="tablejson"></div>
              <div class="user-desc">
                <h5>Third clicks</h5>
              </div>
              <table id="themeedit">
              <tr>
              	<th style="padding:10px;">Id</th>
              	<th style="padding:10px;">Theme</th>
              	<th style="padding:10px;">Priority</th>
              	<th style="padding:10px;">Status</th>
              </tr>
              	<?php 
              	$err = '';
              	if(!empty($categories) && isset($categories[$id])){
              	foreach ($categories[$id] as $theme){
              		$theme_status = ($theme["status"] == 1?'<font color="green">Active</font>':'<font color="red">Inactive</font>');
              		echo '<tr>
     						<td style="padding:10px;">'.$theme['id'].'</td>
 							<td style="padding:10px;">'.ucfirst($theme['name']).'</td>
       						<td style="padding:10px;">'.$theme['priority'].'</td>
        					<td style="padding:10px;">'.$theme_status.'</td>
        				</tr>';
              	}
              	}else{
              		$err = 'No Record Found';
              	}?>
              </table>
              <?php echo $err;?>
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
$('#themeedit').Tabledit({
	url: '<?php echo base_url();?>admin/thirdclick/edit',
    deleteButton: false,
    autoFocus: false,
    buttons: {
        edit: {
            class: 'btn btn-sm btn-primary',
            html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp EDIT',
            action: 'edit'
        }
    },
	columns: {
	  identifier: [0, 'id'],                    
	  editable: [[1, 'category'], [2, 'priority'], [3, 'status','{"1":"Active", "0":"Inactive"}']],	  
	}
	
});

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
		url: '<?php echo base_url();?>admin/thirdclick/add',
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

function toggelThirdClick(toggleVal){
	if(toggleVal){
		$('#questionRow').show('slow');
		}else{
			$('#questionRow').hide('slow');
			}
}
function getSecondClicks(id){
	if(id > 0){
		$.ajax({
			type: 'post',
			url: '<?php echo base_url();?>admin/thirdclick/getSecondClicks',
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

$('.jqt-editor').jqte();

//-->
</script>
  
<?php $this->load->view('admin/backend-footer');?>