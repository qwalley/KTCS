<!-- filename: car_history.php-->
<!-- authors: Owen Westland -->

<div id="car_history_view">
	<p>Find the rental history of a car:</p>
	<form method="post" action="?controller=admin&action=carhistory">
		VIN <input type="text" name="VIN">
		<span class="error"><?php echo $VIN_failed ?></span>
		<input type="submit" value="Search">
	</form>

	<p><?php echo $result_message ?></p>

	<?php if(count($rh) != 0) { ?>
		<table>
			<tr>
				<th>Member ID</th>
				<th>Date</th>
                <th>Starting Odometer</th>
                <th>Ending Odometer</th>
                <th>Status On Return</th>
                <th>Reservation Length</th>
			</tr>

			<?php foreach($rh as $h) { ?>
				<tr>
					<td><?php echo $h->memberID; ?></td>
					<td><?php echo $h->date; ?></td>
					<td><?php echo $h->startingOdometer; ?></td>
					<td><?php echo $h->endingOdometer; ?></td>
					<td><?php echo $h->StatusOnReturn; ?></td>
					<td><?php echo $h->reservationLength; ?></td>
				</tr>
			<?php } ?>
		</table>
	<?php } ?>

</div>