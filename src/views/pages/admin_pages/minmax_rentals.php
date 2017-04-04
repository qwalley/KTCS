<!-- filename: lot_cars.php-->
<!-- authors: Owen Westland -->

<div id="lot_cars_view">
    <p>The most and least used cars in the fleet</p>
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

</div>