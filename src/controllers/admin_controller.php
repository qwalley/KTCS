<?php
	class AdminController {

		private function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		private function normalize_date($date) {
			$date = str_replace('-', '', $date);
			return $date;
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

		public function lotcars() {
			$lotNo_failed = "";
			$result_message = "";
			$cars = NULL;

			$lotNo = "";
			$validquery = true;

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST["lotNo"])){
					$VIN_failed = "Required Field";
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
				$cars = AdminModel::lotcars($lotNo);

				if(count($cars) == 0){
					$result_message = "There are no cars in lot ".$lotNo;
				}
				else{
					$result_message = "Listed below are the cars in lot ".$lotNo;
				}
			}
			require_once('views/pages/admin_pages/lot_cars.php');
		}

		public function datereservations () {
			$date_failed = "";
			$result_message = "";
			$reservations = NULL;

			$date = "";
			$validquery = true;

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST["date"])){
					$date_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$date = AdminController::test_input($_POST["date"]);
				}
			}
			else{
				$validquery = false;
			}

			if($validquery){
				$reservations = AdminModel::datereservations(AdminController::normalize_date($date));

				if(count($reservations) == 0){
					$result_message = "There are no reservations on ".$date;
				}
				else{
					$result_message = "Listed below are the reservations on ".$date;
				}
			}
			require_once('views/pages/admin_pages/date_reservations.php');
		}

		public function damagedcars() {
			$result_message = "";
			$cars = NULL;

			$cars = AdminModel::damagedcars();

			if(count($cars) == 0){
				$result_message = "There are no damaged cars.";
			}
			else{
				$result_message = "Listed below are all the damaged cars.";
			}

			require_once('views/pages/admin_pages/dm_cars.php');
		}

		public function carhistory() {
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
				$rh = AdminModel::carhistory($VIN);

				if(count($rh) == 0){
					$result_message = "There is no rental history for the car ".$VIN;
				}
				else{
					$result_message = "Listed below is the rental history for the car ".$VIN;
				}
			}
			require_once('views/pages/admin_pages/car_history.php');
		}

		public function minmaxrentals(){
			$result_message = "";
			$mincar = NULL;
			$maxcar = NULL;

			$mincar = AdminModel::minmaxrentals(true);
			$maxcar = AdminModel::minmaxrentals(false);

			require_once('views/pages/admin_pages/minmax_rentals.php');
		}

		public function maintenancecars() {
			$result_message = "";
			$cars = NULL;

			$cars = AdminModel::maintenancecars();

			if(count($cars) == 0){
				$result_message = "There are no cars requiring scheduled maintenance.";
			}
			else{
				$result_message = "Listed below are all the cars requiring scheduled maintenance.";
			}

			require_once('views/pages/admin_pages/dm_cars.php');
		}

		public function userinvoice(){
			$memberID_failed = $monthStart_failed = $monthEnd_failed = "";
			$result_message = "";

			$memberID = $monthStart = $monthEnd = "";
			$validquery = true;

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST["memberID"])){
					$memberID_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$memberID = AdminController::test_input($_POST["memberID"]);
				}
				if(empty($_POST["monthStart"])){
					$monthStart_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$monthStart = AdminController::test_input($_POST["monthStart"]);
				}
				if(empty($_POST["monthEnd"])){
					$monthEnd_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$monthEnd = AdminController::test_input($_POST["monthEnd"]);
				}
			}
			else{
				$validquery = false;
			}

			if($validquery){
				$result_message = AdminModel::userinvoice($memberID, $monthStart, $monthEnd);
			}
			require_once('views/pages/admin_pages/user_invoice.php');
		}
  	}
?>