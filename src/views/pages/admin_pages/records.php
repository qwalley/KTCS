<!-- filename: records.php-->
<!-- authors: Owen Westland -->

<style>
	.btn-space{
		margin-right: 10px;
	}
</style>

<div class = "row">
	<div class ="col-md-12">
		<h2>Records:</h2>
	</div>
</div>

<div class = "row">
	<div class = "col-md-5">
		<div class = "row">
			<div class = "col-md-12">
				<form method="post" action="?controller=admin&action=carhr">
					<div class="form-group">
						<label for="l1">Search By VIN</label>
						<span class="error"><?php echo $VIN_failed ?></span>
						<input type="text" name="VIN" class="form-control" id="l1">
					</div>
					<input type="submit" class="btn btn-default pull-right" name="history" value="Show History"/>
					<input type="submit" class="btn btn-default pull-right btn-space" name="reservation" value="Show Reservations"/>
				</form>
			</div>
		</div>
		<div class = "row">
			<div class = "col-md-12">
				<form method="post" action="?controller=admin&action=lotcars">
					<div class="form-group">
						<label for="l1">Search By Lot Number</label>
						<span class="error"><?php echo $lotNo_failed ?></span>
						<input type="text" name="lotNo" class="form-control" id="l1">
					</div>
					<button type="submit" class="btn btn-default pull-right">Show Cars</button>
				</form>
			</div>
		</div>
		<div class = "row">
			<div class = "col-md-12">
				<form method="post" action="?controller=admin&action=datereservations">
					<div class="form-group">
						<label for="l1">Search By Date</label>
						<span class="error"><?php echo $date_failed ?></span>
						<input type="date" name="date" class="form-control" id="l1">
					</div>
					<button type="submit" class="btn btn-default pull-right">Show Reservations</button>
				</form>
			</div>
		</div>
	</div>

	<div class = "col-md-7">
		<h5><?php echo $result_message ?></h5>
		<?php if(count($rh) != 0) { ?>
			<table class = "table">
				<tr>
					<th>Member ID</th>
					<th>PickUp Time</th>
					<th>Dropoff Time</th>
					<th>Travel Distance</th>
					<th>Status On Pickup</th>
					<th>Status On Return</th>
					<th>Reservation Length</th>
				</tr>

				<?php foreach($rh as $h) { ?>
					<tr>
						<td><?php echo $h->memberID; ?></td>
						<td><?php echo $h->pickup; ?></td>
						<td><?php echo $h->dropoff; ?></td>
						<td><?php echo ($h->endingOdometer - $h->startingOdometer); ?></td>
						<td><?php echo $h->StatusOnPickup; ?></td>
						<td><?php echo $h->StatusOnReturn; ?></td>
						<td><?php echo $h->reservationLength; ?></td>				
					</tr>
				<?php } ?>
			</table>
		<?php } ?>

		<?php if(count($reservations) != 0) { ?>
			<table class = "table">
				<tr>
					<?php if($fromDate == true) { ?>
						<th>VIN</th>
					<?php } ?>
					<th>MemberID</th>
					<th>Start Date</th>
					<th>Access Code</th>
					<th>Reservation Length</th>
				</tr>

				<?php foreach($reservations as $reservation) { ?>
					<tr>        
						<?php if($fromDate == true) { ?>
							<td><?php echo $reservation->VIN; ?></td>
						<?php } ?>
						<td><?php echo $reservation->memberID; ?></td>
						<td><?php echo $reservation->startDate; ?></td>
						<td><?php echo $reservation->accessCode; ?></td>       
						<td><?php echo $reservation->reservationLength; ?></td>
					</tr>
				<?php } ?>
			</table>
		<?php } ?>

		<?php if(count($cars) != 0) { ?>
			<table class = "table">
				<tr>
					<th>VIN</th>
					<th>Make</th>
					<th>Model</th>
					<th>Year</th>
					<th>Fee</th>
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

</div>
