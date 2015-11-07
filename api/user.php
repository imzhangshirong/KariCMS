<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/27
 */
if(!isset($_GET['type'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
else if($_GET['type']=='user'){//用户api
	if(!isset($_GET['method'])){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	$method=$_GET['method'];
	if($method=='insert'){
		if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['authority'])){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'missing parameters'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
		$DB_mysql=new database();
		$sql="SELECT * FROM `cms_admin` WHERE `username`=".$_POST['username'];
		$DB_mysql->query($sql);
		if($DB_mysql->result->num_rows){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'user already exist'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
		$sql="INSERT INTO `cms_admin`(`userid`,`username`,`password`,`lastlogin`,`authority`)
 VALUES (NULL,'".$_POST['username']."','".md5($_POST['password'])."','','".$_POST['authority']."');";
		$DB_mysql->query($sql);
		$jsonArr=array(
			'code'=>'1',
			'msg'=>'add a new user'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);

	}
	else if($method=='modify'){
		if(!isset($_POST['oldusername']) || !isset($_POST['username'])){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'missing parameters'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
		$DB_mysql=new database();
		$sql="SELECT * FROM `cms_admin` WHERE `username`=".$_POST['username'];
		$DB_mysql->query($sql);
		if($DB_mysql->result->num_rows){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'user already exist'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
		$sql="UPDATE `cms_admin` SET ";
		if(isset($_POST['username'])){
			$sql.="`username`='".$_POST['username']."',";
		}
		if(isset($_POST['password'])){
			$sql.="`password`='".md5($_POST['password'])."',";
		}
		if(isset($_POST['authority'])){
			$sql.="`authority`='".$_POST['authority']."',";
		}
		$sql=substr($sql,0,strlen($sql)-1);
		$sql.=" WHERE `username`=".$_POST['oldusername'];
		$DB_mysql->query($sql);
		$jsonArr=array(
			'code'=>'1',
			'msg'=>'modify user:'.$_POST['oldusername']
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	else if($method=='delete'){
		if(!isset($_POST['username'])){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'missing parameters'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
		$DB_mysql=new database();
		$sql="DELETE FROM `cms_admin` WHERE `username`='".$POST['username']."'";
		$DB_mysql->query($sql);
		$jsonArr=array(
			'code'=>'1',
			'msg'=>'delete user:'.$_POST['username']
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	else{
		$jsonArr=array(
			'code'=>'0',
			'error'=>'wrong conmmand'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
}
else if($_GET['type']=='authority'){//权限api
	if(!isset($_GET['method'])){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	$method=$_GET['method'];
	if($method=='get'){
		if(!isset($_POST['username'])){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'missing parameters'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
		$DB_mysql=new database();
		$sql="SELECT * FROM `cms_admin` WHERE `username`='".$POST['username']."'";
		$DB_mysql->query($sql);
		$DB_row=$DB_mysql->result->fetch_assoc();
		$jsonArr=array(
			'code'=>'1',
			'authority'=>$DB_row['auhority']
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	else{
		$jsonArr=array(
			'code'=>'0',
			'error'=>'wrong conmmand'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
}
else if($_GET['type']=='self'){
	if(!isset($_POST['oldusername']) || !isset($_POST['username'])){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	session_start();
	if($_POST['oldusername']==$_SESSION['username'] && $_POST['oldusername']){
		$sql="SELECT * FROM `cms_admin` WHERE `username`=".$_POST['username'];
		$DB_mysql->query($sql);
		if($DB_mysql->result->num_rows){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'user already exist'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
		$sql="UPDATE `cms_admin` SET ";
		if(isset($_POST['username'])){
			$sql.="`username`='".$_POST['username']."',";
		}
		if(isset($_POST['password'])){
			$sql.="`password`='".md5($_POST['password'])."',";
		}
		$sql=substr($sql,0,strlen($sql)-1);
		$sql.=" WHERE `username`=".$_POST['oldusername'];
		$DB_mysql->query($sql);
		$jsonArr=array(
			'code'=>'1',
			'msg'=>'modify user:'.$_POST['oldusername']
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	else{
		$jsonArr=array(
			'code'=>'0',
			'error'=>'not logged in'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
}
else{
	$jsonArr=array(
		'code'=>'0',
		'error'=>'wrong conmmand'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}