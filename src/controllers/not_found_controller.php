<!-- filename: not_found_controller.php -->
<!-- authors: Will Alley -->

<?php
	class NotFoundController {
		
		public function error () {
			// when a request is made for a controller that does not exist
			require_once('views/not_found_view.php');
		}
	}
?>