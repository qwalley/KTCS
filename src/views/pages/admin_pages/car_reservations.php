<!-- filename: car_reservations.php-->
<!-- authors: Owen Westland -->

<div id="car_reservations_view">
	<p>Find the reservations for a car:</p>
	<form method="post" action="?controller=admin&action=carreservations">
		VIN <input type="text" name="VIN">
		<span class="error"><?php echo $VIN_failed ?></span>
		<input type="submit" value="Search">
	</form>

	<p><?php echo $result_message ?></p>

	<?php if(count($reservations) != 0) { ?>
		<table>
			<tr>
				<th>MemberID</th>
				<th>Date</th>
				<th>Access Code</th>
				<th>Reservation Length</th>
			</tr>

			<?php foreach($reservations as $reservation) { ?>
				<tr>
					<td><?php echo $reservation->memberID; ?></td>        
					<td><?php echo $reservation->date; ?></td>        
					<td><?php echo $reservation->accessCode; ?></td>       
					<td><?php echo $reservation->reservationLength; ?></td>
				</tr>
			<?php } ?>
		</table>
	<?php } ?>

</div>