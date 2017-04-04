<!-- filename: pages_controller.php -->
<!-- authors: Will Alley -->

<?php
	class PagesController {

		// define actions that belong to this controller
		public function home () {
			// render view
			require_once('views/pages/home_view.php');
		}

		public function error () {
			// when a request is made for a page that does not exist
			require_once('views/pages/error_view.php');
		}

		public function admin () {
			require_once('views/pages/admin_view.php');
		}

		public function addcar () {
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$add_message = "";
			
			require_once('views/pages/admin_pages/add_car.php');
		}

		public function commentresponse () {
			$commentNo_failed = $response_failed = "";
			$response_message = "";
			
			require_once('views/pages/admin_pages/comment_response.php');
		}

		public function carreservations () {
			$VIN_failed = "";
			$result_message = "";
			$reservations = NULL;
			
			require_once('views/pages/admin_pages/car_reservations.php');
		}

		public function lotcars () {
			$lotNo_failed = "";
			$result_message = "";
			$cars = NULL;

			require_once('views/pages/admin_pages/lot_cars.php');
		}

		public function datereservations () {	
			$date_failed = "";
			$result_message = "";
			$reservations = NULL;

			require_once('views/pages/admin_pages/date_reservations.php');
		}

		public function carhistory () {
			$VIN_failed = "";
			$result_message = "";
			$rh = NULL;

			require_once('views/pages/admin_pages/car_history.php');
		}

		public function userinvoice () {
			$memberID_failed = $monthStart_failed = $monthEnd_failed = "";
			$result_message = "";

			require_once('views/pages/admin_pages/user_invoice.php');
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
						// redirect to home page
						header('Location: ?controller=pages&action=home');
						die();
					}
				}
				// render view
				require_once('views/pages/login_view.php');
			}

			// render view
			require_once('views/pages/login_view.php');
		} // end login
		public function logout () {
			// delete fields in $_SESSION
			session_unset();
			// end the session
			session_destroy();
			// redirect to home page
			header('Location: ?controller=pages&action=home');
			die();
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
					$liscenseNO_failed = "required field";
				}
				else {
			  		$liscenseNO = test_input($_POST["liscenseNO"]);
				}
				// if login inputs are OK verify credentials
				if ($email_failed == "" && $password_failed == "" && $name_failed == "" && $phone_failed == "" && $liscenseNO_failed == "" &&
					$address_failed == "" && $postal_failed == "" && $city_failed == "" && $country_failed == "") {
					// hash the password
					$register = new register_model(Database::getInstance());
					if ($register->register_user($email, $password, $attempt, $name, $phone, $liscenseNO, $address, $postal, $city, $country)){
						// log the newly crate user in
						$login = new login_model(Database::getInstance());
						$session_info = $login->verify_login($email, $password);
						// check returned value
						if (empty($session_info)) {
							// print an error message
							$register_failed = 'There is something wrong with the server, please try again later';
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