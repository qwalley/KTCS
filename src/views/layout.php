<!-- filename: layout.php -->
<!-- authors: Will Alley -->
<DOCTYPE html>
<html lang="en">
<head>
	<title>K-Town Car Share</title>

	<style type="text/css">
		table, th, td {
   			border: 1px solid black;
		}
	</style>
</head>
<body>
	<header>
		<a href="/KTCS/src">Home</a>
		<a href="?controller=pages&action=login"> Login/Sign up</a>
		<a href="?controller=pages&action=admin">Administrator Page</a>
	</header>
	<?php
		require_once('routes.php');
	?>
	<footer>
		footers stuff
	</footer>
</body>
</html>