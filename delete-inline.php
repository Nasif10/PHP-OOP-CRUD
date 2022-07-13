<?php
include 'config.php';

$obj = new Config();

$eid = $_GET['id'];

$obj->delete('employee','id ='.$eid);

header("Location: index.php");

?>
