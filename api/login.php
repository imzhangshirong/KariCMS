<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/29
 */
if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['checkcode'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
session_start();
if($_POST['checkcode']!='' && strtolower($_SESSION['checkecode'])==strtolower ($_POST['checkcode'])){
	$forbid=array('=','/','&','(',')','?','*','#','@','+','-','{','}','|','"',"'");
	$a=0;
	$username=$_POST['username'];
	for($a=0;$a<count($forbid);$a++){
		if(strpos($username,$forbid[$a])>-1){
			$jsonArr=array(
				'code'=>'0',
				'msg'=>'heheda :)'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
	}
	$DB_mysql=new database();
	$sql="SELECT * FROM `cms_admin` WHERE `username`='".$_POST['username']."' AND `password`='".md5($_POST['password'])."'";
	$DB_mysql->query($sql);
	if($DB_mysql->result->num_rows){
		$_SESSION['checkecode']='';
		$_SESSION['username']=$_POST['username'];
		$DB_row=$DB_mysql->result->fetch_assoc ();
		$_SESSION['authority']=$DB_row['authority'];//加载用户权限
		$sql="SELECT * FROM `cms_authority`";
		$DB_mysql->query($sql);
		$_SESSION['aulist']=$DB_mysql->all2array();//权限列表
		$reIP=$_SERVER["REMOTE_ADDR"];
		$sql="UPDATE `cms_admin` SET `lastlogin`='".$reIP."'";
		$DB_mysql->query($sql);
		$jsonArr=array(
			'code'=>'1',
			'msg'=>'login successful'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	else{
		$jsonArr=array(
			'code'=>'0',
			'error'=>'login failed'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
}
else{
	$jsonArr=array(
		'code'=>'0',
		'error'=>'checkcode wrong'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}