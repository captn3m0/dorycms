<?php
session_start();
include "functions.php";
$id=query("SELECT MAX(id) FROM posts where publish=1");
$id=$_GET['id']?$_GET['id']:$id;
//echo $id;
$p=get_post($id);
echo '<h2>'.$p[0].' by '.$p[1].'</h2>'.$p[2];
?>