<?php
//save.php
session_start();
//var_dump($_POST);
$user=$_SESSION['user'];
$fname=$_POST['title'];
$contents=stripslashes($_POST['contents']);
$name=$_POST['name'];
$email=$_POST['name'];
?>