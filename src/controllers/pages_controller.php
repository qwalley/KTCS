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
					header("Location: http://localhost/KTCS/src?controller=db_access&action=verify_login&email=".$email."&password=".$password);
					die();
				}
			}
			else if ($failed_attempt) {
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