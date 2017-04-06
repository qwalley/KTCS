<!-- filename: home_views.php -->
<!-- authors: Will Alley -->

<style>
	.stupidHeaderFix{
		margin-bottom:-30px;
	}
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">K-Town Car Share</h1>
		<h4 class="">We put the car in caring about our customers</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-md-6">    
		<p>
		<?php 
			if(isset($_SESSION['user_info'])) {
				$user_info = $_SESSION['user_info'];
				echo 'Welcome ' . $user_info['name'];
		?>
		<br>
		<?php
				if($user_info['reservation'] == 'pickup'){
					echo "You have a car reserved for pickup today.";
				}
				else if($user_info['reservation'] == 'dropoff'){
					echo "Your car reservation ends today. Please remember to return your vehicle.";
				}
			}
		?>
		</p>
	</div>
	
	<div class="col-md-6">    

	</div>
</div>
