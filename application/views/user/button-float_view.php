
<div class="page-3">
 <div class="fixed-action-btn vertical" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large theme buble-th">
    <?php 
    if($this->router->class == 'topics'){
    	echo '<img src="'.base_url().'img/eng1.png" class="img-responsive" />';
    }else{
    	echo '<img src="'.base_url().'img/eng2.png" class="img-responsive" />';
    }	
    ?>
    </a>
    <ul class="icons-sty">
      <li>
      <a class="btn-floating theme buble-th" style="width:50px !important; height:50px !important;" href="<?php echo base_url()?>user/topics">
      	<?php 
		    if($this->router->class == 'topics'){
		    	echo '<img src="'.base_url().'img/paper1.png" style="width:35px;height:35px;left:8px;" />';
		    }else{
		    	echo '<img src="'.base_url().'img/paper.png" width="90" height="90" />';
		    }
    	?>
      </a> 
      <p class="chat-sty-para">Quality-Space</p>
      </li>
      <li>
      <a class="btn-floating theme buble-th" style="width:50px !important; height:50px !important;" href="<?php echo base_url()?>user/listeners">
      <?php 
		    if($this->router->class == 'topics'){
		    	echo '<img src="'.base_url().'img/chat2.png" style="width:30px;height:30px;left:1px;top:9px;" class="img-responsive  chat-sty" />';
		    }else{
		    	echo '<img src="'.base_url().'img/chat.png" style="width:40px;height:40px;left:1px;top:6px;" class="img-responsive  chat-sty" />';
		    }
		?>
      </a> 
      <p class="chat-sty-para">Talk to a buddy</p>
      </li>
    </ul>
  </div>
 </div> 