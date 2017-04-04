<!-- filename: date_reservations.php-->
<!-- authors: Owen Westland -->

<div id="date_reservations_view">
	<p>Find all the reservations on a date:</p>
	<form method="post" action="?controller=admin&action=datereservations">
		Date <input type="date" name="date">
		<span class="error"><?php echo $date_failed ?></span>
		<input type="submit" value="Search">
	</form>

	<p><?php echo $result_message ?></p>

	<?php if(count($reservations) != 0) { ?>
		<table>
			<tr>
				<th>VIN</th>
				<th>MemberID</th>
				<th>Access Code</th>
				<th>Reservation Length</th>
			</tr>

			<?php foreach($reservations as $reservation) { ?>
				<tr>        
					<td><?php echo $reservation->VIN; ?></td>
					<td><?php echo $reservation->memberID; ?></td>        
					<td><?php echo $reservation->accessCode; ?></td>       
					<td><?php echo $reservation->reservationLength; ?></td>
				</tr>
			<?php } ?>
		</table>
	<?php } ?>

</div>