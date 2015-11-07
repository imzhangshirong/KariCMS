<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2015/10/27
 * Time: 17:39
 */
if(!isset($_GET['action'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$action=$_GET['action'];
if(strpos($action,'/')>-1){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'heheda:)'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
define("PATH_CMS",dirname(__FILE__)); //后不带/
$CMS_PAGE_DIR="";
require $CMS_PAGE_DIR.'libs/config.php' ;
require $CMS_PAGE_DIR.'libs/functions/loadClass.php' ;
if($action!='captcha' && $action!='login' && $action!='statistic' && $action!='count'){
	session_start();
	if(!@$_SESSION['username']){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'not logged in'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	session_write_close();
	//require $CMS_PAGE_DIR.'libs/authority.php' ;
}
$apiFile=PATH_CMS."/api/".$action.".php";
if(file_exists($apiFile)){
	require $apiFile;
}
else{
	$jsonArrayData=array(
		'code'=>'0',
		'error'=>'Api does not exist'
	);
	$jsonData=json_encode($jsonArrayData);
	die($jsonData);
}
?>