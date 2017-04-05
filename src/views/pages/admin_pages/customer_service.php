<!-- filename: customer_service.php-->
<!-- authors: Owen Westland -->

<div class = "row">
	<div class ="col-md-12">
		<h2>Customer Service:</h2>
	</div>
	<div class = "col-md-12">
		<h5><?php echo $result_message ?></h5>
	</div>
</div>

<div class = "row">
	<div class = "col-md-6">
    	<h3>Generate Invoice</h3>
		<form method="post" action="?controller=admin&action=userinvoice">
			<div class="form-group">
           		<label for="l1">User Member ID</label>
                <span class="error"><?php echo $memberID_failed ?></span>
                <input type="text" name="memberID" class="form-control" id="l1">
            </div>
			<div class="form-group">
           		<label for="l1">Starting Date</label>
                <span class="error"><?php echo $monthStart_failed ?></span>
                <input type="date" name="monthStart" class="form-control" id="l1">
            </div>
			<div class="form-group">
           		<label for="l1">End Date</label>
                <span class="error"><?php echo $monthEnd_failed ?></span>
                <input type="date" name="monthEnd" class="form-control" id="l1">
            </div>		
        	<button type="submit" class="btn btn-default pull-right">Generate</button>	
		</form>
	</div>
	<div class = "col-md-6">
		<h3>Respond To User Comment</h3>
		<form method="post" action="?controller=admin&action=commentresponse" id="commentform">
			<div class="form-group">
           		<label for="l1">Comment Number</label>
                <span class="error"><?php echo $commentNo_failed ?></span>
                <input type="number" min="0" step="1" name="commentNo" class=" form-control" id="l1">
            </div>
			<div class="form-group">
           		<label for="l1">Response</label>
                <span class="error"><?php echo $response_failed ?></span>
                <textarea class="form-control" rows="3" placeholder="Response" name="response" form="commentform" required></textarea>
            </div>
			<button type="submit" class="btn btn-default pull-right">Generate</button>	
		</form>
	</div>
</div>