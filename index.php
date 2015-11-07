<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2015/10/28
 * Time: 0:47
 */
$action=$_GET['action'];
if(strpos($action,'/')>-1){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'heheda:)'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
define("PATH_CMS",dirname(__FILE__));
$CMS_PAGE_DIR="";
require $CMS_PAGE_DIR.'libs/config.php' ;
require $CMS_PAGE_DIR.'libs/functions/loadClass.php' ;
if($action!='login' && $action!='loginout'){
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
if(!isset($_GET['action'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$apiFile=PATH_CMS."/sys/".$action.".php";
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