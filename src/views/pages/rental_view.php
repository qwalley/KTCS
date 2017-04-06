<!-- filename: rental_view.php-->
<!-- authors: Jack East -->

<div id="lot_cars_view">
	<h2><?php echo "Lot Number: ".$lot->lotNo.", ".$lot->address.", ".$lot->postalCode."" ?></h2>
	<form method="post" action="?controller=pages&action=lotcars">
		<input type="hidden" name="lotNo" value=<?php echo $lotNo ?>>
		<div class="form-group">
			<label for="l2">From:</label>
			<span><?php echo $date_failed ?></span>
			<input type="date" name="startDate" class="form-control" id="l2">
		</div>
		<div class="form-group">
			<label for="l3">for:</label>
			<span><?php echo $length_failed ?></span>
			<input type="number" min="1" step="1" name="length" class="form-control" id="l3">
		</div>
		<button type="submit" class="btn btn-default pull-right">Search</button>
	</form>

	<p><?php 
		echo $result_message;
	?></p>

	<?php if(count($cars) != 0) { ?>
			<?php foreach($cars as $car) { ?>
			<form class="form-inline" method="post" action="?controller=pages&action=reserve">
				<div class="form-group">
					<label for="l1"><?php echo $car->make.' '.$car->model.' '.$car->modelYear.' '.$car->dailyFee ?></label>
					<input type="hidden" name="VIN" value="<?php echo $car->VIN ?>" class="form-control" id="l1">
				</div>
				<div class="form-group">
					<label for="l4"></label>
					<input type="hidden" name="userID" value="<?php echo $_SESSION['user_info']['ID'] ?>" class="form-control" id="l4">
				</div>
					<button type="submit" class="btn btn-default">Reserve</button>
			</form>
			<?php } ?>	
	<?php } ?>

</div>