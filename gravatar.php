<?php
    require_once("main.php");
    $img=md5($API->user->set_userid($_GET['userid'])->details('email'));
    readfile("http://www.gravatar.com/avatar/$img?d=identicon&s=120&r=x");
?>
