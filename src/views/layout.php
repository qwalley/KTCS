<!-- filename: layout.php -->
<!-- authors: Will Alley -->
<DOCTYPE html>
<html lang="en">
<head>
	<title>K-Town Car Share</title>
</head>
<body>
	<header>
		<a href="/KTCS-Project/src">Home</a>
		<a href="?controller=pages&action=login"> Login/Sign up</a>
	</header>
	<?php
		require_once('routes.php');
	?>
	<footer>
		footers stuff
	</footer>
</body>
</html>