<?php
//category.php
$id=$_GET['id'];
if(!is_numeric($id))
	header("Location: error.php");
require_once('config.php');
$cat=$categories[$id-1];
$result=query("SELECT * FROM  POSTS WHERE category='$cat'");
$posts=array();
while(
?>