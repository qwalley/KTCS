<!-- filename: rental_view.php-->
<!-- authors: Jack East -->

<style>
	.car-spacing{
		margin-bottom: 5px;
	}
</style>

<div class="row">
	<div class="col-md-12">
		<h2><?php echo "Lot Number: ".$lot->lotNo.", ".$lot->address.", ".$lot->postalCode."" ?></h2>
	</div>
</div>
<div class="row">
	<div class="col-md-5">
		<form method="post" action="?controller=pages&action=lotcars">
			<input type="hidden" name="lotNo" value=<?php echo $lotNo ?>>
			<div class="form-group">
				<label for="l2">Reservation Start</label>
				<span><?php echo $date_failed ?></span>
				<input type="date" name="startDate" class="form-control" id="l2" value=<?php echo $date ?>>
			</div>
			<div class="form-group">
				<label for="l3">Number of Reservation Days</label>
				<span><?php echo $length_failed ?></span>
				<input type="number" min="1" step="1" name="length" class="form-control" id="l3" value=<?php echo $length ?>>
			</div>
			<button type="submit" class="btn btn-default pull-right">Search</button>
		</form>
	</div>

	<div class="col-md-7">
		<?php if(count($cars) != 0) { ?>
			<?php foreach($cars as $car) { ?>
				<div class="row">
					<div class="col-md-12">
						<form class="form-inline" method="post" action="?controller=pages&action=reserve">
							<div class="form-group">
								<label for="l1"><?php echo "The ".$car->modelYear." ".$car->make.' '.$car->model.' for $'.$car->dailyFee." a day" ?></label>
								<input type="hidden" name="VIN" value="<?php echo $car->VIN ?>" class="form-control" id="l1">
							</div>
							<input type="hidden" name="userID" value="<?php echo $_SESSION['user_info']['ID'] ?>">
							<input type="hidden" name="lotNo" value="<?php echo $lotNo ?>">
							<input type="hidden" name="startDate" value="<?php echo $date ?>">
							<input type="hidden" name="length" value="<?php echo $length ?>">
							<button type="submit" class="btn btn-default car-spacing">Reserve</button>
						</form>
					</div>
				</div>
			<?php } ?>	
		<?php } else {?>
			<div class="row">
				<div class="col-md-12">
					<h5>The are no cars in this lot available for the specified time period.</h5>
				</div>
			</div>
		<?php } ?>
	</div>
</div>