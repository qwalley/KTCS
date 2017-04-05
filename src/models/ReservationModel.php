<?php 
    class ReservationModel {

		const addReservation =
        	'INSERT INTO Reservation VALUES
        		(NULL, :VIN, :memberID, :startDate, :reservationLength, "123456")';

        const availableCarsSQL =
			"SELECT distinct Car.VIN, Car.make, Car.model, Car.modelYear
				FROM Car INNER JOIN Reservation on Car.VIN = reservation.VIN
				WHERE reservation.date != CURDATE() and Car.lotNO = '1'";

        public function addReservation ($VIN, $memberID, $startDate, $reservationLength) {
        	 $db = Database::getInstance();
        	 $query = $db->prepare(ReservationModel::addReservationSQL);

        	 $query->execute(array(':VIN' => $VIN, ':memberID' => $memberID, ':startDate' => $startDate, ':reservationLength' => $reservationLength));

        	 return true;
        }
	}
?>