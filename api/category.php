<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/26
 */
if(!isset($_GET['method'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$method=$_GET['method'];
$catid=@htmlspecialchars($_GET['catid'],ENT_QUOTES);
if($method!="delete"){
	$catname=@htmlspecialchars($_POST['catname'],ENT_QUOTES);
	$catdir=@htmlspecialchars($_POST['catdir'],ENT_QUOTES);
	$template_list=@htmlspecialchars($_POST['template_list'],ENT_QUOTES);
	$template_page=@htmlspecialchars($_POST['template_page'],ENT_QUOTES);
	$url=@htmlspecialchars($_POST['url'],ENT_QUOTES);
	$listorder=@htmlspecialchars($_POST['listorder'],ENT_QUOTES);
	if(!$catname || !$catdir || !$template_list || !$template_page || !$url){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	if($template_list ==$template_page){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'template_list is not same as template_page'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
}
$DB_mysql=new database();
if($method=="insert"){
	$savePath='/'.$catdir.'/';
	if(!file_exists(PATH_CMS.$savePath)){
		mkdir(PATH_CMS.$savePath);
	}
	else{
		$jsonArr=array(
			'code'=>'0',
			'error'=>'dir already existed'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	$sql="INSERT INTO `cms_category` (`catid`,`catname`,`catdir`,`url`,`template_list`,`template_page`,`listorder`,`hits`)
VALUES(NULL,'".$catname."','".$catdir."','".$url."','".$template_list."','".$template_page."',
'".$listorder."','0');";
	$DB_mysql->query($sql);
	$newID=$DB_mysql->getID();
	$sql="CREATE TABLE ".$catdir."
		(
			id int not null  auto_increment,
			title varchar(120) not null,
			type varchar(30) not null,
			thumb varchar(100) not null,
			label varchar(120) not null,
			keywords varchar(80) not null,
			description mediumtext not null,
			listorder int not null default 0,
			username varchar(30) not null,
			inputtime datetime not null,
			updatetime datetime not null,
			url varchar(150) not null,
			content mediumtext not null,
			relation varchar(128) not null,
			primary key(id)
		)engine=MyISAM default charset=utf8 auto_increment=1;";
	$DB_mysql->query($sql);
	$sql="INSERT INTO `cms_hits`(`hitsid`,`hits`) VALUES ('c-".$newID."','0');";
	$DB_mysql->query($sql);
}
else if($method=="modify") {
	if (!$catid) {
		$jsonArr = array(
			'code' => '0',
			'error' => 'missing parameters'
		);
		$jsonData = json_encode($jsonArr);
		die($jsonData);
	}
	$sql="SELECT * FROM `cms_category` WHERE `catid`='".$catid."'";
	$DB_mysql->query($sql);
	$DB_row=$DB_mysql->result->fetch_assoc ();
	$old_catdir=$DB_row["catdir"];
	$sql = "UPDATE `cms_category` SET `catname`='" . $catname . "',";
	if($old_catdir!=$catdir){
		$sql_="RENAME TABLE `".$old_catdir."` TO `".$catdir."`";
		$DB_mysql->query($sql_);
		if(!rename(PATH_CMS."/".$old_catdir,PATH_CMS."/".$catdir)){
			$jsonArr = array(
				'code' => '0',
				'error' => "rename '".$old_catdir."' to '".$catdir."' failed"
			);
			$jsonData = json_encode($jsonArr);
			die($jsonData);
		}
		$sql.="`catdir`='".$catdir."',";
	}
	$sql.="`url`='".$url."',`template_list`='".$template_list."',`template_page`='".$template_page."',`listorder`='".$listorder."' WHERE `catid`=".$catid;
	$DB_mysql->query($sql);
}
else if($method=="delete"){
	if(!$catid){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	if(strpos($catid,'|')>0){
		$arr=explode('|',$catid);
		$sql_='';
		for($a=0;$a<count($arr)-1;$a++){
			$sql_.="`catid`='".$arr[$a]."'";
			if($a<count($arr)-2){
				$sql_.=" or ";
			}
			$DB_mysql->query("SELECT * FROM `cms_category` WHERE `catid`='".$arr[$a]."'");
			$DB_row=$DB_mysql->result->fetch_assoc ();
			$DB_table=$DB_row["catdir"];
			$sql="RENAME TABLE `".$DB_table."` TO  `del_".$DB_table."`";
			$DB_mysql->query($sql);
		}
	}
	else{
		$DB_mysql->query("SELECT * FROM `cms_category` WHERE `catid`='".$catid."'");
		$DB_row=$DB_mysql->result->fetch_assoc ();
		$DB_table=$DB_row["catdir"];
		$sql="RENAME TABLE `".$DB_table."` TO  `del_".$DB_table."`";
		$DB_mysql->query($sql);
		$sql_.="`catid`='".$catid."'";
	}
	$sql="DELETE FROM `cms_category` WHERE ".$sql_;
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
