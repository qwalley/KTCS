<!-- filename: admin_model.php-->
<!-- authors: Owen Westland -->

<?php 
    class AdminModel {
		const carReservationsSQL = 
			'SELECT *
	            FROM Reservation
	            WHERE VIN = :VIN';

        const lotCarsSQL =
            'SELECT *
	            FROM Car
	            WHERE lotNO = :lotNO';
        
        const dateReservationsSQL =
            'SELECT *
	            FROM Reservation
	            WHERE date = :date';

        const addCarSQL =
            'INSERT INTO Car VALUES
                (:VIN, :make, :model, :modelYear, :dailyFee, :lotNo)';

        const commentResponseSQL =
            'INSERT INTO Response VALUES
	            (NULL, :commentNo, :response)';

		const damagedCarsSQL =
			'SELECT Car.*
				FROM Car INNER JOIN (SELECT lastrental.VIN AS VIN
					FROM (SELECT VIN, MAX(date) AS maxdate
						FROM maintenance
						GROUP BY VIN) AS lastmaintenance
					INNER JOIN (SELECT VIN, MAX(date) AS maxdate
						FROM rentalhistory
						WHERE StatusOnReturn = \'damaged\' OR StatusOnReturn = \'NR\'
						GROUP BY VIN) AS lastrental ON lastmaintenance.VIN = lastrental.VIN
					WHERE lastrental.maxdate > lastmaintenance.maxdate) AS damagedcars ON Car.VIN = damagedcars.VIN';
		
		const userInvoiceSQL =
			'SELECT *
				FROM rentalhistory
				WHERE memberID = :memberID AND date >= :monthStart AND date < :monthEnd';

		const carHistorySQL =
			'SELECT *
				FROM rentalhistory
				WHERE VIN = :VIN';

	    const maxRentalsSQL =
			'SELECT Car.*, MAX(rentalcount.numRentals) AS numRentals
				FROM Car JOIN (SELECT VIN, COUNT(VIN) AS numRentals
				FROM rentalhistory
				GROUP BY VIN) AS rentalcount ON Car.VIN = rentalcount.VIN';

		const minRentalsSQL =
			'SELECT Car.*, MIN(rentalcount.numRentals) AS numRentals
				FROM Car JOIN (SELECT VIN, COUNT(VIN) AS numRentals
				FROM rentalhistory
				GROUP BY VIN) AS rentalcount ON Car.VIN = rentalcount.VIN';

		const maintenanceCarsSQL =
			'SELECT Car.*
				FROM Car INNER JOIN (SELECT lastrental.VIN AS VIN
					FROM (SELECT VIN, odometer, MAX(date) AS maxdate
						FROM maintenance
						GROUP BY VIN) AS lastmaintenance
					INNER JOIN (SELECT VIN, endingOdometer, MAX(date) AS maxdate
						FROM rentalhistory
						GROUP BY VIN) AS lastrental ON lastmaintenance.VIN = lastrental.VIN
					WHERE (lastrental.endingOdometer - lastmaintenance.odometer) >= 5000) AS maintenancecars ON Car.VIN = maintenancecars.VIN';

		public function addcar ($VIN, $make, $model, $modelYear, $dailyFee, $lotNo) {
            $db = Database::getInstance();
            $query = $db->prepare(AdminModel::addCarSQL);

			$query->execute(array(':VIN' => $VIN, ':make' => $make, 'model' => $model, 'modelYear' => $modelYear, 'dailyFee' => $dailyFee, 'lotNo' => $lotNo));

            return true;
		}

        public function commentresponse ($commentNo, $response){
            $db = Database::getInstance();
            $query = $db->prepare(AdminModel::commentResponseSQL);

            $query->execute(array(':commentNo' => $commentNo, ':response' => $response));

            return true;
        }

		public function carreservations ($VIN){
			require_once('reservation.php');
			$db = Database::getInstance();
			$query = $db->prepare(AdminModel::carReservationsSQL);
			$reservations = NULL;

			$query->execute(array(':VIN' => $VIN));

			foreach($query->fetchAll() as $res) {
        		$reservations[] = new Reservation($res['VIN'], $res['memberID'], $res['date'], $res['accessCode'], $res['reservationLength']);
      		}

			return $reservations;
		}
	}
?>