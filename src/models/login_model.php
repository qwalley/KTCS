<!-- filename: login_model.php -->
<!-- authors: Will Alley -->
<?php
	class login_model {
			private $db = NULL;
			private $authenticate = NULL;
			private $getPickup = NULL;
			private $getDropoff = NULL;
			
			private $authSQL = 
				'SELECT memberID, email, password, name, admin
				FROM member
				WHERE email = :email';

			private $pickupSQL = 
				'SELECT VIN, make, model, lotNo, accessCode, reservationLength 
				FROM Reservation NATURAL JOIN Car 
				WHERE memberID = :ID AND startDate = CURDATE()';

			private $dropoffSQL = 
				'SELECT reserved.VIN, reserved.make, reserved.model, reserved.lotNo, RentalHistory.pickup, reserved.reservationNo
				FROM RentalHistory JOIN (SELECT *
				FROM Reservation NATURAL JOIN Car) AS reserved
				ON RentalHistory.VIN = reserved.VIN AND RentalHistory.memberID = reserved.memberID
				WHERE RentalHistory.active = 1 AND RentalHistory.memberID = 1';

			public function __construct($pdo) {
				$this->db = $pdo;
				$this->authenticate = $this->db->prepare($this->authSQL);
				$this->getPickup = $this->db->prepare($this->pickupSQL);
				$this->getDropoff = $this->db->prepare($this->dropoffSQL);
			}

			public function checkDropoff ($ID) {
				// check for dropoffs
				$this->getDropoff->execute(array(':ID' => $ID));
				$dropoff = $this->getDropoff->fetch();
				$dropoffData = '';

				if (!empty($dropoff)) {
					// set reservation type in session
					$dropoffData = array('VIN' => $dropoff[0], 'make' => $dropoff[1], 
						'model' => $dropoff[2], 'lot' => $dropoff[3], 'pickup' => $dropoff[4], 'resNO' => $dropoff[5]);
				}
				return $dropoffData;
			}

			// query DB for email and check psswd from $_POST
			public function verify_login ($email, $password) {
				$success = false;
				// query DB
				$this->authenticate->execute(array(':email' => $email));
				// returned as [memberID, email, password]
				// authenticate login info
				$results = $this->authenticate->fetch();
				//if query succeeded
				if (!empty($results)) {
					// if results match user input
					if ($results[1] == $email & $results[2] == $password) {
						$success = true;
						// chceck for pickups 
						$this->getPickup->execute(array(':ID' => $results[0]));
						$pickup = $this->getPickup->fetch();
						// check for dropoffs
						$this->getDropoff->execute(array(':ID' => $results[0]));
						$dropoff = $this->getDropoff->fetch();
					}
				}
				// prepare return value
				$session_info = array (
					"ID" => '',
					"name" => '',
					"admin" => '',
					"reservation" => 'none',
					"pickup" => '',
					"dropoff" => ''
					);
				// populate with results
				if ($success) {
					$session_info['ID'] = $results[0];
					$session_info['name'] = $results[3];
					$session_info['admin'] = $results[4];
				}
				if (!empty($pickup)) {
					// set reservation in session
					$session_info['reservation'] = 'pickup';
					$session_info['pickup'] = array('VIN' => $pickup[0], 'make' => $pickup[1], 
						'model' => $pickup[2], 'lot' => $pickup[3], 'code' => $pickup[4], 'length' => $pickup[5]);
				}
				else if (!empty($dropoff)) {
					// set reservation type in session
					$session_info['reservation'] = 'dropoff';
					$session_info['dropoff'] = array('VIN' => $dropoff[0], 'make' => $dropoff[1], 
						'model' => $dropoff[2], 'lot' => $dropoff[3], 'pickup' => $dropoff[4], 'resNO' => $dropoff[5]);
				}
				// else return empty array
				return $session_info;
			} // end verify_login
	}
?>