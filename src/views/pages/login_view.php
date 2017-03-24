<!-- filename: login_view.php-->
<!-- authors: Will Alley -->

<div id="login_view">
	<p><?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?></p>
	<p> Login...</p>
	<form method="post" action="?controller=pages&action=login&attempt=login">
		email: <input type="text" name="email">
		<span class="error"><?php echo $email_failed ?></span>
		<br>
		password: <input type="text" name="password">
		<span class="error"><?php echo $password_failed ?></span>
		<br>
		<input type="submit" name="login">
	</form>
	<p> or register </p>
	<form method="post" action="?controller=pages&action=login&attempt=register">
		email: <input type="text" name="email">
		<br>
		password: <input type="text" name="password">
		<br>
		name: <input type="text" name="name">
		<br>
		phone: <input type="text" name="phone">
		<br>
		driver's liscense number: <input type="text" name="liscenseNo">
		<br>
		<input type="submit" name="register">
	</form>
</div>