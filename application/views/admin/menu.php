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
                            <a href="<?php echo base_url();?>admin/listeners/add">Add</a>
                            <a href="<?php echo base_url();?>admin/listeners">List Listeners</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                    <a href="<?php echo base_url();?>admin/themes"><i class="ion-android-person"></i>Themes (1st Click)</a>
            </li>
            <li>
                    <a href="<?php echo base_url();?>admin/secondclick"><i class="ion-android-person"></i>2nd Click</a>
            </li>
            <!--li>
                    <a href="<?php echo base_url();?>admin/thirdclick"><i class="ion-android-person"></i>3rd Click</a>
            </li-->
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-camera"></i>Third Click<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="<?php echo base_url();?>admin/thirdclick">Add</a>
                            <a href="<?php echo base_url();?>admin/thirdclick/edit">List Thirdclicks</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-camera"></i>Theme/Categories<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="<?php echo base_url();?>admin/category/add">Add</a>
                            <a href="<?php echo base_url();?>admin/category">List Categories</a>
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
                            <a href="<?php echo base_url();?>admin/question/add">Add</a>
                            <a href="<?php echo base_url();?>admin/question">List</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
            <?php 
            if($this->session->userdata('validated')){
            	echo '<a href="javascript:void(0);" onclick="window.location=\''.base_url().'logout\'"><i class="ion-android-alert"></i> Logout</a>';
            }else{
            	echo '<i class="ion-android-alert"></i>';
            }
            ?>
            </li>
        </ul>