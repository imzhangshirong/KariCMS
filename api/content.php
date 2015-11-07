<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/26
 */
if(!isset($_GET['method']) || !isset($_GET['catid'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$method=$_GET['method'];
$catid=@htmlspecialchars($_GET['catid'],ENT_QUOTES);
$id=@htmlspecialchars($_GET['id'],ENT_QUOTES);
$title=@htmlspecialchars($_POST['title'],ENT_QUOTES);
$type=@htmlspecialchars($_POST['type'],ENT_QUOTES);
$label=@htmlspecialchars($_POST['label'],ENT_QUOTES);
$listorder=@htmlspecialchars($_POST['listorder'],ENT_QUOTES);
$thumb=@htmlspecialchars($_POST['thumb'],ENT_QUOTES);
session_start();
$username=$_SESSION['username'];
session_write_close();
$keywords=@htmlspecialchars($_POST['keywords'],ENT_QUOTES);
$content=@$_POST['content'];
$desc=str_replace(PHP_EOL, '<br />', @htmlspecialchars($_POST['desc'],ENT_QUOTES));
$DB_mysql=new database();
$DB_mysql->query('SELECT * FROM `cms_category` WHERE catid='.$catid);
$DB_row=$DB_mysql->result->fetch_assoc ();
$DB_table=$DB_row["catdir"];
if($method=='insert'){
	if(!$title || !$content){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	$savePath='/'.date('Y').'/';
	if(!file_exists(PATH_CMS.$savePath)){
		mkdir(PATH_CMS.$savePath);
	}
	$savePath.=date('md').'/';
	if(!file_exists(PATH_CMS.$savePath)){
		mkdir(PATH_CMS.$savePath);
	}
	$urlPage=$savePath.date('His').'.html';
	$sql="INSERT INTO `".$DB_table."`(`id`,`title`,`type`,`thumb`,`label`,`keywords`,`description`,`listorder`,`username`,`inputtime`,`updatetime`,`url`,`content`) VALUES (NULL,'".$title."','".$type."','".$thumb."','".$label."','".$keywords."','".$desc."','".@$listorder."','".$username."',NOW( ),NOW( ),'".$urlPage."','".$content."');";
	$DB_mysql->query($sql);
	$newID=$DB_mysql->getID();
	$sql="INSERT INTO `cms_hits`(`hitsid`,`hits`) VALUES ('c-".$catid."-".$newID."','0');";
	$DB_mysql->query($sql);
	$jsonArr=array(
		'code'=>'1',
		'msg'=>'success',
		'id'=>$newID
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
else if($method=="modify"){
	if(!$id || !$title || !$content){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	$sql="SELECT * FROM `".$DB_table."` WHERE `id`='".$id."'";
	$DB_mysql->query($sql);
	$DB_row=$DB_mysql->result->fetch_assoc ();
	if($DB_row['title']!=$title || $DB_row['content']!=$content || $DB_row['description']!=$desc ||
		$DB_row['type']!=$type || $DB_row['label']!=$label || $DB_row['keywords']!=$keywords){
		$sql="UPDATE `".$DB_table."` SET `title`='".$title."', `type`='".$type."', `label`='".$label."', `thumb`='".$thumb."', `description`='".$desc."', `keywords`='".$keywords."', `listorder`='".$listorder."', `content`='".$content."', `username`='".$username."', `updatetime`= NOW( ) WHERE `id`=".$id;
	}
	else{
		$sql="UPDATE `".$DB_table."` SET `title`='".$title."', `type`='".$type."', `label`='".$label."', `thumb`='".$thumb."', `description`='".$desc."', `keywords`='".$keywords."', `listorder`='".$listorder."', `content`='".$content."', `username`='".$username."' WHERE `id`=".$id;
	}

	$DB_mysql->query($sql);
}
else if($method=="delete"){
	if(!$id){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	if(strpos($id,'|')>0){
		$arr=explode('|',$id);
		$sql_='';
		for($a=0;$a<count($arr);$a++){
			$sql_.="`id`='".$arr[$a]."'";
			if($a<count($arr)-1){
				$sql_.=" or ";
			}
		}
	}
	else{
		$sql_.="`id`='".$id."'";
	}
	$sql="DELETE FROM `".$DB_table."` WHERE ".$sql_;
	$DB_mysql->query($sql);
}
else{
	$jsonArr=array(
		'code'=>'0',
		'error'=>'wrong command'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$jsonArr=array(
	'code'=>'1',
	'msg'=>'success'
);
$jsonData=json_encode($jsonArr);
die($jsonData);
?>