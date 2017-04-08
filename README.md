# K-Town Carshare
A school assignment to build an imaginary carshare service. Built from Php and MySQL

## Getting Started:

* Follow the [XAMPP instalation guide](https://www.apachefriends.org/index.html) to setup an Apache Web Server on your machine. 
	* Open the XAMPP manager desktop application and in the "Manage Servers" tab, select "Apache Web Server" and click start. Repeat for "MySQL Database".
	* When the status changes to Running, open a web browser and search "localhost/dashboard". If you see a XAMPP welome page, then everything is probably working.
	* Click the "phpMyAdmin" link and create a new user with hostname: localhost, and global priveledges on all DBs.

* In your terminal, navigate to XAMPP/htdocs and clone the repository using `$git clone https://github.com/qwalley/KTCS.git` on UNIX systems.

* Open `KTCS/src/carshare_load.php` in a text editor and modify the connection information with your phpMyAdmin user info.

* Open a web browser and search `localhost/KTCS/src/carshare_load.php` you should see the words "finished." in the browser.

* Change the URL to `localhost/KTCS/src` and you should see the home for the website.
