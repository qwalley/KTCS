<!-- filename: db_access_controller.php-->
<!-- authors: Will Alley -->

<?php 
	class DBAccessController {

		// query DB for email and check psswd from $_POST
		public function verify_login () {
			$success = false;
			// query DB
			// authenticate login info
			$success = true;
			if ($success) {
				// instantiate session model
				// session_info = session->toArray()
				$session_info = array (
					"name" => "Joe Shmoe",
					"uid" => 101010,
					"email" => "joe.shoe@shmucks.ca"
					);
				session_start();
				$_SESSION['user_info'] = $session_info;
				header("Location: http://localhost/KTCS-project/src?controller=pages&action=home");
			}
		}

		// attempt to add new user to DB
		public function register_user () {
			
		}
	}
?>