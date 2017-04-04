<?php
    class Reservation {
        // we define 3 attributes
        // they are public so that we can access them using $post->author directly
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
?>