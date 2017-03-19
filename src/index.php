<!-- filename: index.php -->
<!-- author: Will Alley -->

<?php
	require_once('connection.php');

	// determine if specific request has been made
	if(isset($_GET['controller']) && isset($_GET['action'])) {
		$controller = $_GET['controller'];
		$action = $_GET['action'];
	}
	// set default reponse to 'Home' page
	else {
		$controller = 'pages';
		$action = 'home';
	}

	// render web-page
	require_once('views/layout.php');
?>
