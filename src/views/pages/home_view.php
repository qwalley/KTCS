<!-- filename: home_views.php -->
<!-- authors: Will Alley -->

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Home</h1>
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
				echo '<pre>';
				print_r($user_info);
				echo "</pre>";
			}
		?>
		</p>
	</div>
	
	<div class="col-md-6">    

	</div>
</div>