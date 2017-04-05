<!-- filename: login_model.php -->
<!-- authors: Will Alley -->
<?php
	class login_model {
			private $db = NULL;
			private $authenticate = NULL;
			private $authSQL = 
				'SELECT memberID, email, password, name, admin
				FROM member
				WHERE email = :email';

			public function __construct($pdo) {
				$this->db = $pdo;
				$this->authenticate = $this->db->prepare($this->authSQL);
			}

			// query DB for email and check psswd from $_POST
			public function verify_login ($email, $password) {
				$success = false;
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
				// prepare return value
				$session_info = array (
					"ID" => '',
					"name" => '',
					"admin" => ''
					);
				// populate with results
				if ($success) {
					$session_info['ID'] = $results[0];
					$session_info['name'] = $results[3];
					$session_info['admin'] = $results[4];
				}
				// else return empty array
				return $session_info;
			} // end verify_login
	}
?>