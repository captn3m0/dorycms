<?php
/*==============================================
Random name function needed to provide a name for
any files that are renamed
=================================================*/

function RandomFile($pass_len=12) {

$allchar = "abcdefghijklmnopqrstuvwxyz" ;
$str = "" ;
mt_srand (( double) microtime() * 1000000 );
for ( $i = 0; $i<$pass_len ; $i++ )
$str .= substr( $allchar, mt_rand (0,25), 1 ) ;
return $str ;

}

/*=================
Start of our class
=================== */

class UploadImage {

var $image;
var $imagesize;
var $max_file_size;
var $max_file_height;
var $max_file_width;
var $allowed;
var $rename_file;
var $path;

/*============================================
Construtor-This will run when our class is sub
===============================================*/


function UploadImage($image,
$max_file_size,
$max_file_height,
$max_file_width,
$field_name,
$path,
$rename_file=true) {



$this->image=$image;
$this->max_file_size=$max_file_size;
$this->max_file_height=$max_file_height;
$this->max_file_width=$max_file_width;
$this->allowed = array(".gif"=>"1",
".jpg"=>"2",
".jpeg"=>"2",
".png"=>"3",
".swf"=>"4",
".psd"=>"5",
".bmp"=>"6");
$this->field_name = $field_name;
$this->path = $path;
$this->rename_file = $rename_file;
}

/*================================================
Validate the form- This method will validate
the form and print out an error message if needed
=================================================*/

function ValidateUpload() {

/*========================================
Get the size in kb of the file and
prints an error is it exceed max_file_size
==========================================*/

if ($this->max_file_size < filesize($this->image)) {

print("<span style=\"color:red;\">ERROR: Your File: "
.$_FILES[$this->field_name]["name"]." is ".filesize($this->image).
" KB, the max file size allowed is "
.$this->max_file_size."</span>");

return false;

}

/*===============================================
gets the width of the file and prints an error if
file width is greater than max_file_width
=================================================*/

$this->imagesize=getimagesize($this->image);

if ($this->max_file_width < $this->imagesize[0]) {

print("<span style=\"color:red;\">ERROR:<br />Your File: "
.$_FILES[$this->field_name]["name"]." is ".$this->imagesize[0].
" pixels wide, the max file width allowed is "
.$this->max_file_width."</span>");

return false;

}

/*===============================================
gets the height of the file and prints an error if
file height is greater than max_file_width
=================================================*/

if ($this->max_file_height < $this->imagesize[1]) {

print("<span style=\"color:red;\">ERROR:<br />Your File: "
.$_FILES[$this->field_name]["name"]." is ".$this->imagesize[1].
" pixels high, the max file height allowed is "
.$this->max_file_height."<span>");

return false;

}

/*===============================================
gets the filetype and checks it against
allow types and returns an error if not in array
=================================================*/

if (!in_array($this->imagesize[2], $this->allowed)) {

print("<span style=\"color:red;\">ERROR:<br />Your File: "
.$_FILES[$this->field_name]["name"]." is not included
in the list of allowed filetype</span>"
);

return false;

}

/*==================================
COOL:- no errors so lets get the file
====================================*/

return true;
}

/*============================================
This mehod will print the form out on our page
==============================================*/

function PrintForm($max_file_size) {

global $PHP_SELF;

print("<form action=\"$PHP_SELF\" method=\"post\" enctype=\"multipart/form-data\"></br>\n");
print("<input type=file name=$this->field_name><br>\n");
print("<input type=hidden name=max_file_size value=".$max_file_size."><br>\n");
print("<input type=submit name=submit><br>\n");
print("</form>");

}

/*=============================================
This method will copy our file to the folder of
your choice and rename it if selected rename it
================================================*/

function CopyFile() {
if($this->rename_file) {

/*====================================
this will find out our file extension which
we need for renaming it.
========================================*/

global $name, $ext;

switch($_FILES[$this->field_name]["type"]) {

case 'image/gif';
$ext="gif";
break;

case 'image/jpeg';
$ext="jpg";
break;

case 'image/pjpeg';
$ext="jpg";
break;

case 'image/png';
$ext="png";
break;

case 'application/x-shockwave-flash';
$ext="swf";
break;

case 'image/psd';
$ext="psd";
break;

case 'image/bmp';
$ext="bmp";
break;
}

/*========================================================
Let's rename our file and then copy it to the directory
=========================================================*/

$name=RandomFile();

if(!@copy($_FILES[$this->field_name]["tmp_name"],$this->path."/".$name.".".$ext)) {

print("<b>There has been an error while uploading Filename:".$_FILES[$this->field_name]["name"] ." </b>");

} else {

print("Filename: ".$_FILES[$this->field_name]["name"] ." has been uploaded");

}

} else {

/*===================================================
if you don't want the file renamed then this will run
let's make sure the file doesn't exist already and if
it does let's return an error
=====================================================*/

if(!file_exists($this->path."/".$_FILES[$this->field_name]["name"])) {

if(!copy($_FILES[$this->field_name]["tmp_name"],$this->path."/". $_FILES[$this->field_name]["name"])) {

print("There has been an error uploading".$_FILES[$this->field_name]["name"]."please try adain");

} else {

print("Filename:".$_FILES[$this->field_name]["name"]." has been uploaded");

}
} else {

print("ERROR: A file by this name already exists");

}

}

}

}

?>