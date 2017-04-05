<!-- filename: rental_model.php -->
<!-- authors: Will Alley -->

<?php 
	class RentalModel {
		private $pickupSQL = 
			'INSERT into RentalHistory values
			(:VIN, :ID, NOW(), NULL, :odometer, NULL, :status, NULL, 1)';
		private $dropoffSQL = 
			'UPDATE RentalHistory
			SET dropoff = NOW(), endingOdometer = :odometer, StatusOnReturn = :status, active = 0
			WHERE memberID = :ID, VIN = :VIN, pickup = :pickup';
		private $pickupCar = NULL;
		private $dropoffCar = NULL;

		public function __construct ($pdo) {
			$this->db = $pdo;
			$this->pickupCar = $this->db->prepare($this->pickupSQL);
			$this->dropoffCar = $this->db->prepare($this->dropoffSQL);
		}

		// create rentalHistory row with pickup form data
		public function pickup ($VIN, $ID, $odometer, $status) {
			$success = false;
			// insert values
			if ($this->pickupCar->execute(array(':VIN' => $VIN, ':ID' => $ID, ':odometer' => $odometer, ':status' => $status))) {
				$success = true;
			}
			// result bool result
			return $success;
		} // end pickup

		public function dropoff ($VIN, $ID, $pickup, $odometer, $status) {
			$success = false;
			// update partial entry
			if ($this->dropoffCar->execute(array(':odometer' => $odometer, ':status' => $status, ':VIN' => $VIN, ':ID' => $ID, ':pickup' => $pickup))) {
				$success = true;
			}
			return $success;
		}
	}
?>