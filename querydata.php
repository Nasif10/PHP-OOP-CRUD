<?php 
  include 'config.php';
  include 'header.php';

  $obj = new Config();

  $query_text = $_REQUEST['query']; 
?>

<section class="py-5">
	<div class="container">
		<div class="row">
		<div class="col-md-7 mx-auto">
		<h2>Query Record</h2>
		<?php		
		   $sql = "SELECT * FROM employee";
           $result = $obj->sql($sql);
		   $noOfRows = $result->num_rows;
           echo "<br>"."No. of rows in table 'employee' : ".$noOfRows;

		   $result = $obj->sql($query_text);
		   $noOfRows = $result->num_rows;
           echo "<br>"."No. of rows matched : ".$noOfRows;

		   echo "<pre>";
		       print_r($obj->getResult());
		   echo "</pre>";
		   		
		?>			
	    </div>
	</div>
	</div>			
</body>
</html>		