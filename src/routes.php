<!-- filename: routes.php -->
<!-- authors: Will Alley -->

<?php
	function call($controller, $action) {
		require_once('controllers/' . $controller . '_controller.php');

		// create instance of controller
		switch($controller) {
			case 'pages' : 
				require_once('models/admin_model.php');
				$controller = new PagesController();
			break;

			case 'admin' :
				require_once('models/admin_model.php');
				$controller = new AdminController(Database::getInstance());
			break;

			case 'not_found' : 
				$controller = new NotFoundController();
			break;
		}

		// call requested action
		$controller->{ $action }();
	}

	// A list of existing controllers and their actions
	$controllers = array (
		'pages' => ['home', 'error', 'login', 'logout', 'register', 'fleet', 'customer', 'records', 'dropoff', 'pickup', 'lotcars', 'rental', 'reserve', 'profile'],
		'admin' => ['addcar', 'commentresponse', 'lotcars', 'datereservations', 'damagedcars', 'minmaxrentals', 'maintenancecars', 'userinvoice', 'carhr'],
		'not_found' => ['error']
		);

	// check that requested controller exists
	if (array_key_exists($controller, $controllers)) {
		// check that requested action belongs to the controller
		if (in_array($action, $controllers[$controller])) {
			call($controller, $action);
		}
		// if action does not exist, call controllers error action
		else {
			call($controller, 'error');
		} // end action check
	}
	// if controller does not exist, call default error action
	else {
		call('not_found', 'error');
	} // end controller check
?>