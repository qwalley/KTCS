<!-- filename: dropoff_view.php -->
<!-- authors: Will Alley -->
<div class="row">
	<div class="col-md-12">
		<h2 class="page-header">Drop Off a Car:</h2>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<h4 class="page-header">You're driving the: </h4>
		<?php 
			if (isset($_SESSION['user_info'])) {
				$user_info = $_SESSION['user_info'];
				echo '<pre>';
				print_r($user_info);
				echo "</pre>";
			}
		?>
		
	</div>
	<div class="col-md-6">
		<form method="post" action="?controller=pages&action=dropoff">
			<div class="form-group">
				<label for="l1">Odometer Reading:</label>
				<span class="error"><?php echo $odometer_failed ?></span>
				<input type="number" name="odometer" class="form-control" id="l1">
			</div>
			<div class="form-group">
				<label for="l2">Status of vehicle:</label>
				<span class="error"><?php echo $status_failed ?></span>
				<input type="text" name="status" class="form-control" id="l2">
			</div>
			<button type="submit" class="btn btn-default">Drop Off!</button>
		</form>
	</div>
</div>