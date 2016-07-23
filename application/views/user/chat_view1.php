<?php
error_reporting(0);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
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
					$design += '<li class="message-'+(value.clsname == 'm-rply'?'right':'left')+' animated fadeinright">'+
						'<img alt="" src="<?php echo base_url();?>img/man.png">'+
						'<div class="message">'+
							'<p>'+
							value.msg+
							'</p>'+
						'</div>'+
						'<span class="msg-time time-'+value.id+'" data-livestamp="'+((date.getTime() / 1000)+19800)+'"></span>'+
				'</li>';
				
					$('.time-'+value.id).livestamp();
					$('#dataHelper').attr('last-id', value.id);
				});
				
				$('#cstream').prepend($design);
			
				$('.message').emoticonize({
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
            	<input type="hidden" name="fid" id="fid" value="9">
                <textarea class="chat-text-box" placeholder="Type a message" name="msg" id="msg-min"></textarea>
            </div>
            <div class="right">
                <input type="submit" class="send-button" value="" id="sb-mt" />
            </div>
            <div id="dataHelper" last-id=""></div>
        </div>
        </form>
    </div>

    <!-- Scripts -->
    
    <script src="<?php echo base_url();?>js/helper.js"></script>
    <script src="<?php echo base_url();?>js/vendor/HeadsUp.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.smoothState.js"></script>
    <script src="<?php echo base_url();?>js/vendor/chart.min.js"></script>
    <script src="<?php echo base_url();?>js/vendor/jquery.mixitup.min.js"></script>
    <!--  script src="<?php echo base_url();?>js/vendor/masonry.min.js"></script-->
    <script src="<?php echo base_url();?>js/vendor/materialize.min.js"></script>
    <!--  script src="<?php echo base_url();?>js/main.js"></script-->
    <script src="<?php echo base_url();?>js/chat/moment.min.js"></script>
	<script src="<?php echo base_url();?>js/chat/livestamp.js"></script>
	<script src="<?php echo base_url();?>js/chat/jquery.cssemoticons.min.js" type="text/javascript"></script>
	<script>
	getOldChat(9);
	</script>
    
</body>

</html>
