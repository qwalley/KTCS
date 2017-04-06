<?php 
    class ReservationModel {

		const addReservationSQL =
        	'INSERT INTO Reservation VALUES
        		(NULL, :VIN, :memberID, :startDate, "123456", :reservationLength)';

        const availableCarsSQL =
			"SELECT distinct Car.VIN, Car.make, Car.model, Car.modelYear
				FROM Car INNER JOIN Reservation on Car.VIN = reservation.VIN
				WHERE reservation.date != CURDATE() and Car.lotNO = '1'";

		const lotCarsSQL =
			'SELECT lotcars.*
				FROM(SELECT *
				FROM Car
				WHERE lotNo = :lotNo) AS lotcars
				LEFT JOIN(SELECT *
				FROM Reservation
				WHERE startDate >= :startDate AND startDate <= :startDate + :reservationLength OR startDate + reservationLength >= 
				:startDate AND startDate + reservationLength <= :startDate + :reservationLength) as resConflicts
				ON lotcars.VIN = resConflicts.VIN
				WHERE IFNULL(resConflicts.VIN, 0) = 0';

		const lotSQL =
			'SELECT *
				FROM ParkingLocation
				WHERE lotNo = :lotNo';

        public function addReservation ($VIN, $memberID, $startDate, $reservationLength) {
        	 $db = Database::getInstance();
        	 $query = $db->prepare(ReservationModel::addReservationSQL);

        	 $query->execute(array(':VIN' => $VIN, ':memberID' => $memberID, ':startDate' => $startDate, ':reservationLength' => $reservationLength));

        	 return true;
        }

		public function lotCars($lotNo, $date, $length){
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(ReservationModel::lotCarsSQL);
			$cars = NULL;

			$query->execute(array(':lotNo' => $lotNo, ':startDate' => $date, ':reservationLength' => $length));

			foreach($query->fetchAll() as $car) {
        		$cars[] = new Car($car['VIN'], $car['make'], $car['model'], $car['modelYear'], $car['dailyFee'], $car['lotNo']);
      		}

			return $cars;
		}

		public function getLot($lotNo){
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(ReservationModel::lotSQL);
			$lot = NULL;

			$query->execute(array(':lotNo' => $lotNo));
			$res = $query->fetch();

			$lot = new Lot($res['lotNo'], $res['address'], $res['postalCode'], $res['city'], $res['country'], $res['numSpaces']);

			return $lot;
		}
	}
?>