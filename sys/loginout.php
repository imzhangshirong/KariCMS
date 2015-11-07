<?php
session_start();
session_unset();
session_destroy();
$jsonArr=array(
	'code'=>'1',
	'msg'=>'login out'
);
$jsonData=json_encode($jsonArr);
die($jsonData);
?>