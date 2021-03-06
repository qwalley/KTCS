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
				WHERE startDate <= :startDate AND startDate + reservationLength >= :startDate';

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
					INNER JOIN (SELECT VIN, MAX(dropoff) AS maxdate
						FROM rentalhistory
						WHERE StatusOnReturn = \'damaged\' OR StatusOnReturn = \'NR\'
						GROUP BY VIN) AS lastrental ON lastmaintenance.VIN = lastrental.VIN
					WHERE lastrental.maxdate > lastmaintenance.maxdate) AS damagedcars ON Car.VIN = damagedcars.VIN';

		const carHistorySQL =
			'SELECT *
				FROM rentalhistory
				WHERE VIN = :VIN AND active = \'0\'';

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
					FROM (SELECT VIN, MAX(odometer) AS maxod
						FROM maintenance
						GROUP BY VIN) AS lastmaintenance
					INNER JOIN (SELECT VIN, MAX(endingOdometer) AS maxod
						FROM rentalhistory
						GROUP BY VIN) AS lastrental ON lastmaintenance.VIN = lastrental.VIN
						WHERE (lastrental.maxod - lastmaintenance.maxod) >= 5000) AS maintenancecars ON Car.VIN = maintenancecars.VIN';
		
		const userInvoiceSQL =
			'SELECT rentalhistory.*, Car.dailyFee
				FROM rentalhistory LEFT JOIN Car ON rentalhistory.VIN = Car.VIN
				WHERE memberID = :memberID AND pickup >= :monthStart AND pickup < :monthEnd';

		const userSQL =
			'SELECT *
				FROM member
				WHERE memberID = :memberID';

		const carSQL =
			'SELECT *
				FROM Car
				WHERE VIN = :VIN';

		const lotLimitSQL =
			'SELECT lot.numSpaces AS numSpaces, count.numCars AS numCars
				FROM (SELECT lotNo, COUNT(VIN) AS numCars
				FROM Car
				WHERE lotNo = :lotNo
				GROUP BY lotNo) AS count
				INNER JOIN(SELECT lotNo, numSpaces
				FROM ParkingLocation
				WHERE lotNo = :lotNo) AS lot
				ON lot.lotNo = count.lotNo';

		public function addcar ($VIN, $make, $model, $modelYear, $dailyFee, $lotNo) {
            $db = Database::getInstance();
			$checkquery = $db->prepare(AdminModel::lotLimitSQL);
            $query = $db->prepare(AdminModel::addCarSQL);
			$check = NULL;

			$checkquery->execute(array(':lotNo' => $lotNo));
			$check = $checkquery->fetch();

			if(empty($check) | ($check['numSpaces'] > $check['numCars'])){
				$query->execute(array(':VIN' => $VIN, ':make' => $make, 'model' => $model, 'modelYear' => $modelYear, 'dailyFee' => $dailyFee, 'lotNo' => $lotNo));
				return "Car successfully added to fleet.";
			}
			else{
            	return "Car not added. Lot ".$lotNo." is full.";
			}
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
        		$reservations[] = new Reservation($res['VIN'], $res['memberID'], $res['startDate'], $res['accessCode'], $res['reservationLength']);
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

		public function datereservations ($startDate){
			require_once('admin_data.php');
			$db = Database::getInstance();
			$query = $db->prepare(AdminModel::dateReservationsSQL);
			$reservations = NULL;

			$query->execute(array(':startDate' => $startDate));

			foreach($query->fetchAll() as $res) {
        		$reservations[] = new Reservation($res['VIN'], $res['memberID'], $res['startDate'], $res['accessCode'], $res['reservationLength']);
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
        		$rh[] = new RentalHistory($h['VIN'], $h['memberID'], $h['pickup'], $h['dropoff'], $h['startingOdometer'], $h['endingOdometer'], $h['StatusOnPickup'], $h['StatusOnReturn'], $h['reservationLength'], $h['active'], 0);
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
			$carquery = $db->prepare(AdminModel::carSQL);
			$rh = NULL;
			$total = NULL;
			$user = NULL;
			$cars = NULL;
			$count = 0;
			$invoice = "";

			$headers = 'From: noreply@KTCS.com' . "\r\n" .
    			'Reply-To: noreply@KTCS.com' . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();

			$historyquery->execute(array(":memberID" => $memberID, ":monthStart" => $monthStart, ":monthEnd" => $monthEnd));
			$userquery->execute(array(":memberID" => $memberID));

			foreach($historyquery->fetchAll() as $h) {
				if($h['active'] != '1'){
					$rh[] = new RentalHistory($h['VIN'], $h['memberID'], $h['pickup'], $h['dropoff'], $h['startingOdometer'], $h['endingOdometer'], $h['StatusOnPickup'], $h['StatusOnReturn'], $h['reservationLength'], $h['active'], $h['dailyFee']);
					$carquery->execute(array(":VIN" => $h['VIN']));
					$cars[] = $carquery->fetch();
				}
      		}
			
			$user = $userquery->fetch();

			if($user == NULL){
				return "Could not find a user with user ID ".$memberID;
			}
			if($rh == NULL | count($rh) == 0){
				return "There is no rental history for user ".$memberID." for the specified time period.";
			}

			$invoice = "Hello ".$user['name'].",\n\tOutlined below is a receipt for your use of the KTCS service:\n\n";

			$invoice = "".$invoice."\t\t\tDaily Fee\tReservation Period\t\tCharge\t\tCar\n";

			foreach($rh as $h){
				$invoice = "".$invoice."\t\t\t$".$h->dailyFee."\t\t".$h->reservationLength."\t\t\t\t\t\t$".($h->reservationLength*$h->dailyFee)."\t\t";
				$carName = $cars[$count]['modelYear']." ".$cars[$count]['make']." ".$cars[$count]['model'];
				$carName = str_pad($carName, 31);
				$invoice = "".$invoice.$carName."\n";
				$total = $total + $h->reservationLength*$h->dailyFee;
				$count = $count + 1;
			}
			$invoice = "".$invoice."\tTotal:\t\t\t\t\t\t\t\t\t\t$".$total;
			$invoice = "".$invoice."\n\nThank you for your continued patronage.\nRegards,\nThe KTCS Team";

			if(!mail($user['email'], "KTCS Invoice", $invoice, $headers)){
				return "Failed to deliver email. Please check that the user has entered a valid email.";
			}

			//for testing
			//$file = fopen("temp", 'w');
			//fwrite($file, $invoice);
			//fclose($file);

			return "Invoice sent successfully.";
		}
	}
?>