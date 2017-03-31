<!-- filename: db_access_controller.php-->
<!-- authors: Will Alley -->

<?php 
	class DBAccessController {
		private $db = NULL;
		private $authenticate = NULL;
		private $authSQL = 
			'SELECT memberID, email, password
			FROM member
			WHERE email = :email';

		public function __construct($pdo) {
			$this->db = $pdo;
			$this->authenticate = $this->db->prepare($this->authSQL);
		}

		// query DB for email and check psswd from $_POST
		public function verify_login () {
			$email = $password = "";
			$success = false;
			// verify that controller/action was called properly
			if (isset($_GET['email']) & isset($_GET['password'])) {
				$email = $_GET['email'];
				$password = $_GET['password'];
			}
			else {
				echo "ERROR: email and password are not set in $_GET";
			}
			// query DB
			$this->authenticate->execute(array(':email' => $email));
			// returned as [memberID, email, password]
			// authenticate login info
			$results = $this->authenticate->fetch();
			if (!empty($results)) {
				if ($results[1] == $email & $results[2] == $password) {
					$success = true;
				}
			}
			if ($success) {
				// instantiate session model
				// session_info = session->toArray()
				$session_info = array (
					"ID" => $results[0],
					"email" => $results[1]
					);
				session_start();
				$_SESSION['user_info'] = $session_info;
				header("Location: http://localhost/KTCS/src?controller=pages&action=home");
				die();
			}
			else {
				header("Location: http://localhost/KTCS/src?controller=pages&action=login&attempt=failed");
				die();
			}
		}

		// attempt to add new user to DB
		public function register_user () {
			
		}
	}
?>