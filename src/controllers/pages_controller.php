<!-- filename: pages_controller.php -->
<!-- authors: Will Alley -->

<?php
	class PagesController {

		// define actions that belong to this controller
		public function home () {
			$first_name = 'Joe';
			$last_name = 'Blow';

			// render view
			require_once('views/pages/home_view.php');
		}

		public function error () {
			// when a request is made for a page that does not exist
			require_once('views/pages/error_view.php');
		}

		public function second_page () {
			$first_name = 'Joe';
			$last_name = 'Blow';

			// render view
			require_once('views/pages/second_page_view.php');
		}
	}
?>