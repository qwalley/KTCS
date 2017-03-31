<!-- filename: routes.php -->
<!-- authors: Will Alley -->

<?php
	function call($controller, $action) {
		require_once('controllers/' . $controller . '_controller.php');

		// create instance of controller
		switch($controller) {
			case 'pages' : 
				$controller = new PagesController();
			break;

			case 'db_access' : 
				$controller = new DBAccessController(Database::getInstance());
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
		'pages' => ['home', 'error', 'login'],
		'db_access' => ['verify_login', 'register_user'],
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