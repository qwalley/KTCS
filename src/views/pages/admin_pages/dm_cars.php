<!-- filename: dm_cars.php-->
<!-- authors: Owen Westland -->

<div id="dm_cars_view">

	<p><?php echo $result_message ?></p>

	<?php if(count($cars) != 0) { ?>
		<table>
			<tr>
				<th>VIN</th>
				<th>Make</th>
				<th>Model</th>
				<th>Model Year</th>
                <th>Daily Fee</th>
                <th>Lot Number</th>
			</tr>

			<?php foreach($cars as $car) { ?>
				<tr>
					<td><?php echo $car->VIN; ?></td>        
					<td><?php echo $car->make; ?></td>        
					<td><?php echo $car->model; ?></td>       
					<td><?php echo $car->modelYear; ?></td>
                    <td><?php echo $car->dailyFee; ?></td>
                    <td><?php echo $car->lotNo; ?></td>
                </tr>
			<?php } ?>
		</table>
	<?php } ?>

</div>