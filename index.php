<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/forum/SSI.php');
	
	if ($context['user']['is_guest'])
		{
			?>
			<div id="shoutbox">
				<h3>You are viewing our site as a guest, why not <a href="/forum/index.php?action=register">register</a> or <a href="/forum/index.php?action=login">login</a></h3>
			</div>
			<?php
		}
	else
		{	
?>
<script src="https://last-outpost.net/discord-link/jquery.min.js"></script>
<script type="text/javascript">
function refreshMessages()
{
	$.ajax({
		url: 'https://last-outpost.net/discord-link/chat_new.php',
		type: 'GET',
		dataType: 'html'
	})
	.done(function( data ) {
		$('#msgs').html('');
		$('#msgs').html( data );
		setTimeout( refreshMessages, 3000 );
	})
	.fail(function() {
		$('#msgs').html('');
		$('#msgs').prepend('Error retrieving new messages...');
		refreshMessages();
	});
}
window.onload = refreshMessages();
</script>
<script type="text/javascript">
function sendmsg() {
	var shout = $("#shout").val();
	$.post("https://last-outpost.net/discord-link/processmsg_new.php", { shout: shout },
	function(data) {
	$('#shout_msg')[0].reset();
	refreshMessages();
	});
}
</script>
<script type="text/javascript">
	function scrollToBottom(){
		$('#msgs').scrollTop(300);
	}
</script>

<div style="padding:1% 1% 1% 1%;background:rgba(36,36,36,0.6);">
	<div style="padding:1% 1% 1% 1%;background:rgba(0,0,0,0.3);">
		<span id="msgs" style="display:block;overflow:auto;max-height:200px;min-height:200px;display:flex;flex-direction:column-reverse;flex:1;"></span>
		<hr>
		<form id="shout_msg" method="post" action="javascript:sendmsg();" autocomplete="off">
		<input type="text" name="shout" id="shout" value="" placeholder="Why Not Stop And Chat A While" style="width:85%;" required/> <input type="submit" value="Say" style="float: right; width; 5% !important;"/>
		</form>
	</div>
</div>
			<?php
		}
?>
