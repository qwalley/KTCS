<!-- filename: lot_cars.php-->
<!-- authors: Owen Westland -->

<div id="lot_cars_view">
	<p>Generate an invoice for a user:</p>
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

	<p><?php echo $result_message ?></p>
</div>