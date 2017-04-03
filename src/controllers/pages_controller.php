<!-- filename: pages_controller.php -->
<!-- authors: Will Alley -->

<?php
	class PagesController {

		// define actions that belong to this controller
		public function home () {
			$session = false;
			session_start();
			if (isset($_SESSION['user_info'])) {
				$session = true;
			}
			// render view
			require_once('views/pages/home_view.php');
		}

		public function error () {
			// when a request is made for a page that does not exist
			require_once('views/pages/error_view.php');
		}

		public function admin () {
			$error_message = "";
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$add_message = "";

			require_once('views/pages/admin_view.php');
		}

		public function addcar () {
			$error_message = "";
			$VIN = $make = $model = $modelYear = $dailyFee = $lotNo = "";
			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$add_message = "";
			$validquery = true;

			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST["VIN"])){
					$VIN_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$VIN = test_input($_POST["VIN"]);
				}
				if(empty($_POST["make"])){
					$make_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$make = test_input($_POST["make"]);
				}
				if(empty($_POST["model"])){
					$model_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$model = test_input($_POST["model"]);
				}
				if(empty($_POST["modelYear"])){
					$modelYear_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$modelYear = test_input($_POST["modelYear"]);
				}
				if(empty($_POST["dailyFee"])){
					$dailyFee_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$dailyFee = test_input($_POST["dailyFee"]);
				}
				if(empty($_POST["lotNo"])){
					$lotNo_failed = "Required Field";
					$validquery = false;
				}
				else {
			  		$lotNo = test_input($_POST["lotNo"]);
				}
			}
			else{
				$validquery = false;
			}

			if($validquery){
				header("Location: http://localhost/KTCS-Project/src?controller=admin&action=addcar&VIN=".$VIN."&make=".$make."&model=".$model."&modelYear=".$modelYear."&dailyFee=".$dailyFee."&lotNo=".$lotNo);
				die();
			}

			require_once('views/pages/admin_view.php');
		}

		public function login () {
			$email = $password = $attempt = "";
			$email_failed = $password_failed = $login_failed = "";
			$login_attempt = $failed_attempt = $register_attempt = false;
			
			// check if POST was made
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// determine type of post
				if (isset($_GET['attempt'])) {
					$attempt = $_GET['attempt'];

					if ($_GET['attempt'] == "login") {
						$login_attempt = true;
					}
					else if ($_GET['attempt'] == "failed") {
						$failed_attempt = true;
					}
					else if ($_GET['attempt'] == "register") {
						$register_attempt = true;
					}
				}
			}
			// handle login attempts
			if ($login_attempt) {
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
					header("Location: http://localhost/KTCS-Project/src?controller=db_access&action=verify_login&email=".$email."&password=".$password);
					die();
				}
			}
			else if ($failed_attempt) {
				// TODO make this work
				$login_failed = "Your email or password was incorrect, try again";
			}

			// render view
			require_once('views/pages/login_view.php');
		}

		}
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>