<!-- filename: resgister_model.php -->
<!-- authors: Will Alley -->

<?php
	class register_model {
		private $db = NULL;
		private $checkExisting = NULL;
		private $addUser = NULL;
		private $emailSQL = 
			'SELECT email
			FROM member
			WHERE email = :email';
		private $liscenseSQL =
			'SELECT liscenseNO
			FROM member
			WHERE liscenseNO = :liscenseNO'
		private $addSQL = 
			'INSERT into member values
			(NULL, ':name', ':phone', ':email', ':password', '0', ':liscenseNO', '60', ':address', ':postal', ':city', ':country');'

		public function __construct($pdo) {
			$this->db = $pdo;
			$this->checkEmail = $this->db->prepare($this->emailSQL);
			$this->checkLiscense = $this->db->prepare($this->liscenceSQL);
			$this->addUser = $this->db->prepare($this->addSQL);
		}

		// attempt to add new user to DB
		public function register_user ($name, $phone, $email, $password, $liscenseNO, $address, $postal, $city, $country) {
			$result1 = '';
			$result2 = '';
			$emailExists = true;
			$liscenseNOExists = true;
			$success = false;

			$this->checkEmail->execute(array(':email' => $email));
			$result1 = $this->checkExisting->fetch();
			// NULL means that the email  has not been registered
			if ($result1[0] == NULL) {
				$emailExists = false;
			}
			$this->checkLiscense->execute(array(':liscenseNO' => $liscenseNO));
			$result2 = $this->checkLiscense->fetch();
			if ($result2[0] == NULL) {
				$liscenseNOExists = false;
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