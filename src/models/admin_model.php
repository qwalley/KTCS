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
	            WHERE lotNo = :lotNo';
        
        const dateReservationsSQL =
            'SELECT *
				FROM Reservation
				WHERE date >= :date AND date <= :date + reservationLength';

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

		const carHistorySQL =
			'SELECT *
				FROM rentalhistory
				WHERE VIN = :VIN';

	    const maxRentalsSQL =
			'SELECT Car.*
				FROM Car LEFT JOIN (SELECT VIN, IFNULL(COUNT(VIN), 0) AS numRentals
					FROM rentalhistory
					GROUP BY VIN) AS rentalcount ON Car.VIN = rentalcount.VIN
				ORDER BY numRentals DESC
				LIMIT 1';

		const minRentalsSQL =
			'SELECT Car.*
				FROM Car LEFT JOIN (SELECT VIN, IFNULL(COUNT(VIN), 0) AS numRentals
					FROM rentalhistory
					GROUP BY VIN) AS rentalcount ON Car.VIN = rentalcount.VIN
				ORDER BY numRentals
				LIMIT 1';

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
		
		const userInvoiceSQL =
			'SELECT rentalhistory.*, Car.dailyFee
				FROM rentalhistory LEFT JOIN Car ON rentalhistory.VIN = Car.VIN
				WHERE memberID = :memberID AND date >= :monthStart AND date < :monthEnd';

		const userSQL =
			'SELECT *
				FROM member
				WHERE memberID = :memberID';

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
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(AdminModel::carReservationsSQL);
			$reservations = NULL;

			$query->execute(array(':VIN' => $VIN));

			foreach($query->fetchAll() as $res) {
        		$reservations[] = new Reservation($res['VIN'], $res['memberID'], $res['date'], $res['accessCode'], $res['reservationLength']);
      		}

			return $reservations;
		}

		public function lotcars ($lotNo){
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(AdminModel::lotCarsSQL);
			$cars = NULL;

			$query->execute(array(':lotNo' => $lotNo));

			foreach($query->fetchAll() as $car) {
        		$cars[] = new Car($car['VIN'], $car['make'], $car['model'], $car['modelYear'], $car['dailyFee'], $car['lotNo']);
      		}

			return $cars;
		}

		public function datereservations ($date){
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(AdminModel::dateReservationsSQL);
			$reservations = NULL;

			$query->execute(array(':date' => $date));

			foreach($query->fetchAll() as $res) {
        		$reservations[] = new Reservation($res['VIN'], $res['memberID'], $res['date'], $res['accessCode'], $res['reservationLength']);
      		}

			return $reservations;
		}

		public function damagedcars () {
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(AdminModel::damagedCarsSQL);
			$cars = NULL;

			$query->execute();

			foreach($query->fetchAll() as $car) {
        		$cars[] = new Car($car['VIN'], $car['make'], $car['model'], $car['modelYear'], $car['dailyFee'], $car['lotNo']);
      		}

			return $cars;
		}

		public function carhistory ($VIN) {
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(AdminModel::carHistorySQL);
			$rh = NULL;

			$query->execute(array(":VIN" => $VIN));

			foreach($query->fetchAll() as $h) {
        		$rh[] = new RentalHistory($h['VIN'], $h['memberID'], $h['date'], $h['startingOdometer'], $h['endingOdometer'], $h['StatusOnReturn'], $h['reservationLength'], 0);
      		}

			return $rh;
		}

		public function minmaxrentals($min){
			require_once('admin_data.php');
			$db = Database::getInstance();
			$car = NULL;
			if($min == true){
				$query = $db->prepare(AdminModel::minRentalsSQL);
			}
			else{
				$query = $db->prepare(AdminModel::maxRentalsSQL);
			}

			$query->execute();
			$result = $query->fetch();

			$car = new Car($result['VIN'], $result['make'], $result['model'], $result['modelYear'], $result['dailyFee'], $result['lotNo']);

			return $car;
		}

		public function maintenancecars (){
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(AdminModel::maintenanceCarsSQL);
			$cars = NULL;

			$query->execute();

			foreach($query->fetchAll() as $car) {
        		$cars[] = new Car($car['VIN'], $car['make'], $car['model'], $car['modelYear'], $car['dailyFee'], $car['lotNo']);
      		}

			return $cars;
		}

		public function userinvoice ($memberID, $monthStart, $monthEnd){
			require_once('admin_data.php');
			$db = Database::getInstance();
			$historyquery = $db->prepare(AdminModel::userInvoiceSQL);
			$userquery = $db->prepare(AdminModel::userSQL);
			$rh = NULL;
			$total = NULL;
			$user = NULL;
			$invoice = "";

			$headers = 'From: noreply@KTCS.com' . "\r\n" .
    			'Reply-To: noreply@KTCS.com' . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();

			$historyquery->execute(array(":memberID" => $memberID, ":monthStart" => $monthStart, ":monthEnd" => $monthEnd));
			$userquery->execute(array(":memberID" => $memberID));

			foreach($historyquery->fetchAll() as $h) {
        		$rh[] = new RentalHistory($h['VIN'], $h['memberID'], $h['date'], $h['startingOdometer'], $h['endingOdometer'], $h['StatusOnReturn'], $h['reservationLength'], $h['dailyFee']);
      		}
			
			$user = $userquery->fetch();

			if($user == NULL){
				return "Could not find a user with user ID ".$memberID;
			}
			if($rh == NULL | count($rh) == 0){
				return "There is no rental history for user ".$memberID." for the specified time period.";
			}

			$invoice = "Hello ".$user['name'].",\n\tOutlined below is a receipt for your use of the KTCS service:\n\n";
			$invoice = "".$invoice."VIN\t\tDaily Fee\t\tReservation Period\t\tCharge\n";

			foreach($rh as $h){
				$invoice = "".$invoice.$h->VIN."\t\t".$h->dailyFee."\t\t".$h->reservationLength."\t\t".($h->reservationLength*$h->dailyFee)."\n";
				$total = $total + $h->reservationLength*$h->dailyFee;
			}
			$invoice = "".$invoice."Total:\t\t\t\t\t\t".$total;
			$invoice = "".$invoice."\nThank you for your continued patronage.\nRegards,\nThe KTCS Team";

			if(!mail($user['email'], "KTCS Invoice", $invoice, $headers)){
				return "Failed to deliver email. Please check that the user has entered a valid email.";
			}

			return "Invoice sent successfully.";
		}
	}
?>