<!-- filename: comment_response.php-->
<!-- authors: Owen Westland -->

<div id="comment_response_view">
	<p>Respond to a comment:</p>
	<form method="post" action="?controller=admin&action=commentresponse">
		Comment Number <input type="number" min="0" step="1" name="commentNo">
		<span class="error"><?php echo $commentNo_failed ?></span>
		<br>
		Response <input type="text" name="response">
		<span class="error"><?php echo $response_failed ?></span>
		<br>
		<input type="submit" value="Respond">
        <p><?php echo $response_message ?></p>
	</form>
</div>