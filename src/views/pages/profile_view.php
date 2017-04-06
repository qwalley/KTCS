<!-- filename: profile_view.php -->
<!-- authors: Will Alley -->

<div class="row">
	<div class="col-md-12">
		<h2 class="page-header"><?php echo $name ?></h2>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<?php 
		echo 
			'<h3>Personal Information</h3>
			<table class="table">
				<tr>
					<td>Email: </td>
					<td>'.$email.'</td>
				</tr>
				<tr>
					<td>Phone Number: </td>
					<td>'.$phone.'</td>
				</tr>
				<tr>
					<td>Driver\'s License: </td>
					<td>'.$liscense.'</td>
				</tr>
				<tr>
					<td>Address: </td>
					<td>'.$address.', '.$city.', '.$postal.', '.$country.'</td>
				</tr>
				<tr>
					<td>You pay: </td>
					<td>'.$fee.'$/month</td>
				</tr>
			</table>';
		?>
	</div>
	<div class="col-md-6">
		<?php
		echo '<h3>Rental History</h3>';
		if ($rental != '') {
			$car = $pickup = $dropoff = $cost = '';
			echo 
				'<table class="table">
					<tr>
						<th>Vehicle</th>
						<th>Picked Up</th>
						<th>Dropped Off</th>
						<th>Cost</th>
					</tr>';
			foreach ($rental as $r) {
				$car = $r['make'].' '.$r['model'];
				$pickup = $r['pickup'];
				$dropoff = $r['dropoff'];
				$cost = $r['cost'];
				echo 
					'<tr>
						<td>'.$car.'</td>
						<td>'.$pickup.'</td>
						<td>'.$dropoff.'</td>
						<td>'.$cost.'</td>
					</tr>';
			}
			echo '</table>';
		}
		else {
			echo '<h4>You have no Rental History to display</h4>';
		}
		?>
	</div>
</div>
