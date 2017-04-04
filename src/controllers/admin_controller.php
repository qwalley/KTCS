<?php
	class AdminController {

		public function __construct() {
		}

		public function addcar() {
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$add_message = "";

    		if (!isset($_GET['VIN']) | !isset($_GET['make']) | !isset($_GET['model']) | !isset($_GET['modelYear']) | !isset($_GET['dailyFee']) | !isset($_GET['lotNo'])) {
    			return call('pages', 'error');
			}

			$response = AdminModel::addcar($_GET['VIN'], $_GET['make'], $_GET['model'], $_GET['modelYear'], $_GET['dailyFee'], $_GET['lotNo']);

      		if($response){
				$add_message = "Car successfully added to fleet.";
			}
			else{
				$add_message = "Failed to add car to the fleet.";
			}
			require_once('views/pages/admin_view.php');
    	}
  	}
?>