<?php 
include 'config.php';
  
$obj = new Config();

if(isset($_POST["submit"]))
{
    $name = $_FILES['image']['name'];
	$tmp_name = $_FILES['image']['tmp_name'];
	
	$target_dir = "savedImage/".$name;
	$exists = move_uploaded_file($tmp_name, $target_dir);
	
	$ename = $_POST['ename'];
    $ephone = $_POST['ephone'];
    $eaddress = $_POST['eaddress'];
    $eclass = $_POST['eclass'];

    $obj->insert('employee', ['name'=>$ename, 'phone'=>$ephone, 'address'=>$eaddress, 'image'=>$target_dir, 'cid'=>$eclass]);

    header("Location: index.php");
}
?>