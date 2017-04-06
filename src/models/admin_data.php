<?php
    class Reservation {
        public $VIN;
        public $memberID;
        public $startDate;
        public $accessCode;
        public $reservationLength;

        public function __construct ($VIN, $memberID, $startDate, $accessCode, $reservationLength){
            $this->VIN = $VIN;
            $this->memberID = $memberID;
            $this->startDate = $startDate;
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
        public $pickup;
        public $dropoff;
        public $startingOdometer;
        public $endingOdometer;
        public $StatusOnPickup;
        public $StatusOnReturn;
        public $reservationLength;
        public $active;
        public $dailyFee;

        public function __construct ($VIN, $memberID, $pickup, $dropoff, $startingOdometer, $endingOdometer, $StatusOnPickup, $StatusOnReturn, $reservationLength, $active, $dailyFee){
            $this->VIN = $VIN;
            $this->memberID = $memberID;
            $this->pickup = $pickup;
            $this->dropoff = $dropoff; 
            $this->startingOdometer = $startingOdometer;
            $this->endingOdometer = $endingOdometer;
            $this->StatusOnPickup = $StatusOnPickup;
            $this->StatusOnReturn = $StatusOnReturn;
            $this->reservationLength = $reservationLength;
            $this->active = $active;
            $this->dailyFee = $dailyFee;
        }
    }

    class Lot {
        public $lotNo;
        public $address;
        public $postalCode;
        public $city;
        public $country;
        public $numSpaces;

        public function __construct ($lotNo, $address, $postalCode, $city, $country, $numSpaces){
            $this->lotNo = $lotNo;
            $this->address = $address;
            $this->postalCode = $postalCode;
            $this->city = $city;
            $this->country = $country;
            $this->numSpaces = $numSpaces;
        }
    }
?>