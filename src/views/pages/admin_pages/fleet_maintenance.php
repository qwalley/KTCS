<!-- filename: fleet_maintenance.php-->
<!-- authors: Owen Westland -->

<div id="fleet_maintenance_view">
	<p>View important information on vehicle maintainence and add new vehicles to the fleet</p>
	<form method="post" action="?controller=admin&action=addcar">
		VIN: <input type="text" name="VIN">
		<span class="error"><?php echo $VIN_failed ?></span>
		<br>
		Make: <input type="text" name="make">
		<span class="error"><?php echo $make_failed ?></span>
		<br>
        Model: <input type="text" name="model">
		<span class="error"><?php echo $model_failed ?></span>
		<br>
        Model Year: <input type="number" min="1920" step="1" name="modelYear">
		<span class="error"><?php echo $modelYear_failed ?></span>
		<br>
        Daily Fee: <input type="number" name="dailyFee">
		<span class="error"><?php echo $dailyFee_failed ?></span>
		<br>
        Lot Number: <input type="number" min="0" step="1" name="lotNo">
		<span class="error"><?php echo $lotNo_failed ?></span>
		<br>
		<input type="submit" value="Add Car">
	</form>
    <br>
    <form method="post" action="?controller=admin&action=minmaxrentals">
        Least and Most Used Cars<input type="submit" value="View">
    </form>
    <form method="post" action="?controller=admin&action=maintenancecars">
        Cars In Need of Regular Maintenance<input type="submit" value="View">
    </form>
    <form method="post" action="?controller=admin&action=damagedcars">
        Cars that are currently damaged<input type="submit" value="View">
    </form>

	<p><?php echo $result_message ?></p>

    <?php if($mincar != NULL | $maxcar != NULL) { ?>
        <table>
            <tr>
                <th></th>
                <th>VIN</th>
                <th>Make</th>
                <th>Model</th>
                <th>Model Year</th>
                <th>Daily Fee</th>
                <th>Lot Number</th>
            </tr>
            <tr>
                <td>Least Used</td>
                <td><?php echo $mincar->VIN; ?></td>        
                <td><?php echo $mincar->make; ?></td>        
                <td><?php echo $mincar->model; ?></td>       
                <td><?php echo $mincar->modelYear; ?></td>
                <td><?php echo $mincar->dailyFee; ?></td>
                <td><?php echo $mincar->lotNo; ?></td>
            </tr>
            <tr>
                <td>Most Used</td>
                <td><?php echo $maxcar->VIN; ?></td>        
                <td><?php echo $maxcar->make; ?></td>        
                <td><?php echo $maxcar->model; ?></td>       
                <td><?php echo $maxcar->modelYear; ?></td>
                <td><?php echo $maxcar->dailyFee; ?></td>
                <td><?php echo $maxcar->lotNo; ?></td>
            </tr>
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