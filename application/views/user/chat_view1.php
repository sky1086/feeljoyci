<?php
error_reporting(0);
//$this->load->view('admin/header');
?>
<!DOCTYPE html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FeelJoy</title>
    <meta name="description" content="Material Design Mobile Template">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>img/touch/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>img/touch/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>img/touch/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>img/touch/apple-touch-icon-57x57-precomposed.png">
    <link rel="shortcut icon" sizes="196x196" href="<?php echo base_url();?>img/touch/touch-icon-196x196.png">
    <link rel="shortcut icon" href="<?php echo base_url();?>img/touch/apple-touch-icon.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="<?php echo base_url();?>img/touch/apple-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#222222">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- SEO: If mobile URL is different from desktop URL, add a canonical link to the desktop page -->
    <!--
    <link rel="canonical" href="http://www.example.com/" >
    -->

    <!-- For iOS web apps. Delete if not needed. https://github.com/h5bp/mobile-boilerplate/issues/94 -->
    <!--
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="">
    -->

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,100' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <!-- Icons -->
    <link href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" media="all" rel="stylesheet" type="text/css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url();?>css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/materialize.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/swipebox.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="<?php echo base_url();?>js/mobile.js"></script>
    <script src="<?php echo base_url();?>js/vendor/modernizr-2.7.1.min.js"></script>
    <style>
        .primary-color {
            background-color: #56B68B !important;
        }

        .meta_holder {
            width: 100%;
            height: 75px;
            position: fixed;
            ;
            bottom: 0;
            padding: 10px;
            margin-bottom: -9px;
        }

        .chat-text-holder {
            border-radius: 6px;
            height: 50px;
            background-color: rgba(86, 182, 139, 0.80);
            display: flex;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15), 0  1px 4px rgba(0,0,0,0.20);
        }

        .left {
            flex: 0 1 85%;
            height: 100%;
            padding: 5px;
            box-sizing: border-box;
        }

        .chat-text-box {
            opacity: 1 !important;
            width: 100%;
            height: 100%;
            resize: none;
            padding: 5px 5px 5px 12px;
            border: none;
            /*box-shadow: 0px 1px 3px #fff;*/
            border-radius: 3px;
            background-color: #fff;
            border-color: #fff;
            border-width: 1px;
            overflow: hidden;
        }

        .right {
            flex: 0 1 15%;
            width: 100%;
            height: 100%;
        }

        .send-button {
            background-image: url('<?php echo base_url();?>icon/send-1x.png');
            background-repeat: no-repeat;
            height: 100%;
            width: 100%;
            border: medium none;
            background-color:rgb(119, 197, 162);
            border-radius: 3px;
            background-position: center;
            background-size: 60%,60%;
        }
    </style>
    <?php $this->load->view('user/theme-common');?>
</head>

<body>

    <!-- Main Container -->
    <div id="main" class="main">
    <?php $this->load->view('user/main-nav');?>
        <!-- Toolbar -->
        



<!--  link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/chat/style.css" media="screen"-->

<link href="<?php echo base_url();?>lib-emoji/emoji.css?cb=<?=time()?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>css/chat/jquery.cssemoticons.css" media="screen" rel="stylesheet" type="text/css" />


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
	if(e.shiftKey && e.keyCode == 13){
		$txtVal = $('#msenger textarea').val();
		//$('#msenger textarea').val($txtVal +"\n\r");
	}
	if(!e.shiftKey && e.keyCode == 13){
		if(!isMobile.any){
		if($('#msenger textarea').val().trim() == ""){
			$('#msenger textarea').val('');
		}else{
			$('#msenger textarea').attr('readonly', 'readonly');
			$('#sb-mt').attr('disabled', 'disabled');	// Disable submit button
			sendMsg();
		}
		}
	}
});	

function submitMsg() {
    $('#msg-min').focus();
	//$('#msenger textarea').attr('readonly', 'readonly');
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
					$grpmsg = 0;
					$.each( rsp.msgData, function( key, value ) {
						//var match = value.time.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
						//var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);
						console.log();
						$num_child = value.length;
						$clsrow = '';
						if(value[0]['id']){
							if($num_child > 1)
								$clsrow = 'first';
							$design += '<li class="message-'+(value[0]['clsname'] == 'm-rply'?'right':'left')+' animated fadeinright">'+
							'<img alt="" src="<?php echo base_url();?>img/man.png">';
							$rc = 0;
							$.each(value, function(rkey, rvalue){
								$rc++;
								if($rc == $num_child && $num_child != 1){
									$clsrow = 'last';
								}
								
							$design += '<div class="message '+$clsrow+'">'+
								'<p>'+
								rvalue.msg+
								'</p>'+
							'</div>';
							$clsrow = '';
							});
							var rowid = value[$num_child-1];
							var match = rowid['time'].match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
							var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);
							$design +='<span class="msg-time time-'+rowid.id+'" data-livestamp="'+((date.getTime() / 1000)+19800)+'"></span>'+
							'</li>';
				
						$('.time-'+rowid.id).livestamp();
						$('#dataHelper').attr('last-id', rowid.id);
						}
				});
				
				$('#cstream').prepend($design);
			
				$('.message').emoticonize({
					//delay: 800,
					//animate: false,
					//exclude: 'pre, code, .no-emoticons'
				});
				
				//$('#chat').scrollTop ($('#cstream').height());
				//$(document).scrollTop($('#cstream').height());
				$(function () {
			           $("html, body").animate({
						scrollTop: $('html, body').get(0).scrollHeight + 2000}, 2500);});
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
					
					$design = '<li class="message-right animated fadeinright">'+
									'<img alt="" src="<?php echo base_url();?>img/man.png">'+
										'<div class="message">'+
											'<p>'+
												rsp.msg+
											'</p>'+
										'</div>'+
										'<span class="msg-time time-'+rsp.lid+'"></span>'+
								'</li>';

					$('#cstream').append($design);
					
					$('.message').emoticonize({
						//delay: 800,
						//animate: false,
						//exclude: 'pre, code, .no-emoticons'
					});
					
					$('.time-'+rsp.lid).livestamp();
					$('#dataHelper').attr('last-id', rsp.lid);
					$(document).scrollTop($(document).height() + 100);
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
setInterval(function(){checkStatus();}, 2000);

function getMsg(){
	$fid = $('#fid').val();
	$.ajax({
		type: 'post',
		url: '<?php echo base_url();?>chat/chatM/index/?rq=NewMsg',
		data:  {fid: $fid, lid: $('#dataHelper').attr('last-id')},
		dataType: 'json',
		success: function(rsp){
				if(parseInt(rsp.status) == 0){
					//alert(rsp.msg);
				}else if(parseInt(rsp.status) == 1){
					
					$design = '<li class="message-left animated fadeinright delay-1">'+
									'<img alt="" src="<?php echo base_url();?>img/man.png">'+
										'<div class="message">'+
											'<p>'+
												rsp.msg+
											'<p>'+
										'</div>'+
										'<span class="msg-time time-'+rsp.lid+'"></span>'+
								'</li>';			

					//open chat box if not already
					//if($(".chatcontainer").length == 0){
						//showChat(rsp.from);
					//}
								
					$('#cstream').append($design);

					$('.message').emoticonize({
						//delay: 800,
						//animate: false,
						//exclude: 'pre, code, .no-emoticons'
					});
					
					$('.time-'+rsp.lid).livestamp();
					$('#dataHelper').attr('last-id', rsp.lid);
					$(document).scrollTop($(document).height());	
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

            <div class="chat p-20" id="chat">
                <ul id="cstream">
                    
                </ul>
			</div>
        </div>
        <!-- End of Page Contents -->
    <!-- End of Main Container -->
    <div class="meta_holder theme">
    <?php
    if(isset($isSpamUser) && $isSpamUser){?>
    	<div style="background-color:white;height:50px;padding-top:10px;" align="center">Please contact admin to resume your services.</div>
    <?php }else{?>
    <form method="post" id="msenger" action="" onsubmit="return submitMsg();">
        <div class="chat-text-holder theme">
            <div class="left">
            	<input type="hidden" name="fid" id="fid" value="<?php echo $list_id;?>">
                <textarea class="chat-text-box" placeholder="Type a message" name="msg" id="msg-min"></textarea>
            </div>
            <div class="right">
                <!-- input type="submit" class="send-button theme ion-android-send" value="" id="sb-mt" /-->
                <button class="theme" id="sb-mt" style="border:0px;padding:0 0 0 10px;margin:-2px;height:0px;" onclick="return submitMsg();">
                <i class="ion-android-send" style="font-size:2.4em;color:white;"></i>
                </button>
            </div>
            <div id="dataHelper" last-id=""></div>
        </div>
        </form>
        <?php }?>
    </div>

    <!-- Scripts -->
    
    <script src="<?php echo base_url();?>js/helper.js"></script>
    <script src="<?php echo base_url();?>js/vendor/HeadsUp.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.smoothState.js"></script>
    <script src="<?php echo base_url();?>js/vendor/chart.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.mixitup.min.js"></script>
    <!--  script src="<?php echo base_url();?>js/vendor/masonry.min.js"></script-->
    <script src="<?php echo base_url();?>js/vendor/materialize.min.js"></script>
    <script src="<?php echo base_url();?>js/main.js"></script>
    <script src="<?php echo base_url();?>js/chat/moment.min.js"></script>
	<script src="<?php echo base_url();?>js/chat/livestamp.js"></script>
	<script src="<?php echo base_url();?>js/chat/jquery.cssemoticons.min.js" type="text/javascript"></script>
	<script>
	getOldChat(<?php echo $this->session->userdata('listenerid');?>);

	_pcq.push(['APIReady', saveSubscriberID]);
	if(isMobile.any){
		var isMobile = 1;
	}else{
		var isMobile = 0;
	}
	
	function saveSubscriberID() {
		if(pushcrew.subscriberId && pushcrew.subscriberId != -1){
			$.ajax({
				type: 'post',
				url: '<?php echo base_url();?>crons/pushnotification/upsertNotificationUser',
				data:  {subid: pushcrew.subscriberId, d_type: isMobile},
				//dataType: 'json',
				success: function(rsp){
						if(rsp == 1){
							console.log('saved');
						}else {
							console.log('err');
						}
					}
			});
			}  
	}
	</script>
    
</body>

</html>
