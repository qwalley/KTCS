<!-- filename: fleet_maintenance.php-->
<!-- authors: Owen Westland -->

<style>
    .btn-margin{
        width: 100%;
        margin-bottom: 5px;
    }
</style>

<div class = "row">
	<div class ="col-md-12">
		<h2>Fleet Maintenance:</h2>
	</div>
</div>

<div class = "row">
	<div class = "col-md-5">
		<div class = "row">
			<div class = "col-md-12">
                <h3>Add a Car</h3>
                <form method="post" action="?controller=admin&action=addcar">
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="l1">VIN</label>
                                <span class="error"><?php echo $VIN_failed ?></span>
                                <input type="text" name="VIN" class="form-control" id="l1">
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="l1">Make</label>
                                <span class="error"><?php echo $make_failed ?></span>
                                <input type="text" name="make" class="form-control" id="l1">
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="l1">Model</label>
                                <span class="error"><?php echo $model_failed ?></span>
                                <input type="text" name="model" class="form-control" id="l1">
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="l1">Model Year</label>
                                <span class="error"><?php echo $modelYear_failed ?></span>
                                <input type="number" min="1920" step="1" name="modelYear" class="form-control" id="l1">
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="l1">Daily Fee</label>
                                <span class="error"><?php echo $dailyFee_failed ?></span>
                                <input type="number" name="dailyFee" class="form-control" id="l1">
                            </div>
                        </div>
                        <div class = "col-md-6">
                            <div class="form-group">
                                <label for="l1">Lot Number</label>
                                <span class="error"><?php echo $lotNo_failed ?></span>
                                <input type="number" min="0" step="1" name="lotNo" class="form-control" id="l1">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default pull-right">Add Car</button>
                </form>
            </div>
        </div>
        <h3>Fleet Details</h3>
        <div class = "row">
			<div class = "col-md-12">
                <form method="post" action="?controller=admin&action=minmaxrentals">
                    <button type="submit" class="btn btn-default btn-margin">Least And Most Used Cars</button>
                </form>
            </div>
        </div>
        <div class = "row">
			<div class = "col-md-12">
                <form method="post" action="?controller=admin&action=maintenancecars">
                    <button type="submit" class="btn btn-default btn-margin">Cars In Need of Regular Maintenance</button>
                </form>
            </div>
        </div>
        <div class = "row">
			<div class = "col-md-12">
                <form method="post" action="?controller=admin&action=damagedcars">
                    <button type="submit" class="btn btn-default btn-margin">Cars That Are Currently Damaged</button>
                </form>
            </div>
        </div>
    </div>

    <div class = "col-md-7">
		<h5><?php echo $result_message ?></h5>

            <?php if($mincar != NULL | $maxcar != NULL) { ?>
                <table class = "table">
                    <tr>
                        <th></th>
                        <th>VIN</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Fee</th>
                        <th>Lot</th>
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
                <table class = "table">
                    <tr>
                        <th>VIN</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Fee</th>
                        <th>Lot</th>
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
</div>