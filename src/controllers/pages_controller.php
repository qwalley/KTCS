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

		public function dropoff () {
			require_once('views/pages/dropoff_view.php');
		}

		public function commentresponse () {

			
			require_once('views/pages/admin_pages/comment_response.php');
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