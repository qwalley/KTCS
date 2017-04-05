<!-- filename: customer_service.php-->
<!-- authors: Owen Westland -->

<div id="customer_service_view">
	<p>Send invoices to members and reply to user comments</p>
	<form method="post" action="?controller=admin&action=userinvoice">
		User Member ID <input type="text" name="memberID">
		<span class="error"><?php echo $memberID_failed ?></span>
        <br>
		Starting Date <input type="date" name="monthStart">
		<span class="error"><?php echo $monthStart_failed ?></span>
        <br>
		End Date <input type="date" name="monthEnd">
		<span class="error"><?php echo $monthEnd_failed ?></span>
        <br>
		<input type="submit" value="Generate">
	</form>
    <form method="post" action="?controller=admin&action=commentresponse">
		Comment Number <input type="number" min="0" step="1" name="commentNo">
		<span class="error"><?php echo $commentNo_failed ?></span>
		<br>
		Response <input type="text" name="response">
		<span class="error"><?php echo $response_failed ?></span>
		<br>
		<input type="submit" value="Respond">
	</form>

	<p><?php echo $result_message ?></p>
</div>