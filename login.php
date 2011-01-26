<?php
if(!isset($_POST['user']))
{
	echo '<form action="login.php" method="post">
<input type="text" name="user">
<input type="password" name="pwd">
<input type="submit">
</form>';
	die;
}
session_start();
include "functions.php";
//login.php
$user=$_POST['user'];
$pwd=md5(md5($_POST['pwd']));
$email=query('SELECT email FROM USERS WHERE email= \''.$user.'\' AND password= \''.$pwd.'\'');
if($email)
	$_SESSION['user']=($email);
else
	header("Location: error.php");
?>