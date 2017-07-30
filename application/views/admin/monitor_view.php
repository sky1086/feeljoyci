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
                <h5>Listener Monitoring</h5>
              </div>
              <table style="width:100%;">
              	<?php if(!empty($listeners)){
              		echo '<tr style="border-bottom: #cccccc 1px solid;">
							<th>Name</th>
							<th>Last Seen</th>
							<th>Time spent in Session(Minutes)</th>
							<th>No. of unread conversations</th>
							<th>CaseLoad (No. of customer assigned)</th>
							<th>Notify Listener</th>
							</tr>';
              	foreach ($listeners as $listener){                 		
              		echo '<tr>
 							<td>'.$listener->contact_name.'</td>
							<td>'.($listener->last_login?date("M j, Y, g:i a", strtotime($listener->last_login)):'-').'</td>
							<td> - </td>
							<td>'.$listener->unreadMsg.'</td>
							<td>'.$listener->caseLoad.'</td>
							<td style="padding-top:5px;"><button type="button" onclick="sendEmailToListeners(this, '.$listener->userid.', '. $listener->unreadMsg.')" class="tabledit-edit-button btn btn-sm btn-primary" style="float: none;"><span class="glyphicon glyphicon-envelope"></span> &nbsp; Email</button></td>
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
<script type="text/javascript">
function sendEmailToListeners(btn, listenerId, unreadMsg){
	if(unreadMsg && listenerId){
		btn.disabled = true;
		$.ajax({
			type: 'post',
			url: '<?php echo base_url();?>admin/monitor/notifybyemail',
			data:  {listenerId: listenerId, unreadMsg: unreadMsg},
			success: function(rsp){
					if(parseInt(rsp) == ''){
						alert('Something went wrong.');
					}else {
						alert(rsp);
					}
					btn.disabled = false;
				}
		});
		}
}
</script>  
<?php $this->load->view('admin/backend-footer');?>