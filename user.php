<?php
session_start();
include "functions.php";
$user=$_GET['id']?getuser($_GET['id']):logged();
$role=getrole($user);
echo "<h1>".getuserdetails($user,'name')."</h1>";
echo "<p align='right'>".getuserdetails($user,'aboutme')."</p>";
echo "<p margin='20px'><a href='".getuserdetails($user,'url1')."'>".getuserdetails($user,'url1')."</a></p>";
echo "<p margin='20px'><a href='".getuserdetails($user,'url2')."'>".getuserdetails($user,'url2')."</a></p>";
echo "<p margin='20px'><a href='".getuserdetails($user,'url3')."'>".getuserdetails($user,'url3')."</a></p>";
if($role==1)
{
	echo "<h7>*This user is an administrator</h7>";
}
?>