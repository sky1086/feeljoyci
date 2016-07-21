<?php
error_reporting(0);
?>
<script src="<?php echo base_url();?>js/chat/moment.min.js"></script>
<script src="<?php echo base_url();?>js/chat/livestamp.js"></script>
<!--  link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/chat/style.css" media="screen"-->

<link href="<?php echo base_url();?>lib-emoji/emoji.css?cb=<?=time()?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/chat/jquery.cssemoticons.css" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>js/chat/jquery.cssemoticons.min.js" type="text/javascript"></script>

<div class="chatbar" id="chatbar">

	<!--  div class="chatcontainer">
      <div class="chat" id="chat">
      <div class="close" onclick="removeChat()" title="Close">X</div>
        <div class="stream" id="cstream">
      </div>
      </div>
      <div class="chatmsg">
          <form method="post" id="msenger" action="">
            <textarea name="msg" id="msg-min"></textarea>
            <input type="hidden" name="cbidn" value="">
            <input type="submit" value="Send" id="sb-mt">
          </form>
      </div>
      <div id="dataHelper" last-id=""></div>
  </div-->
  
  </div>
<script type="text/javascript">

function showChat(fid){
	if(fid && fid != "undefined"){
		var chatbox = '<div class="chatcontainer"><div class="chat" id="chat"><div class="close" onclick="removeChat()" title="Close">X</div><div class="stream" id="cstream"></div></div><div class="chatmsg"><form method="post" id="msenger" action="" onsubmit="return submitMsg();"><textarea name="msg" id="msg-min"></textarea><input type="hidden" name="fid" id="fid" value="'+fid+'"><input type="submit" value="Send" id="sb-mt"></form></div><div id="dataHelper" last-id=""></div></div>';
		$('#chatbar').append(chatbox);
		$('#msg-min').focus();
		getOldChat(fid);
	}
}

function removeChat(){
	$( ".chatcontainer" ).remove();
}

$(document).keyup(function(e){
	if(e.keyCode == 13){
		if($('#msenger textarea').val().trim() == ""){
			$('#msenger textarea').val('');
		}else{
			$('#msenger textarea').attr('readonly', 'readonly');
			$('#sb-mt').attr('disabled', 'disabled');	// Disable submit button
			sendMsg();
		}		
	}
});	

function submitMsg() {
    $('#msg-min').focus();
	$('#msenger textarea').attr('readonly', 'readonly');
	$('#sb-mt').attr('disabled', 'disabled');	// Disable submit button
	sendMsg();
	return false;
}

function getOldChat(fid){
	$.ajax({
		type: 'post',
		url: '<?php echo base_url();?>chat/chatM/index/?rq=oMsg',
		data: {fid: fid},
		dataType: 'json',
		success: function(rsp){
				if(parseInt(rsp.status) == 1){
					$design = '';
					$.each( rsp.msgData, function( key, value ) {
						var match = value.time.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
						var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);
					$design += '<div class="float-fix">'+
					'<div class="'+value.clsname+'">'+
						'<div class="msg-bg">'+
							'<div class="msgA">'+
							value.msg+
								'<div class="">'+
									'<div class="msg-time time-'+value.id+'" data-livestamp="'+((date.getTime() / 1000)+19800)+'"></div>'+
									'<div class="'+(value.clsname == 'm-rply'?'myrply-i':'myrply-f')+'"></div>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';
				
					$('.time-'+value.id).livestamp();
					$('#dataHelper').attr('last-id', value.id);
				});
				
				$('#cstream').prepend($design);
			
				$('.msgA').emoticonize({
					//delay: 800,
					//animate: false,
					//exclude: 'pre, code, .no-emoticons'
				});
				
				$('#chat').scrollTop ($('#cstream').height());
				}
			}
		});
}

function sendMsg(){
	$.ajax({
		type: 'post',
		url: '<?php echo base_url();?>chat/chatM/index/?rq=new',
		data: $('#msenger').serialize(),
		dataType: 'json',
		success: function(rsp){
				$('#msenger textarea').removeAttr('readonly');
				$('#sb-mt').removeAttr('disabled');	// Enable submit button
				if(parseInt(rsp.status) == 0){
					alert(rsp.msg);
				}else if(parseInt(rsp.status) == 1){
					$('#msenger textarea').val('');
					$('#msenger textarea').focus();
					//$design = '<div>'+rsp.msg+'<span class="time-'+rsp.lid+'"></span></div>';
					$design = '<div class="float-fix">'+
									'<div class="m-rply">'+
										'<div class="msg-bg">'+
											'<div class="msgA">'+
												rsp.msg+
												'<div class="">'+
													'<div class="msg-time time-'+rsp.lid+'"></div>'+
													'<div class="myrply-i"></div>'+
												'</div>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>';
					$('#cstream').append($design);
					
					$('.msgA').emoticonize({
						//delay: 800,
						//animate: false,
						//exclude: 'pre, code, .no-emoticons'
					});
					
					$('.time-'+rsp.lid).livestamp();
					$('#dataHelper').attr('last-id', rsp.lid);
					$('#chat').scrollTop($('#cstream').height());
				}
			}
		});
}
function checkStatus(){
	$fid = $('#fid').val();
	$.ajax({
		type: 'post',
		url: '<?php echo base_url();?>chat/chatM/index/?rq=msg',
		data: {fid: $fid, lid: $('#dataHelper').attr('last-id')},
		dataType: 'json',
		cache: false,
		success: function(rsp){
				if(parseInt(rsp.status) == 0){
					return false;
				}else if(parseInt(rsp.status) == 1){
					getMsg();
				}
			}
		});	
}

// Check for latest message
setInterval(function(){checkStatus();}, 5000);

function getMsg(){
	$fid = $('#fid').val();
	$.ajax({
		type: 'post',
		url: '<?php echo base_url();?>chat/chatM/index/?rq=NewMsg',
		data:  {fid: $fid},
		dataType: 'json',
		success: function(rsp){
				if(parseInt(rsp.status) == 0){
					//alert(rsp.msg);
				}else if(parseInt(rsp.status) == 1){
					$design = '<div class="float-fix">'+
									'<div class="f-rply">'+
										'<div class="msg-bg">'+
											'<div class="msgA">'+
												rsp.msg+
												'<div class="">'+
													'<div class="msg-time time-'+rsp.lid+'"></div>'+
													'<div class="myrply-f"></div>'+
												'</div>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>';

					//open chat box if not already
					if($(".chatcontainer").length == 0){
						showChat(rsp.from);
					}
								
					$('#cstream').append($design);

					$('.msgA').emoticonize({
						//delay: 800,
						//animate: false,
						//exclude: 'pre, code, .no-emoticons'
					});
					
					$('#chat').scrollTop ($('#cstream').height());
					$('.time-'+rsp.lid).livestamp();
					$('#dataHelper').attr('last-id', rsp.lid);	
				}
			}
	});
}

$(document).ready(function() {
    var s = $("#chatbar");
    var pos = s.offset().top+s.height(); //offset that you need is actually the div's top offset + it's height
    $(window).scroll(function() {
        var windowpos = $(window).scrollTop(); //current scroll position of the window
        var windowheight = $(window).height(); //window height
        if (windowpos+windowheight>pos) s.addClass('stick'); //Currently visible part of the window > greater than div offset + div height, add class
        else s.removeClass('stick');
    });
});
</script>



<div class="page animated fadeinup">

            <div class="chat p-20">
                <ul>
                    <li class="message-right animated fadeinright">
                        <img alt="" src="<?php echo base_url();?>img/man.png">
                        <div class="message">
                            <p>
                                Hello! The brown fox jumps over.
                            </p>
                        </div>
                        <span>Seen at 08:23</span>
                    </li>

                    <li class="message-left animated fadeinright delay-1">
                        <img alt="" src="<?php echo base_url();?>img/woman.png">
                        <div class="message first">
                            <p>
                                The quick, brown fox jumps over a lazy dog.
                            </p>
                        </div>
                        <div class="message">
                            <img alt="" src="img/10.jpg">
                        </div>
                        <div class="message last">
                            <p>
                                Hope to see you soon!
                            </p>
                        </div>
                    </li>

                    <li class="chat-day">
                        <h6>March 27 at 6:32</h6>
                    </li>

                    <li class="message-right animated fadeinright delay-2">
                        <img alt="" src="<?php echo base_url();?>img/man.png">
                        <div class="message">
                            <p>
                                Quick, Baz, get my woven!
                            </p>
                        </div>
                        <span>Seen at 07:44</span>
                    </li>

                    <li class="message-left animated fadeinright delay-3">
                        <img alt="" src="<?php echo base_url();?>img/woman.png">
                        <div class="message">
                            <p>
                                Call me now!
                            </p>
                        </div>
                    </li>

                    <li class="message-right animated fadeinright delay-4">
                        <img alt="" src="<?php echo base_url();?>img/man.png">
                        <div class="message first">
                            <p>
                                Let's watch my latest shots.
                            </p>
                        </div>
                        <div class="message last">
                            <p>
                                Ok! You're right!
                            </p>
                        </div>
                    </li>

                    <li class="message-left animated fadeinright delay-5">
                        <img alt="" src="<?php echo base_url();?>img/woman.png">
                        <div class="message first">
                            <p>
                                Junk MTV quiz graced...
                            </p>
                        </div>
                        <div class="message">
                            <p>
                                Ok! You're right!
                            </p>
                        </div>
                        <div class="message last">
                            <p>
                                Bawds jog!
                            </p>
                        </div>
                    </li>

                    <li class="message-right animated fadeinright delay-6">
                        <img alt="" src="<?php echo base_url();?>img/man.png">
                        <div class="message">
                            <p>
                                Quick zephyrs blow, vexing daft Jim.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
        <!-- End of Page Contents -->

        <!-- Sidebars -->
        <!-- Left Sidebar -->
        <ul id="slide-out-left" class="side-nav collapsible">
            <li class="sidenav-avatar bg-material">
                <div class="opacity-overlay-gradient"></div>
                <div class="bottom">
                    <img src="img/user.jpg" alt="" class="avatar">
                    <!-- Dropdown Trigger -->
                    <span class="dropdown-button waves-effect waves-light" data-activates="dropdown1">heyfromjhon@email.com<i class="ion-android-arrow-dropdown right"></i></span>
                    <!-- Dropdown Structure -->
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="#!">hellojhon@email.com</a></li>
                        <li><a href="#!">heyfromjhon@email.com</a></li>
                        <li class="divider"></li>
                        <li><a href="#!">Settings <i class="ion-ios-gear"></i></a></li>
                    </ul>
                </div>
            </li>
            <li>
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
            </li>
            <li>
                <div class="collapsible-header waves-effect">
                    <i class="ion-android-camera"></i>Portfolio<span class="more"><i class="ion-ios-arrow-right"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul class="collapsible">
                        <li>
                            <a href="portfolio-filter.html">Filter</a>
                            <a href="portfolio-masonry.html">Masonry</a>
                            <a href="portfolio-card.html">Card</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li><a href="shop.html" class="waves-effect"><i class="ion-android-playstore"></i> Shop</a></li>
            <li><a href="news.html" class="waves-effect"><i class="ion-social-rss"></i> News</a></li>
            <li><a href="#!" class="waves-effect"><i class="ion-wand"></i>UI Kit (Coming Soon)</a></li>
            <li><a href="contact.html" class="waves-effect"><i class="ion-android-map"></i> Contact</a></li>
        </ul>

        <!-- Right Sidebar -->
        <ul id="slide-out" class="side-nav">
            <li class="sidenav-header">
                <!-- Srearch bar -->
                <nav>
                    <div class="nav-wrapper">
                        <form>
                            <div class="input-field">
                                <input id="search" type="search" required>
                                <label for="search"><i class="ion-android-search"></i></label>
                                <i class="ion-android-close"></i>
                            </div>
                        </form>
                    </div>
                </nav>
            </li>
            <!-- Tabs -->
            <li>
                <ul class="tabs">
                    <li class="tab col s3"><a href="#sidebar1">Social</a></li>
                    <li class="tab col s3"><a href="#sidebar2" class="active">Chat</a></li>
                </ul>
            </li>
            <li id="sidebar1" class="p-20">
                <!-- Twitter -->
                <div class="twitter">
                    <h6 class="follow-us"><i class="ion-social-twitter"></i> Follow us on Twitter</h6>
                    <div class="tweet">
                        <h3>@Codnauts</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod <a href="#">#tempor</a>.</p>
                    </div>
                    <div class="tweet">
                        <h3>@Codnauts</h3>
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in <a href="#">#voluptate</a> culpa qui officia deserunt mollit anim.</p>
                    </div>
                    <div class="tweet">
                        <h3>@Codnauts</h3>
                        <p>At vero eos et accusamus et iusto odio <a href="#">#dignissimos</a> <a href="#">#ducimus</a> qui blanditiis praesentium.</p>
                    </div>
                </div>
                <!-- Facebook -->
                <div class="facebook">
                    <h6 class="follow-us">Notifications</h6>
                    <div class="face-notification">
                        <img src="<?php echo base_url();?>img/woman.png" alt="" class="cricle">
                        <div>
                            <p>Mike Green</p>
                            <span>Sent you a message</span>
                            <span class="small">Today at 16:48</span>
                        </div>
                    </div>
                    <div class="face-notification">
                        <img src="img/user.jpg" alt="" class="cricle">
                        <div>
                            <p>Lara Connors</p>
                            <span>Post a photo with you</span>
                            <span class="small">Today at 14:26</span>
                        </div>
                    </div>
                    <div class="face-notification">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <div>
                            <p>Mike Green</p>
                            <span>Post something...</span>
                            <span class="small">Yesterday at 03:19</span>
                        </div>
                    </div>
                </div>

            </li>
            <li id="sidebar2" class="p-20">
                <!-- Chat -->
                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="img/user.jpg" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p>Mike Green</p>
                        <span>Sent you a message</span>
                        <span class="small">online</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/woman.png" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p>Lora Bell</p>
                        <span>6 New messages</span>
                        <span class="small">online</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot orange"></span>
                    </div>
                    <div class="chat-message">
                        <p>Tony Lee</p>
                        <span>Away from keyboard.</span>
                        <span class="small">Away</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="img/user4.jpg" alt="" class="cricle">
                        <span class="dot grey"></span>
                    </div>
                    <div class="chat-message">
                        <p>Jim Connor</p>
                        <span>Is offline.</span>
                        <span class="small">offline</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="img/user5.jpg" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p>Sara Lower</p>
                        <span>Sent you a message</span>
                        <span class="small">online</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="img/user.jpg" alt="" class="cricle">
                        <span class="dot grey"></span>
                    </div>
                    <div class="chat-message">
                        <p>Mick Pole</p>
                        <span>Is offline.</span>
                        <span class="small">offline</span>
                    </div>
                </div>

                <div class="chat-sidebar">
                    <div class="chat-img">
                        <img src="<?php echo base_url();?>img/man.png" alt="" class="cricle">
                        <span class="dot green"></span>
                    </div>
                    <div class="chat-message">
                        <p>James Tree</p>
                        <span>Awaiting your reply.</span>
                        <span class="small">online</span>
                    </div>
                </div>
            </li>
        </ul>
        <!-- End of Sidebars -->

    </div>
    <!-- End of Main Container -->
    <div class="meta_holder">
        <div class="chat-text-holder">
            <div class="left">
                <textarea class="chat-text-box" placeholder="Type a message"></textarea>
            </div>
            <div class="right">
                <input type="button" class="send-button" value="" />
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!--script src="<?php echo base_url();?>js/vendor/jquery-2.1.0.min.js"></script-->
    <script src="<?php echo base_url();?>js/helper.js"></script>
    <script src="<?php echo base_url();?>js/vendor/HeadsUp.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.smoothState.js"></script>
    <script src="<?php echo base_url();?>js/vendor/chart.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.mixitup.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.swipebox.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/masonry.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/swiper.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/materialize.min.js"></script>
    <script src="<?php echo base_url();?>js/main.js"></script>
</body>

</html>
