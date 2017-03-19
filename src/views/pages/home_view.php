<!-- filename: home_views.php -->
<!-- authors: Will Alley -->

<div id="home_view">
	<p><?php echo 'Hello, ' . $first_name . ' ' . $last_name . '!'; ?></p>
	<p>You are on the home page.</p>
	<a href="?controller=pages&action=second_page">Second Page</a>
	<a href="?controller=pages&action=imaginary_action">An Action Error</a>
	<a href="?controller=imaginary_controller&action=imaginary_action">A Controller Error</a>
</div>
