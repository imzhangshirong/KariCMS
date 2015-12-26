<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/26
 */
if(!isset($_GET['catid'])){
	$DB_hits=0;
}
else{
	$catid=$_GET['catid'];
	$DB_mysql=new database();
	$DB_hitsid='c-'.$catid;
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		$DB_hitsid.='-'.$id;
	}
	$DB_hitsid=htmlspecialchars($DB_hitsid,ENT_QUOTES);
	isSQL($DB_hitsid);
	$DB_mysql->query("SELECT * FROM `cms_hits` WHERE hitsid='".$DB_hitsid."'");
	$DB_row=$DB_mysql->result->fetch_assoc();
	$DB_hits=$DB_row["hits"];
}
function isSQL($str){
	$forbid=array('=','/','&','(',')','?','*','#','@','+','{','}','|','"',"'");
	$a=0;
	for($a=0;$a<count($forbid);$a++){
		if(strpos($str,$forbid[$a])>-1){
			$jsonArr=array(
				'code'=>'0',
				'msg'=>'heheda :)'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
	}
}
echo "document.getElementById('hits-".$DB_hitsid."').innerHTML='".$DB_hits."';";