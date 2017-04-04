<!-- filename: resgister_model.php -->
<!-- authors: Will Alley -->

<?php
	class register_model {
		private $db = NULL;
		private $checkExisting = NULL;
		private $addUser = NULL;
		private $existingSQL = 
			'SELECT email, liscenseNO
			FROM member
			WHERE email = :email or liscenseNO = :liscenseNO';
		private $addSQL = 
			'INSERT into member values
			(NULL, ':name', ':phone', ':email', ':password', '0', ':liscenseNO', '60', ':address', ':postal', ':city', ':country');'

		public function __construct($pdo) {
			$this->db = $pdo;
			$this->checkExisting = $this->db->prepare($this->existingSQL);
			$this->addUser = $this->db->prepare($this->addSQL);
		}

		// attempt to add new user to DB
		public function register_user ($name, $phone, $email, $password, $liscenseNO, $adress, $postal, $city, $country) {
			$results = '';
			$emailExists = true;
			$liscenseNOExists = true;
			$success = false;

			$this->checkExisting->execute(array(':email' => $email, ':liscenseNO' => $liscenseNO));
			$results = $this->checkExisting->fetch();
			// NULL means that the email or liscense has not been registered
			if ($results[0] == NULL) {
				$emailExists = false;
			}
			else if ($results[1] != NULL) {
				$emailExists = false;
			}
			// if neither has been registered proceed
			if (!($emailExists & $liscenseNOExists)) {
				// confirm that insertion succeeded
				if ($this->addUser->execute(array(':name' => $name,':phone' => $phone, ':email' => $email, ':password' => $password,
											'liscenseNO' => $liscenseNO, ':adress' => $adress, ':postal' => $postal, 
											':city' => $city, ':country' => $country))) {
					$success = true;
				}
			}
			return success;
		} // end register_user
	}
?>