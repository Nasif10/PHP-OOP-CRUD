<?php 
include 'config.php';
include 'header.php'; 

$obj = new Config();

if(isset($_POST["submit"]))
{
    $eid = $_POST['eid'];
    $ename = $_POST['ename'];
    $ephone = $_POST['ephone'];
    $eaddress = $_POST['eaddress'];
	$eold_image = $_POST['old_image'];
	$eimage = $_FILES['image']['name'];
    $eclass = $_POST['eclass'];
	
	if($eimage != ''){
		$tmp_name = $_FILES['image']['tmp_name'];
		$target_dir = "savedImage/".$eimage;
		move_uploaded_file($tmp_name, $target_dir);
		$obj->update('employee', ['name'=>$ename, 'phone'=>$ephone, 'address'=>$eaddress, 'image'=>$target_dir, 'cid'=>$eclass], 'id ='.$eid);
	}
	else{
		$obj->update('employee', ['name'=>$ename, 'phone'=>$ephone, 'address'=>$eaddress, 'image'=>$eold_image, 'cid'=>$eclass], 'id ='.$eid);
	}
     
    header("Location: index.php");
}
?>

<section class="py-5">
	<div class="container">
		<div class="row">
		<div class="col-md-7 mx-auto">
		<div class="card">
		    <div class="card-header text-center">
				<h4>Update Employee</h4>
			</div>
			<div class="card-body mt-4">
				<form class="post-form" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
					<div class="row mb-3">
						<label class="col-form-label col-md-3">Id</label>
						<div class="col-md-9">
							<input class="form-control" type="text" name="eid" required />
						</div>	
					</div>
					<div class="row mb-3">
					    <label class="col-form-label col-md-3"></label>
						<div class="d-grid col-md-9">
							<input class="btn btn-outline-info" type="submit" name="showbtn" value="Show" />
						</div>
					</div>	
				</form>

			<?php
			    if((isset($_POST['showbtn'])) || (isset($_GET['id'])) ){
                    $eid = isset($_GET['id']) ? $_GET['id'] : '';
					if($eid){
						$eid = $_GET['id'];
					}
					else{
						$eid = $_POST['eid']; 
					}
					
					$obj->select('employee', '*', null, 'id = '.$eid, null);										        

				    foreach($obj->getResult() as $k => $v)
				    {
			?>
		
				<form class="post-form" action="" method="post" enctype="multipart/form-data">
				
					<div class="row mb-3">
						<label class="col-form-label col-md-3">Name</label>
						<div class="col-md-9">
							<input type="hidden" name="eid"  value="<?php echo $v['id']; ?>" />
							<input class="form-control" type="text" name="ename" value="<?php echo $v['name']; ?>" />
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-form-label col-md-3">Phone</label>
						<div class="col-md-9">
							<input class="form-control" type="text" name="ephone" value="<?php echo $v['phone']; ?>" />
						</div>				
					</div>					
					<div class="row mb-3">
						<label class="col-form-label col-md-3">Address</label>
						<div class="col-md-9">
							<input class="form-control" type="text" name="eaddress" value="<?php echo $v['address']; ?>" />
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-form-label col-md-3">Picture</label>
						<div class="col-md-9">
						    <input class="form-control" type="file" name="image"/>
							<input class="form-control" type="hidden" name="old_image" value="<?php echo $v['image']; ?>" />
						</div>
					</div>
					
					<div class="row mb-3">
						<label class="col-form-label col-md-3">Class</label>
						
						<div class="col-md-9">
							<select class="form-select" name="eclass">
							
							<?php
								$obj2 = new Config();
								$obj2->select('employeeclass', '*', null, null, null);
																	
								foreach($obj2->getResult() as $k2 => $v2)
								{
									if($v['cid'] == $v2['cid']){
										 $select = "selected";
									}
									else $select = "";
									
									echo  "<option {$select} value='{$v2['cid']}'>{$v2['cname']}</option>";
								}
								?>
							</select>     					
						</div>	
					</div>
					<div class="row mb-3">
						<label class="col-form-label col-md-3"></label>
						<div class="d-grid col-md-9">
							<input class="btn btn-outline-warning" name="submit" type="submit" value="Update" />
						</div>
					</div>
				</form>
			<?php
			   }
			}
			?>
		    </div>
		</div>
		</div>	
		</div>	
	</div>
</section>

<?php include 'footer.php'; ?>