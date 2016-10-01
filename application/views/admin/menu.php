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
                    <!--ul id="dropdown1" class="dropdown-content">
                        <li><a href="#!">hellojhon@email.com</a></li>
                        <li><a href="#!">heyfromjhon@email.com</a></li>
                        <li class="divider"></li>
                        <li><a href="#!">Settings <i class="ion-ios-gear"></i></a></li>
                    </ul-->
                </div>
            </li>
            <!--li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-home"></i>Home<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="index.html">Classic</a>
                            <a href="index-sliced.html">Sliced</a>
                            <a href="index-slider.html">Slider</a>
                            <a href="index-drawer.html">Drawer</a>
                            <a href="index-walkthrough.html">Walkthrough</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-exit"></i>Layout<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="material.html">Material</a>
                            <a href="left-sidebar.html">Left</a>
                            <a href="right-sidebar.html">Right</a>
                            <a href="dual-sidebar.html">Dual</a>
                            <a href="blank.html">Blank</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-document"></i>Pages<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="article.html">Article</a>
                            <a href="event.html">Event</a>
                            <a href="project.html">Project</a>
                            <a href="player.html">Music Player</a>
                            <a href="todo.html">ToDo</a>
                            <a href="category.html">Category</a>
                            <a href="product.html">Product</a>
                            <a href="checkout.html">Checkout</a>
                            <a href="search.html">Search</a>
                            <a href="faq.html">Faq</a>
                            <a href="coming-soon.html">Coming Soon</a>
                            <a href="404.html">404</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-apps"></i>App<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="calendar.html">Calendar</a>
                            <a href="profile.html">Profile</a>
                            <a href="timeline.html">Timeline</a>
                            <a href="chat.html">Chat</a>
                            <a href="login.html">Login</a>
                            <a href="signup.html">Sign Up</a>
                            <a href="forgot.html">Password</a>
                            <a href="lockscreen.html">Lockscreen</a>
                            <a href="chart.html">Chart</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-list"></i>Blog<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="blog.html">Classic</a>
                            <a href="blog-masonry.html">Masonry</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-image"></i>Gallery<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="gallery-filter.html">Filter</a>
                            <a href="gallery-masonry.html">Masonry</a>
                            <a href="gallery-card.html">Card</a>
                        </li>
                    </ul>
                </div>
            </li-->
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-person"></i>Listeners<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="<?php echo base_url();?>admin/category/add">Add</a>
                            <a href="<?php echo base_url();?>admin/category">List Listeners</a>
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
            <li><a href="contact.html" class="waves-effect"><i class="ion-android-map"></i> Dummy</a></li>
        </ul>