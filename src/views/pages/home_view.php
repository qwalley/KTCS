<!-- filename: home_views.php -->
<!-- authors: Will Alley -->

<div id="home_view">
	<p><?php
	if ($session) {
		echo "Hello ".$_SESSION['user_info']['name'];
	}
	?></p>
	

	<p>You are on the home page.</p>

	<!-- URLs beginning with '?' are relative to the root folder,
	and can be used to set request $_GET variables-->
	<a href="?controller=pages&action=imaginary_action">An Action Error</a>
	<a href="?controller=imaginary_controller&action=imaginary_action">A Controller Error</a>
</div>
