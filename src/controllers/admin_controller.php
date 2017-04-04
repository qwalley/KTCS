<?php
	class AdminController {

		private function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		public function addcar() {
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$add_message = "";

			$VIN = $make = $model = $modelYear = $dailyFee = $lotNo = "";
			$validquery = true;

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST["VIN"])){
					$VIN_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$VIN = AdminController::test_input($_POST["VIN"]);
				}
				if(empty($_POST["make"])){
					$make_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$make = AdminController::test_input($_POST["make"]);
				}
				if(empty($_POST["model"])){
					$model_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$model = AdminController::test_input($_POST["model"]);
				}
				if(empty($_POST["modelYear"])){
					$modelYear_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$modelYear = AdminController::test_input($_POST["modelYear"]);
				}
				if(empty($_POST["dailyFee"])){
					$dailyFee_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$dailyFee = AdminController::test_input($_POST["dailyFee"]);
				}
				if(empty($_POST["lotNo"])){
					$lotNo_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$lotNo = AdminController::test_input($_POST["lotNo"]);
				}
			}
			else{
				$validquery = false;
			}

			if($validquery){
				$result = AdminModel::addcar($VIN, $make, $model, $modelYear, $dailyFee, $lotNo);

				if($result){
					$add_message = "Car successfully added to fleet.";
				}
				else{
					$add_message = "Failed to add car to the fleet.";
				}
			}
			require_once('views/pages/admin_pages/add_car.php');
    	}

		public function commentresponse() {
			$commentNo_failed = $response_failed = "";
			$response_message = "";

			$commentNo = $response = "";
			$validquery = true;
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST["commentNo"])){
					$VIN_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$commentNo = AdminController::test_input($_POST["commentNo"]);
				}
				if(empty($_POST["response"])){
					$make_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$response = AdminController::test_input($_POST["response"]);
				}
			}
			else{
				$validquery = false;
			}

			if($validquery){
				$result = AdminModel::commentresponse($commentNo, $response);

				if($result){
					$response_message = "Response submitted successfully.";
				}
				else{
					$response_message = "Failed to submit response.";
				}
			}
			
			require_once('views/pages/admin_pages/comment_response.php');
		}

		public function carreservations() {
			$VIN_failed = "";
			$result_message = "";
			$reservations = NULL;

			$VIN = "";
			$validquery = true;

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST["VIN"])){
					$VIN_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$VIN = AdminController::test_input($_POST["VIN"]);
				}
			}
			else{
				$validquery = false;
			}

			if($validquery){
				$reservations = AdminModel::carreservations($VIN);

				if(count($reservations) == 0){
					$result_message = "There are no reservations for the vehicle ".$VIN;
				}
				else{
					$result_message = "Listed below are the reservations for the vehicle ".$VIN;
				}
			}
			require_once('views/pages/admin_pages/car_reservations.php');
		}
  	}
?>