<?php
function query($var,$db=null)
{
	include "config.php";
	$dbb=mysqli_connect($host,$db_user,$db_pwd,$db_name);
	$result=mysqli_query($dbb,$var);
	//echo $var;
	//var_dump($result);
	if($result===true)
		return true;
	$count=mysqli_num_rows($result);
	if($count==1)
	{
		$row=mysqli_fetch_row($result);
		if(count($row)==1)
			return $row[0];
		else
			return $row;
	}
	elseif($count==0)
		return false;
	else
		return $result;
} 
function logged(){
	if(isset($_SESSION['user']))
		return $_SESSION['user'];
	else
		header("Location: error.php");
}
function getrole($user){
	return query("select role from users where email= '$user'");
}
function createpage($title,$content){
	//TODO : check for sufficient permissions as well
	$file=createfile($content);
	query('INSERT INTO pages (title,file) values('."'$title','$file')");
	return true;
}
function createpost($title,$content,$author,$cat){
	if(!$author)
		header("Location: error.php");
	//TODO : check for sufficient permissions as well
	//user exists?
	$file=createfile($content);
	$time=time();
	query('INSERT INTO posts (title,author,file,time,category) values('."'$title','$author','$file','$time','$cat')");
	return true;
}
function createfile($content){
	$content=nl2br(htmlentities($content));
	do{
	$fname=str_makerand();
	}while(@file_get_contents("articles\\$fname.html")!='');
	file_put_contents("articles\\$fname.html",$content);
	return $fname;
}
function str_makerand ()
{
$charset = "abcdefghijklmnopqrstuvwxyzYZ0123456789";
$length = 9;
for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
return $key;
}
function getuserdetails($user,$detail){
	if($detail=='password')
		return false;
	return query("SELECT $detail FROM users where email='$user'");
}
function get_page($id)
{
	$r=query("SELECT title,file FROM pages WHERE  id='$id'");
	if(!$r)
		header("Location: error.php");
	$fname=$r[1];
	$r[1]=file_get_contents("articles\\$fname.html");
	return $r;//holds title contents 
}
function get_post($id)
{
	$r=query("SELECT title,author,file,time FROM posts WHERE  id='$id'");
	if(!$r)
		header("Location: error.php");
	$fname=$r[2];
	$r[2]=file_get_contents("articles\\$fname.html");
	$r[3]=date("F j, Y, g:i a",$r[3]);
	return $r;//holds title author contents time(in words)
}
function get_snipped_post($id)
{
	$r=query("SELECT title,author,file,time FROM posts WHERE  id='$id'");
	if(!$r)
		header("Location: error.php");
	$fname=$r[2];
	$r[2]=file_get_contents("articles\\$fname.html");
	$r[2]=substr($r[2],0,150);
	$r[3]=date("F j, Y, g:i a",$r[3]);
	return $r;//holds title author contents time(words)
}
function post_link($id){
	$title=query("SELECT title FROM posts WHERE  id='$id'");
	return '<a href="post.php?id='.$id.'">'.$title.'</a>';
}
function post_snip($id){
	$p=get_post($id);
	$p[2]=substr($p[2],0,150);
	return $p[2];
}
function getuser($id){
	return query("SELECT email FROM posts WHERE uid='$id'");
}
function gravatar_image($user){}//to be implemented...
?>