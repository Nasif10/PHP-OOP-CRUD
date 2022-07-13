<?php 
include 'config.php';
include 'header.php'; 

$obj = new Config();

?>

<section class="py-5">
	<div class="container">
		<div class="row">
		<div class="col-md-7 mx-auto">
		<div class="card">
			<div class="card-header text-center">
				<h4>Query</h4>
			</div>
			<div class="card-body">
				<p class="card-title text-center">Enter SQL query in the textbox</p>
			
				<form class="post-form p-2" action="querydata.php" method="POST"> 
					<div class="row mb-3">
						<textarea id="query_text" class="form-control" name="query" cols="64" rows="7" required></textarea></br></br>
						
					</div>
					<div class="row mb-3">
						<input class="btn btn-outline-secondary" type="submit" value="Run Query"/>
					</div>
				</form>
			</div>	
		</div>	
		</div>
		</div>			
	</div>
</section>
	
<?php include 'footer.php'; ?>