<!-- filename: rental_model.php -->
<!-- authors: Will Alley -->

<?php 
	class RentalModel {
		private $db = NULL;
		private $pickupCar = NULL;
		private $dropoffCar = NULL;
		private $delReservation = NULL;
		private $pickupSQL = 
			'INSERT into RentalHistory values
			(:VIN, :ID, NOW(), NULL, :odometer, NULL, :status, NULL, :length, 1)';
		private $dropoffSQL = 
			'UPDATE RentalHistory
			SET dropoff = NOW(), endingOdometer = :odometer, StatusOnReturn = :status, active = 0
			WHERE memberID = :ID AND VIN = :VIN AND pickup = :pickup';
		private $deleteSQL = 
			'DELETE from Reservation
			WHERE reservationNo = :resNO';

		public function __construct ($pdo) {
			$this->db = $pdo;
			$this->pickupCar = $this->db->prepare($this->pickupSQL);
			$this->dropoffCar = $this->db->prepare($this->dropoffSQL);
			$this->delReservation = $this->db->prepare($this->deleteSQL);
		}

		// create rentalHistory row with pickup form data
		public function pickup ($VIN, $ID, $odometer, $status, $length) {
			$success = false;
			// insert values
			if ($this->pickupCar->execute(array(':VIN' => $VIN, ':ID' => $ID, ':odometer' => $odometer, ':status' => $status, ':length' => $length))) {
				$success = true;
			}
			// result bool result
			return $success;
		} // end pickup

		public function dropoff ($VIN, $ID, $pickup, $odometer, $status, $resNO) {
			$success = false;
			// update partial entry
			if ($this->dropoffCar->execute(array(':odometer' => $odometer, ':status' => $status, ':VIN' => $VIN, ':ID' => $ID, ':pickup' => $pickup))) {
				if ($this->delReservation->execute(array(':resNO' => $resNO))) {
					$success = true;
				}
			}
			return $success;
		}
	}
?>