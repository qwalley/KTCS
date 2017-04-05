<?php
	class AdminController {

		private function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		public function normalize_date($date) {
			$date = str_replace('-', '', $date);
			return $date;
		}

		public function addcar() {
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$cars = $mincar = $maxcar = NULL;
			$result_message = "";

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
				$result_message = AdminModel::addcar($VIN, $make, $model, $modelYear, $dailyFee, $lotNo);
			}
			require_once('views/pages/admin_pages/fleet_maintenance.php');
    	}

		public function commentresponse() {
			$memberID_failed = $monthStart_failed = $monthEnd_failed = $commentNo_failed = $response_failed = "";
			$result_message = "";

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
					$result_message = "Response submitted successfully.";
				}
				else{
					$result_message = "Failed to submit response.";
				}
			}
			
			require_once('views/pages/admin_pages/customer_service.php');
		}

		public function carreservations() {
			$VIN_failed = $date_failed = $lotNo_failed = "";
			$result_message = "";
			$cars = $rh = $reservations = NULL;
			$fromDate = false;

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
			require_once('views/pages/admin_pages/records.php');
		}

		public function lotcars() {
			$VIN_failed = $date_failed = $lotNo_failed = "";
			$result_message = "";
			$cars = $rh = $reservations = NULL;
			$fromDate = false;

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
			require_once('views/pages/admin_pages/records.php');
		}

		public function datereservations () {
			$VIN_failed = $date_failed = $lotNo_failed = "";
			$result_message = "";
			$cars = $rh = $reservations = NULL;
			$fromDate = true;

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
			require_once('views/pages/admin_pages/records.php');
		}

		public function damagedcars() {
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$cars = $mincar = $maxcar = NULL;
			$result_message = "";

			$cars = AdminModel::damagedcars();

			if(count($cars) == 0){
				$result_message = "There are no damaged cars.";
			}
			else{
				$result_message = "Listed below are all the damaged cars.";
			}

			require_once('views/pages/admin_pages/fleet_maintenance.php');
		}

		public function carhistory() {
			$VIN_failed = $date_failed = $lotNo_failed = "";
			$result_message = "";
			$cars = $rh = $reservations = NULL;
			$fromDate = false;

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
			require_once('views/pages/admin_pages/records.php');
		}

		public function minmaxrentals(){
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$cars = $mincar = $maxcar = NULL;
			$result_message = "";

			$mincar = AdminModel::minmaxrentals(true);
			$maxcar = AdminModel::minmaxrentals(false);

			require_once('views/pages/admin_pages/fleet_maintenance.php');
		}

		public function maintenancecars() {
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$cars = $mincar = $maxcar = NULL;
			$result_message = "";

			$cars = AdminModel::maintenancecars();

			if(count($cars) == 0){
				$result_message = "There are no cars requiring scheduled maintenance.";
			}
			else{
				$result_message = "Listed below are all the cars requiring scheduled maintenance.";
			}

			require_once('views/pages/admin_pages/fleet_maintenance.php');
		}

		public function userinvoice(){
			$memberID_failed = $monthStart_failed = $monthEnd_failed = $commentNo_failed = $response_failed = "";
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
			require_once('views/pages/admin_pages/customer_service.php');
		}

		public function carhr () {
			if(empty($_POST['history'])){
				AdminController::carreservations();
			}
			else{
				AdminController::carhistory();
			}
		}
  	}
?>