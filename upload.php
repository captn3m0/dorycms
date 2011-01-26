<?php
require_once("UploadFile.class.php");
//Delete the comments below or you will get parse errors
$up = new UploadImage($_POST['banner'], //<-name of your file field with $
102400, //<-max file size in bytes
100, //<-max file height
700, //<-max file width
"banner", //<-name of your file field
".", //<-path to upload directory
$rename_file=true); //<- default is true set to false
//if you don't want the file renamed

if ($submit) {
if($up->ValidateUpload()) {
$up->CopyFile();
}
}
$up->PrintForm(102400); //<-max file size for html form same as above
?>