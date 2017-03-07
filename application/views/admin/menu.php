<!-- Sidebars -->
        <!-- Left Sidebar -->
        <ul id="slide-out-left" class="side-nav collapsible">
            <li class="sidenav-avatar bg-material">
                <div class="opacity-overlay-gradient"></div>
                <div class="bottom">
                    <img src="<?php echo base_url();?>img/man.png" alt="" class="avatar">
                    <!-- Dropdown Trigger -->
                    <span class="dropdown-button waves-effect waves-light" data-activates="dropdown1"><?php echo $this->session->userdata('email');?><i class="ion-android-arrow-dropdown right"></i></span>
                    <!-- Dropdown Structure -->
            </div>
            </li>        
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-person"></i>Listeners<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="<?php echo base_url();?>admin/listeners/add" onclick="window.location=this.href;">Add</a>
                            <a href="<?php echo base_url();?>admin/listeners" onclick="window.location=this.href;">List Listeners</a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-person"></i>Customer Click Engine<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="<?php echo base_url();?>admin/themes" onclick="window.location=this.href;" ><i class="ion-android-person"></i>1st Click</a>
                            <a href="<?php echo base_url();?>admin/secondclick" ><i class="ion-android-person"></i>2nd Click</a>
                            <a href="<?php echo base_url();?>admin/thirdclick" onclick="window.location=this.href;">Add 3rd Click</a>
                            <a href="<?php echo base_url();?>admin/thirdclick/listing" onclick="window.location=this.href;">List Thirdclicks</a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-person"></i>Buddy Click Engine<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="<?php echo base_url();?>admin/listener/themes" onclick="window.location=this.href;" ><i class="ion-android-person"></i>Buddy 1st Click</a>
                            <a href="<?php echo base_url();?>admin/listener/secondclick" ><i class="ion-android-person"></i>Buddy 2nd Click</a>
                            <a href="<?php echo base_url();?>admin/listener/thirdclick" onclick="window.location=this.href;">Buddy 3rd Click</a>
                            <a href="<?php echo base_url();?>admin/listener/thirdclick/listing" onclick="window.location=this.href;">Buddy List 3rd Click</a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!--li>
                    <a href="<?php echo base_url();?>admin/listener/thirdclick"><i class="ion-android-person"></i>3rd Click</a>
            </li-->
            <!-- li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-camera"></i>Theme/Categories<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="<?php //echo base_url();?>admin/category/add">Add</a>
                            <a href="<?php //echo base_url();?>admin/category">List Categories</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-clipboard"></i>Questions/Answers<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="<?php //echo base_url();?>admin/question/add">Add</a>
                            <a href="<?php //echo base_url();?>admin/question">List</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li-->
            <?php 
            if($this->session->userdata('validated')){
            	echo '<a href="javascript:void(0);" onclick="window.location=\''.base_url().'logout\'"><i class="ion-android-alert"></i> Logout</a>';
            }else{
            	echo '<i class="ion-android-alert"></i>';
            }
            ?>
            </li>
        </ul>