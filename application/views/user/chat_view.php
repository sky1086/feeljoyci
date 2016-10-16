<?php 
error_reporting(0);
$this->load->view('admin/header');
?>
<style>
.theme {
    background-color: rgba(112, 197, 159, 0.8) !important;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>js/mobile.js"></script>
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
    <div class="meta_holder">
    <form method="post" id="msenger" action="" onsubmit="return submitMsg();">
        <div class="chat-text-holder">
            <div class="left">
            	<input type="hidden" name="fid" id="fid" value="<?php echo $toid;?>">
                <textarea class="chat-text-box" placeholder="Type a message" name="msg" id="msg-min"></textarea>
            </div>
            <div class="right">
                <button class="theme" id="sb-mt" style="border:0px;padding:0 0 0 10px;margin:0px;height:50px;" onclick="return submitMsg()">
                <i class="ion-android-send" style="font-size:2.4em;color:white;"></i>
                </button>
            </div>
            <div id="dataHelper" last-id=""></div>
        </div>
        </form>
    </div>

    <!-- Scripts -->
    
   
    <script src="<?php echo base_url();?>js/chat/moment.min.js"></script>
	<script src="<?php echo base_url();?>js/chat/livestamp.js"></script>
	<script src="<?php echo base_url();?>js/chat/jquery.cssemoticons.min.js" type="text/javascript"></script>
   
    <script>
		getOldChat(<?php echo $toid;?>);
	</script>
	
<?php $this->load->view('admin/footer');?>