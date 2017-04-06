<!DOCTYPE html>
<html>
<head>
	<title>Load KTCS data</title>
</head>
<body>

<?php 
/* Program: carshar_load.php
*  Desc: creates and loads tables for KTCS
*  		 Database with sample data
*/

$host = "localhost";
$user = "cmpe332";
$password = "guest";
$database = "KTCS";
$cxn = mysqli_connect($host, $user, $password, $database);
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	die();
}

mysqli_query($cxn, "drop table Reservation;");
mysqli_query($cxn, "drop table Maintenance;");
mysqli_query($cxn, "DROP TABLE Response;");
mysqli_query($cxn, "drop table Comment;");
mysqli_query($cxn, "drop table RentalHistory;");
mysqli_query($cxn, "drop table Car;");
mysqli_query($cxn, "drop table ParkingLocation;");
mysqli_query($cxn, "drop table Member;");

mysqli_query($cxn, "create table Car
	(VIN varchar(20),
	 make    varchar(24) not null,
	 model    varchar(24) not null,
	 modelYear    int not null,
	 dailyFee    numeric(4,2) not null,
	 lotNo    int not null,
	 primary key (VIN));");

mysqli_query($cxn, "create table ParkingLocation
	(lotNo int,
	 address varchar(255) not null,
	 postalCode char(6) not null,
	 city varchar(255) not null,
	 country varchar(255) not null,
	 numSpaces int not null,
	 primary key (lotNo));");
	
mysqli_query($cxn, "create table Maintenance
	(VIN varchar(20),
	 date datetime not null,
	 odometer int not null,
	 maintenanceType varchar(50) not null,
	 description varchar(255) not null,
	 primary key (VIN, date));");

mysqli_query($cxn, "create table Member 
	(memberID INT NOT NULL AUTO_INCREMENT,
	 name VARCHAR(30) NOT NULL,
	 phoneNO VARCHAR(10) NOT NULL,
	 email VARCHAR(100) NOT NULL,
	 password VARCHAR(100) NOT NULL,
	 admin BOOLEAN NOT NULL,
	 liscenseNO CHAR(20) NOT NULL,
	 monthlyFee INT NOT NULL,
	 address VARCHAR(255) NOT NULL,
	 postalCode CHAR(6) NOT NULL,
	 city VARCHAR(255) NOT NULL,
	 country VARCHAR(55) NOT NULL,
	 PRIMARY KEY (memberID));");
	 
mysqli_query($cxn, "create table Comment
	(commentNo INT NOT NULL AUTO_INCREMENT,
	 VIN VARCHAR(20) NOT NULL,
	 memberID INT NOT NULL,
	 date DATETIME NOT NULL,
	 rating INT NOT NULL,
	 comment TEXT, 
	 PRIMARY KEY (commentNo));");

mysqli_query($cxn, "create table RentalHistory
	(VIN VARCHAR(20) NOT NULL,
	memberID INT NOT NULL,
	pickup DATETIME NOT NULL,
	dropoff DATETIME,
	startingOdometer INT NOT NULL,
	endingOdometer INT,
	StatusOnPickup CHAR(10) NOT NULL,
	StatusOnReturn CHAR(10),
	reservationLength INT NOT NULL,
	active BOOLEAN NOT NULL,
	PRIMARY KEY(VIN, memberID, pickup));");

mysqli_query($cxn, "create table Reservation
	(reservationNo INT NOT NULL AUTO_INCREMENT,
	 VIN VARCHAR(20) NOT NULL,
	 memberID INT NOT NULL ,
	 startDate DATE NOT NULL ,
	 accessCode CHAR(10) NOT NULL ,
	 reservationLength INT NOT NULL ,
	 PRIMARY KEY (reservationNo));");

mysqli_query($cxn, "CREATE TABLE Response
	(responseNo INT NOT NULL AUTO_INCREMENT,
	commentNo INT NOT NULL,
	response TEXT,
	PRIMARY KEY (responseNo));");

mysqli_query($cxn, "ALTER TABLE Maintenance
	ADD foreign key (VIN) references Car(VIN)");

mysqli_query($cxn, "ALTER TABLE Comment
	ADD FOREIGN KEY (VIN) REFERENCES CAR (VIN),
	ADD FOREIGN KEY(memberID) REFERENCES MEMBER (memberID)");

mysqli_query($cxn, "ALTER TABLE RentalHistory
	ADD FOREIGN KEY (VIN) REFERENCES CAR (VIN),
	 ADD FOREIGN KEY(memberID) REFERENCES MEMBER (memberID)");

mysqli_query($cxn, "ALTER TABLE Reservation
	ADD foreign key (VIN) references Car(VIN),
	 ADD foreign key (memberID) references Member(memberID)");

mysqli_query($cxn, "ALTER TABLE Response
	ADD FOREIGN KEY (commentNo) REFERENCES Comment (commentNo)");

mysqli_query($cxn, "ALTER TABLE Car
	ADD foreign key (lotNo) references ParkingLocation(lotNo)");


mysqli_query($cxn, "insert into ParkingLocation values
	('1', '301 Concession Street', 'K7K2C1', 'Kingston', 'Canada', '60'),
	('2', '195 Willingdon Avenue', 'K7L4H9', 'Kingston', 'Canada', '45'),
	('3', '981 Division Street', 'K7K 4C8', 'Kingston', 'Canada', '25');");

mysqli_query($cxn, "insert into Car values
	('1', 'test', 'test', '1950', '0.01', '1'),
	('AHHHHHHHHHHHHHH10', 'Matel', 'Barbie Jeep', '2001', '0.99', '1'),
	('1HGBH41JXMN109186', 'AmishAirlines', 'Milk Cart XV', '2017', '99.99', '1'),
	('B33SB33SB33SB333S', 'So Many', 'Bees', '2007', '4.20', '2');");

mysqli_query($cxn, "insert into Maintenance values
	('1HGBH41JXMN109186', '2017-01-13 12:01:33', '420', 'repair', 'Racoon trapped inside.'),
	('1HGBH41JXMN109186', '2017-01-13 12:30:12', '420', 'repair', 'The racoon got back inside.'),
	('AHHHHHHHHHHHHHH10', '2017-03-22 00:00:30', '7600', 'repair', 'Windshield repair.'),
	('AHHHHHHHHHHHHHH10', '2017-02-16 03:12:09', '5010', 'body work', 'repaired front bumper, cleaned off blood spatter.');");

mysqli_query($cxn, "insert into Member values
	(NULL, 'Bob Benson', '1112223333', 'bobbenson@email.com', 'guest', '0', 'X11111111111111', '60', '2222 Somewhere Lane', 'X1X1X1', 'Kingston', 'Canada'),
	(NULL, 'Jim Jameson', '9218675309', 'jimmyJ@email.com', 'guest', '1', 'Y22222222222222', '0', '8866 Daedric Crescent', 'Y2Y2Y2', 'Kingston', 'Canada'),
	(NULL, 'Owen Westland', '1113332222', 'owenwestland@gmail.com', 'guest', '1', 'X11111111111112', '60', '111 Easy Street', 'X7X7X7', 'Kingston', 'Canada'), 
	(NULL, 'Jane Doe', '8819926382', 'nobody@email.com', 'guest', '0', 'J12341234512345', '60', '10 Nowhere Street', 'Y2K3R9', 'Kingston', 'Canada');");

mysqli_query($cxn, "insert into RentalHistory values
	('1HGBH41JXMN109186', '1', '2017-03-02 02:34:11', '2017-03-03 02:34:11', '10000', '10001', 'normal', 'normal', '1', '0'),
	('AHHHHHHHHHHHHHH10', '3', '2017-03-20 02:34:11', '2017-03-27 02:34:11', '5010', '7600', 'normal', 'damaged', '7', '0'),
	('1HGBH41JXMN109186', '2', '2017-03-03 02:34:11', '2017-03-04 02:34:11', '10001', '12500', 'normal', 'normal', '1', '0'),
	('1HGBH41JXMN109186', '3', '2017-03-06 02:34:11', '2017-03-12 02:34:11', '12500', '50000', 'normal', 'NR', '6', '0');");

mysqli_query($cxn, "insert into Comment values
	(NULL, '1HGBH41JXMN109186', '1', '2017-03-02 23:59:59', '1', 'Could barely get the car out of the driveway before I had to get out. Not good.'),
	(NULL, '1HGBH41JXMN109186', '2', '2017-03-07 11:30:14', '3', NULL),
	(NULL, '1HGBH41JXMN109186', '3', '2017-03-16 02:00:00', '5', 'I literally never stopped driving the car. Loved it!');");

mysqli_query($cxn, "INSERT INTO Response values
	(NULL, '1', 'Sorry to hear about your bad experience.');");

mysqli_query($cxn, "insert into Reservation values
	(NULL, '1HGBH41JXMN109186', '1', '2017-03-09', '123456', '3'),
	(NULL, '1HGBH41JXMN109186', '2', '2017-03-13', '223344', '5'),
	(NULL, 'AHHHHHHHHHHHHHH10', '2', '2017-03-07', '666666', '4'),
	(NULL, 'AHHHHHHHHHHHHHH10', '4', '2017-04-05', '666666', '4'),
	(NULL, '1HGBH41JXMN109186', '3', '2017-03-29', '987654', '8'),
	(NULL, 'B33SB33SB33SB333S', '1', '2017-04-05', '111222', '1');");
echo "finished";

?>

</body>
</html>