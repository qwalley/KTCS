<?php
    class Reservation {
        public $VIN;
        public $memberID;
        public $date;
        public $accessCode;
        public $reservationLength;

        public function __construct ($VIN, $memberID, $date, $accessCode, $reservationLength){
            $this->VIN = $VIN;
            $this->memberID = $memberID;
            $this->date = $date;
            $this->accessCode = $accessCode;
            $this->reservationLength = $reservationLength;
        }
    }

    class Car {
        public $VIN;
        public $make;
        public $model;
        public $modelYear;
        public $dailyFee;
        public $lotNo;

        public function __construct ($VIN, $make, $model, $modelYear, $dailyFee, $lotNo){
            $this->VIN = $VIN;
            $this->make = $make;
            $this->model = $model;
            $this->modelYear = $modelYear;
            $this->dailyFee = $dailyFee;
            $this->lotNo = $lotNo;
        }
    }

    class RentalHistory {
        public $VIN;
        public $memberID;
        public $date;
        public $startingOdometer;
        public $endingOdometer;
        public $StatusOnReturn;
        public $reservationLength;
        public $dailyFee;

        public function __construct ($VIN, $memberID, $date, $startingOdometer, $endingOdometer, $StatusOnReturn, $reservationLength, $dailyFee){
            $this->VIN = $VIN;
            $this->memberID = $memberID;
            $this->date =$date;
            $this->startingOdometer = $startingOdometer;
            $this->endingOdometer = $endingOdometer;
            $this->StatusOnReturn = $StatusOnReturn;
            $this->reservationLength = $reservationLength;
            $this->dailyFee = $dailyFee;
        }
    }
?>