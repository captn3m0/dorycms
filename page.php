<?php
session_start();
include "functions.php";
$id=query("SELECT MAX(id) FROM pages");
$id=$_GET['id']?$_GET['id']:$id;
//echo $id;
$p=get_page($id);
echo '<h2>'.$p[0].'</h2>'.$p[1];
?>