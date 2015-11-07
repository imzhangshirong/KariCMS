<?php
header("Content-type: image/png");
$captcha = new Captcha(90,30,4);
$captcha->showImg();
session_start();
$_SESSION['checkecode']=$captcha->checkcode;
?>