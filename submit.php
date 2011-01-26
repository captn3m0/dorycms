<?php
//article submit
session_start();
include "functions.php";
$user=$_SESSION['user'];
?>
<html><head><title>Article Submission</title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="./wymeditor/jquery.wymeditor.min.js"></script>
<script type="text/javascript">
jQuery(function() {
    jQuery('.wymeditor').wymeditor();
});
</script>
</head>
<body>
<h1><center>Article Submission</center></h1>
<table>
<form method='post' action='save.php'>
<?php
if(!isset($user))
{
	?>
	<hr>
	<tr><td colspan='2'>You are submitting this article as a guest. Please furnish these extra details:</td></tr>
	<tr><td>Name: </td><td><input type='text' name='name' value='Full Name'></td></tr>
	<tr><td>Email Id: </td><td><input type='text' name='email' value='Email ID'><br></td></tr>
	<tr><td colspan='2'>This article will be published in a separate section from our site in a different category (Your Views)</td></tr>
	<tr><td colspan='2'></td></tr>
	<?php
}
if(isset($user))
{
	$role=getrole($user);
	if($role==1)
	{
		?>
		
		<tr><td colspan='2'>You may submit this article as a guest article by another user who does not yet have an account on the site, for that please fill in the following fields
		Leave them blank to submit it in your name</td></tr>
		<tr><td>Name Of Author: </td><td><input type='text' name='name' value='Name Of Author'></td></tr>
		<tr><td>Email id: </td><td><input type='text' name='email' value='Email ID of Author (necessary)'></td></tr>
		<?php
	}
}
?>
	<tr><td>Title: </td><td><input type='text' name='title' value='Article Title'></td></tr></table>
	Article Content: <br><textarea name="contents" class="wymeditor"></textarea>
	<input type='submit' name='submit' value='Submit Article'  class="wymupdate" >
	</form>