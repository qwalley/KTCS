<!-- filename: profile_model.php -->
<!-- authors: Will Alley -->

<?php
	class ProfileModel {
		private $db = NULL;
		private $profileGet = NULL;
		private $getHistory = NULL;
		private $profileSQL =
		'SELECT email, phoneNO, liscenseNO, monthlyFee, address, postalCode, city, country
		FROM Member
		WHERE memberID = :ID';
		private $historySQL = 
		'SELECT Car.make, Car.model, RentalHistory.pickup, RentalHistory.dropoff, RentalHistory.reservationLength, Car.dailyFee
		FROM RentalHistory NATURAL JOIN Car
		WHERE memberID = :ID AND active = 0';

		public function __construct ($pdo) {
			$this->db = $pdo;
			$this->profileGet = $this->db->prepare($this->profileSQL);
			$this->getHistory = $this->db->prepare($this->historySQL);
		}

		public function getProfile ($ID) {
			$info = '';
			$this->profileGet->execute(array(':ID' => $ID));
			$profile = $this->profileGet->fetch();
			if (!empty($profile)) {
				$info = array('email' => $profile[0], 'phone' => $profile[1], 'liscenseNO' => $profile[2], 'fee' => $profile[3],
					'address' => $profile[4], 'postal' => $profile[5], 'city' => $profile[6], 'country' => $profile[7]);
			}
			return $info;
		}

		public function rentalHistory ($ID) {
			$result = '';
			$this->getHistory->execute(array(':ID' => $ID));
			$history = $this->getHistory->fetchAll();
			if (!empty($history)) {
				$i = 0;
				foreach ($history as $h) {
					$result[$i] = array('make' => $h[0], 'model' => $h[1], 'pickup' => $h[2], 'dropoff' => $h[3], 
						'cost' => $h[4] * $h[5]);
				$i = $i + 1;
				}
			}
			return $result;
		}
	}
?>