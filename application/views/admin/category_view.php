<?php $this->load->view('admin/backend-header');?>
        
 <!-------------------------------------------------------------------------->
        
        <section>
<div class="container-fluid">
 <div class="row">
     <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
       <div class="row">
          <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10" style="background-color: white; color:#000;">
              <div class="user-desc">
                <h5>Categories</h5>
              </div>
              <table>
              <tr>
              	<th>Theme</th>
              	<th>Category</th>
              	<th>Priority</th>
              	<th>Status</th>
              	<th>Action</th>
              </tr>
              	<?php if(!empty($categories)){
              	foreach ($categories['themes'] as $theme){
              		$theme_status = ($theme["status"] == 1?'<font color="green">Active</font>':'<font color="red">Inactive</font>');
              		echo '<tr>
 							<td>'.ucfirst($theme['name']).'</td>
        					<td></td>
       						<td>'.$theme['priority'].'</td>
        					<td>'.$theme_status.'</td>
        					<td><a href="'.base_url().'admin/category/edit/'.$theme['id'].'">Edit</a></td>
        				</tr>
          			<tr><td colspan="4"><hr style="margin:0 0 20px 0;"></td></tr>';
              		if(isset($categories[$theme['id']])){
              		foreach ($categories[$theme['id']] as $subCat){
              			$status = ($subCat["status"] == 1?'<font color="green">Active</font>':'<font color="red">Inactive</font>');
              			echo '<tr>
 							<td></td>
        					<td>'.ucfirst($subCat['name']).'</td>
              				<td>'.$theme['priority'].'</td>
        					<td>'.$status.'</td>
        					<td><a href="'.base_url().'admin/category/edit/'.$subCat['id'].'">Edit</a></td>
        				</tr>';
              		}
              		}
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