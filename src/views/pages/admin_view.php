<!-- filename: admin_view.php-->
<!-- authors: Owen Westland -->

<div id="admin_view">
	<p>Add a car to fleet:</p>
	<form method="post" action="?controller=pages&action=addcar&attempt=addcar">
		VIN: <input type="text" name="VIN">
		<span class="error"><?php echo $VIN_failed ?></span>
		<br>
		Make: <input type="text" name="make">
		<span class="error"><?php echo $make_failed ?></span>
		<br>
        Model: <input type="text" name="model">
		<span class="error"><?php echo $model_failed ?></span>
		<br>
        Model Year: <input type="number" min="1920" step="1" name="modelYear">
		<span class="error"><?php echo $modelYear_failed ?></span>
		<br>
        Daily Fee: <input type="number" name="dailyFee">
		<span class="error"><?php echo $dailyFee_failed ?></span>
		<br>
        Lot Number: <input type="number" min="0" step="1" name="lotNo">
		<span class="error"><?php echo $lotNo_failed ?></span>
		<br>
		<input type="submit" name="Add Car">
        <p><?php echo $add_message ?></p>
	</form>
</div>