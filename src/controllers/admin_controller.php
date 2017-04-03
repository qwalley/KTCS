<!-- filename: admin_controller.php-->
<!-- authors: Owen Westland -->

<?php 
    class AdminController {
	    private $db = NULL;
		private $addCar;
	
		private $carReservationsSQL = 
			'SELECT *
	            FROM Reservations
	            WHERE VIN = :VIN';

        private $lotCarsSQL =
            'SELECT *
	            FROM Car
	            WHERE lotNO = :lotNO';
        
        private $dateReservationsSQL =
            'SELECT *
	            FROM Reservation
	            WHERE date = :date';

        private $addCarSQL =
            'INSERT INTO Car VALUES
                (:VIN, :make, :model, :modelYear, :dailyFee, :lotNo)';

        private $commentResponseSQL =
            'INSERT INTO Response VALUES
	            (NULL, :commentNo, :response)';

		private $damagedCarsSQL =
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
		
		private $userInvoiceSQL =
			'SELECT *
				FROM rentalhistory
				WHERE memberID = :memberID AND date >= :monthStart AND date < :monthEnd';

		private $carHistorySQL =
			'SELECT *
				FROM rentalhistory
				WHERE VIN = :VIN';

		private $maxRentalsSQL =
			'SELECT Car.*, MAX(rentalcount.numRentals) AS numRentals
				FROM Car JOIN (SELECT VIN, COUNT(VIN) AS numRentals
				FROM rentalhistory
				GROUP BY VIN) AS rentalcount ON Car.VIN = rentalcount.VIN';

		private $minRentalsSQL =
			'SELECT Car.*, MIN(rentalcount.numRentals) AS numRentals
				FROM Car JOIN (SELECT VIN, COUNT(VIN) AS numRentals
				FROM rentalhistory
				GROUP BY VIN) AS rentalcount ON Car.VIN = rentalcount.VIN';

		private $maintenanceCarsSQL =
			'SELECT Car.*
				FROM Car INNER JOIN (SELECT lastrental.VIN AS VIN
					FROM (SELECT VIN, odometer, MAX(date) AS maxdate
						FROM maintenance
						GROUP BY VIN) AS lastmaintenance
					INNER JOIN (SELECT VIN, endingOdometer, MAX(date) AS maxdate
						FROM rentalhistory
						GROUP BY VIN) AS lastrental ON lastmaintenance.VIN = lastrental.VIN
					WHERE (lastrental.endingOdometer - lastmaintenance.odometer) >= 5000) AS maintenancecars ON Car.VIN = maintenancecars.VIN';

		public function __construct($pdo) {
			$this->db = $pdo;
			$this->addCar = $this->db->prepare($this->addCarSQL);
		}

		public function addcar () {
			$VIN = $make = $model = $modelYear = $dailyFee = $lotNo = "";

			if (isset($_GET['VIN']) & isset($_GET['make']) & isset($_GET['model']) & isset($_GET['modelYear']) & isset($_GET['dailyFee']) & isset($_GET['lotNo'])) {
				$VIN = $_GET['VIN'];
				$make = $_GET['make'];
				$model = $_GET['model'];
				$modelYear = $_GET['modelYear'];
				$dailyFee = $_GET['dailyFee'];
				$lotNo = $_GET['lotNo'];
			}
			else{
				echo "ERROR: All fields must be filled to register a new car.";
				die();
			}

			$this->addCar->execute(array(':VIN' => $VIN, ':make' => $make, 'model' => $model, 'modelYear' => $modelYear, 'dailyFee' => $dailyFee, 'lotNo' => $lotNo));

			$VIN_failed = $make_failed = $model_failed = $modelYear_failed = $dailyFee_failed = $lotNo_failed= "";
			$add_message = "Car successfully added to fleet.";

			require_once('views/pages/admin_view.php');
		}
	}
?>