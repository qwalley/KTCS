<!-- filename: records.php-->
<!-- authors: Owen Westland -->

<div id="records_view">
	<p>Search through the records for information on cars, lots and reservations</p>
	<form method="post" action="?controller=admin&action=carhr">
		VIN <input type="text" name="VIN">
		<span class="error"><?php echo $VIN_failed ?></span>
        <br>
		<input type="submit" value="Show History" name="history">
        <input type="submit" value="Show Reservations" name="reservation">
	</form>
   	<form method="post" action="?controller=admin&action=lotcars">
		Lot Number <input type="text" name="lotNo">
		<span class="error"><?php echo $lotNo_failed ?></span>
		<input type="submit" value="Show Cars">
	</form>
    <form method="post" action="?controller=admin&action=datereservations">
		Date <input type="date" name="date">
		<span class="error"><?php echo $date_failed ?></span>
		<input type="submit" value="Show Reservations">
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
