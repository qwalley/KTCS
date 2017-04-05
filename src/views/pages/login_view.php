<!-- filename: login_view.php-->
<!-- authors: Will Alley -->

<div class="row">
	<div class="col-md-6">
		<h2 class="page-header">Login</h2>
		<p><?php echo $login_failed ?></p>
		<form method="post" action="?controller=pages&action=login">
			<div class="form-group">
				<label for="l1">email:</label>
				<span class="error"><?php echo $email_failed ?></span>
				<input type="text" name="email" class="form-control" id="l1">
			</div>
			<div class="form-group">
				<label for="l2">password:</label>
				<span class="error"><?php echo $password_failed ?></span>
				<input type="password" name="password" class="form-control" id="l2">
			</div>
			<button type="submit" class="btn btn-default">Login</button>
		</form>
	</div>
	<style type="text/css">
		.half {
			width: 50%;
		}
	</style>
	<div class="col-md-6">
		<h2 class="page-header">Register</h2>
		<p><?php echo $register_failed ?></p>
		<form method="post" action="?controller=pages&action=register">
			<div class="row">
				<div class="form-group col-md-6">
					<label for="r3">name:</label>
					<span class="error"><?php echo $name_failed ?></span>
					<input type="text" name="name" class="form-control" id="r3">
				</div>
				<div class="form-group col-md-6">
					<label for="r4">phone:</label>
					<span class="error"><?php echo $phone_failed ?></span>
					<input type="text" name="phone" class="form-control" id="r4">
				</div>
			</div>
			<div class="form-group">
				<label for="r1">email:</label>
				<span class="error"><?php echo $email_failed ?></span>
				<input type="text" name="email" class="form-control" id="r1">
			</div>
			<div class="form-group">
				<label for="r2">password:</label>
				<span class="error"><?php echo $password_failed ?></span>
				<input type="password" name="password" class="form-control" id="r2">
			</div>
			<div class="form-group">
				<label for="r5">liscence number:</label>
				<span class="error"><?php echo $liscenseNO_failed ?></span>
				<input type="text" name="liscenseNO" class="form-control" id="r5">
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label for="r6">address:</label>
					<span class="error"><?php echo $address_failed ?></span>
					<input type="text" name="address" class="form-control" id="r6">
				</div>
				<div class="form-group col-md-6">
					<label for="r7">postal code:</label>
					<span class="error"><?php echo $postal_failed ?></span>
					<input type="text" name="postal" class="form-control" id="r7">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label for="r8">city:</label>
					<span class="error"><?php echo $city_failed ?></span>
					<input type="text" name="city" class="form-control" id="r8">
				</div>
				<div class="form-group col-md-6">
					<label for="r9">country:</label>
					<span class="error"><?php echo $country_failed ?></span>
					<input type="text" name="country" class="form-control" id="r9">
				</div>
			</div>
			<button type="submit" class="btn btn-default">Register</button>
		</form>
	</div>
</div>



