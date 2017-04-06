<!-- filename: pages_controller.php -->
<!-- authors: Will Alley -->
<?php
	class PagesController {

		private function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		// define actions that belong to this controller
		public function home () {
			// render view
			require_once('views/pages/home_view.php');
		}

		public function error () {
			// when a request is made for a page that does not exist
			require_once('views/pages/error_view.php');
		}

// ==============================================================================
// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< admin actions >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ==============================================================================
		
		public function commentresponse () {

			
			require_once('views/pages/admin_pages/comment_response.php');
		}

		public function rental () {
			$lotNo_failed= "";
			$cars = NULL;
			$result_message = "";

			require_once('views/pages/rental_view.php');
		}

		public function userinvoice () {

			require_once('views/pages/admin_pages/user_invoice.php');
		}

		public function fleet() {
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$cars = $mincar = $maxcar = NULL;
			$result_message = "";

			require_once('views/pages/admin_pages/fleet_maintenance.php');
		}

		public function customer() {
			$memberID_failed = $monthStart_failed = $monthEnd_failed = $commentNo_failed = $response_failed = "";
			$result_message = "";
			
			require_once('views/pages/admin_pages/customer_service.php');
		}
		
		public function records() {
			$VIN_failed = $date_failed = $lotNo_failed = "";
			$result_message = "";
			$cars = $rh = $reservations = NULL;

			require_once('views/pages/admin_pages/records.php');
		}

// ==============================================================================
// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< user actions >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ==============================================================================

		public function dropoff () {
			$odometer_failed = $status_failed = '';
			$odometer = $status = '';
			$success = $valid = false;
			// check for user_info
			if (isset($_SESSION['user_info'])) {
				$user_info = $_SESSION['user_info'];
				// check for dropoff
				if ($user_info['dropoff'] != '') {
					$dropoff = $user_info['dropoff'];
				}
			}

			// handle form submissions
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// validate fields
				if (empty($_POST['odometer'])) {
					$odometer_failed = "required field";
				}
				else {
					$odometer = $_POST['odometer'];
				}
				if (empty($_POST['odometer'])) {
					$odometer_failed = "required field";
				}
				else {
					$status = $_POST['status'];
				}
				// if fields are proper
				if ($odometer_failed == '' && $status_failed == '') {
					$valid = true;
					// instantiate the rental model to access neessary queries
					require_once('models/rental_model.php');
					$rental = new RentalModel(Database::getInstance());
					// run dropoff query
					if ($rental->dropoff($dropoff['VIN'], $user_info['ID'], $dropoff['pickup'], $odometer, $status, $dropoff['resNO'])) {
						$_SESSION['user_info']['dropoff'] = '';
						$_SESSION['user_info']['reservation'] = 'none';
						$success = true;
					}
				}
			}
			require_once('views/pages/dropoff_view.php');
		}

		public function pickup () {
			$odometer_failed = $status_failed = '';
			$odometer = $status = '';
			$success = $valid = false;
			// check for user_info
			if (isset($_SESSION['user_info'])) {
				$user_info = $_SESSION['user_info'];
				// check for dropoff
				if ($user_info['pickup'] != '') {
					$pickup = $user_info['pickup'];
				}
			}

			// handle form submissions
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// validate fields
				if (empty($_POST['odometer'])) {
					$odometer_failed = "required field";
				}
				else {
					$odometer = $_POST['odometer'];
				}
				if (empty($_POST['odometer'])) {
					$odometer_failed = "required field";
				}
				else {
					$status = $_POST['status'];
				}
				// if fields are proper
				if ($odometer_failed == '' && $status_failed == '') {
					$valid = true;
					// instantiate the rental model to access neessary queries
					require_once('models/rental_model.php');
					require_once('models/login_model.php');
					$rental = new RentalModel(Database::getInstance());
					$login = new login_model(Database::getInstance());
					// run pickup query
					if ($rental->pickup($pickup['VIN'], $user_info['ID'], $odometer, $status, $pickup['length'])) {
						$success = true;
						$_SESSION['user_info']['pickup'] = '';
						$dropoff = $login->checkDropoff($user_info['ID']);
						$_SESSION['user_info']['dropoff'] = $dropoff;
						if ($dropoff != '') {
							$_SESSION['user_info']['reservation'] = 'dropoff';
						}
						else {
							$_SESSION['user_info']['reservation'] = 'none';
						}
					}
				}
			}
			require_once('views/pages/pickup_view.php');
		}

		public function reserve () {
			$length_failed = $date_failed = $lotNo_failed = "";
			$result_message = $success = "";
			$cars = $rh = $reservations = NULL;

			$lotNo = $date = $length = "";
			$validquery = true;

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				require_once('models/ReservationModel.php');
			  	$lotNo = PagesController::test_input($_POST["lotNo"]);

				if(empty($_POST["startDate"])){
					$date_failed = "Required Field";
					$validquery = false;
				}
				else {
					$date = $_POST['startDate'];
				}
				if(empty($_POST["length"])){
					$length_failed = "Required Field";
					$validquery = false;
				}
				else {
					$length = $_POST['length'];
				}
			}
			else{
				$validquery = false;
			}
			
			$lot = ReservationModel::getLot($lotNo);

			if($validquery){
				$user_info = $_SESSION['user_info'];
				$success = ReservationModel::addReservation($_POST['VIN'], $user_info['ID'], $date, $length);
				$result_message = "reservation made!";
			}
			require_once('views/pages/rental_view.php');
		}

		public function lotcars() {
			require_once('models/ReservationModel.php');
			require_once('controllers/admin_controller.php');
			$date_failed = $length_failed = "";
			$result_message = "";
			$cars = NULL;

			$lotNo = $date = $length = "";
			$validquery = true;

			if($_SERVER["REQUEST_METHOD"] == "POST"){
			  	$lotNo = PagesController::test_input($_POST["lotNo"]);

				if(empty($_POST["startDate"])){
					$date_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$date = PagesController::test_input($_POST["startDate"]);
				}
				if(empty($_POST["length"])){
					$length_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$length = PagesController::test_input($_POST["length"]);
				}
			}
			else if($_SERVER["REQUEST_METHOD"] == "GET"){
				$lotNo = PagesController::test_input($_GET['lotNo']);
				$date = date("Y-m-d");
				$length = '1';
			}
			else{
				$validquery = false;
			}

			$lot = ReservationModel::getLot($lotNo);

			if($validquery){
				$cars = ReservationModel::lotcars($lotNo, AdminController::normalize_date($date), $length);

				if(count($cars) == 0){
					$result_message = "There are no cars in that lot over that time period.";
				}
			}
			require_once('views/pages/rental_view.php');
		}

		public function login () {
			$email = $password = "";
			$email_failed = $password_failed = $name_failed = $phone_failed = $liscenseNO_failed =
			$address_failed = $postal_failed = $city_failed = $country_failed = "";
			$login_failed = $register_failed = '';
			
			// check if POST was made
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// handle login attempts
				require_once('models/login_model.php');
				$login = $session_info = '';
				// check validity of user inputs
				if (empty($_POST["email"])) {
					$email_failed = "required field";
				}
				else {
			  		$email = test_input($_POST["email"]);
				}
				if (empty($_POST["password"])) {
					$password_failed = "required field";
				}
				else {
			  		$password = test_input($_POST["password"]);
				}
				// if login inputs are OK verify credentials
				if ($email_failed == "" && $password_failed == "") {
					// hash the password
					// authenticate login
					$login = new login_model(Database::getInstance());
					$session_info = $login->verify_login($email, $password);
					// check returned value
					if ($session_info['ID'] == '') {
						// print an error message
						$login_failed = 'The information you entered was incorrect';
					}
					else {
						// successfull login
						// load user data into $_SESSION
						$_SESSION['user_info'] = $session_info;
						die('<script type="text/javascript">window.location.href="?controller=pages&action=home";</script>');
					}
				}
			}
			require_once('views/pages/login_view.php');
		} // end login
		public function logout () {
			// delete fields in $_SESSION
			session_unset();
			// end the session
			session_destroy();
			// redirect to home page
			die('<script type="text/javascript">window.location.href="?controller=pages&action=home";</script>');
		} // end logout
		public function register () {
			$name = $phone = $email = $password = $liscenseNO = 
			$address = $postal = $city = $country = "";
			$email_failed = $password_failed = $name_failed = $phone_failed = $liscenseNO_failed =
			$address_failed = $postal_failed = $city_failed = $country_failed = "";
			$login_failed = $register_failed = '';
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// check validity of user inputs
				if (empty($_POST["name"])) {
					$name_failed = "required field";
				}
				else {
			  		$name = test_input($_POST["name"]);
				}
				if (empty($_POST["phone"])) {
					$phone_failed = "required field";
				}
				else {
			  		$phone = test_input($_POST["phone"]);
				}
				if (empty($_POST["email"])) {
					$email_failed = "required field";
				}
				else {
			  		$email = test_input($_POST["email"]);
				}
				if (empty($_POST["password"])) {
					$password_failed = "required field";
				}
				else {
			  		$password = test_input($_POST["password"]);
				}
				if (empty($_POST["liscenseNO"])) {
					$liscenseNO_failed = "required field";
				}
				else {
			  		$liscenseNO = test_input($_POST["liscenseNO"]);
				}
				if (empty($_POST["address"])) {
					$address_failed = "required field";
				}
				else {
			  		$address = test_input($_POST["address"]);
				}
				if (empty($_POST["postal"])) {
					$postal_failed = "required field";
				}
				else {
			  		$postal = test_input($_POST["postal"]);
				}
				if (empty($_POST["city"])) {
					$city_failed = "required field";
				}
				else {
			  		$city = test_input($_POST["city"]);
				}
				if (empty($_POST["country"])) {
					$country_failed = "required field";
				}
				else {
			  		$country = test_input($_POST["country"	]);
				}
				// if login inputs are OK verify credentials
				if ($email_failed == "" && $password_failed == "" && $name_failed == "" && $phone_failed == "" && $liscenseNO_failed == "" &&
					$address_failed == "" && $postal_failed == "" && $city_failed == "" && $country_failed == "") {
					// hash the password
					// require proper model
					require_once('models/register_model.php');
					$register = new register_model(Database::getInstance());
					if ($register->register_user($name, $phone, $email, $password, $liscenseNO, $address, $postal, $city, $country)){
						require_once('models/login_model.php');
						// log the newly crate user in
						$login = new login_model(Database::getInstance());
						$session_info = $login->verify_login($email, $password);
						// check returned value
						if ($session_info['ID'] == '') {
							// print an error message
							$register_failed = 'There is a login something wrong with the server, please try again later';
						}
						else {
							// successfull login
							// load user data into $_SESSION
							$_SESSION['user_info'] = $session_info;
							// redirect to home page
							header('Location: ?controller=pages&action=home');
							die();
						}
					}
					// if adding user fails
					$register_failed = 'There is something wrong with the server, please try again later';
				}
				// render view
				require_once('views/pages/login_view.php');
			}
		} // end register_user
	}
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>