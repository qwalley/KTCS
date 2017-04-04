<!-- filename: lot_cars.php-->
<!-- authors: Owen Westland -->

<div id="lot_cars_view">
	<p>Find all the cars in a lot:</p>
	<form method="post" action="?controller=admin&action=lotcars">
		Lot Number <input type="text" name="lotNo">
		<span class="error"><?php echo $lotNo_failed ?></span>
		<input type="submit" value="Search">
	</form>

	<p><?php echo $result_message ?></p>

	<?php if(count($cars) != 0) { ?>
		<table>
			<tr>
				<th>VIN</th>
				<th>Make</th>
				<th>Model</th>
				<th>Model Year</th>
                <th>Daily Fee</th>
			</tr>

			<?php foreach($cars as $car) { ?>
				<tr>
					<td><?php echo $car->VIN; ?></td>        
					<td><?php echo $car->make; ?></td>        
					<td><?php echo $car->model; ?></td>       
					<td><?php echo $car->modelYear; ?></td>
                    <td><?php echo $car->dailyFee; ?></td>
                </tr>
			<?php } ?>
		</table>
	<?php } ?>

</div>