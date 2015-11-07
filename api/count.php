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
	$DB_mysql->query("SELECT * FROM `cms_hits` WHERE hitsid='".$DB_hitsid."'");
	$DB_row=$DB_mysql->result->fetch_assoc();
	$DB_hits=$DB_row["hits"];
}
echo "document.getElementById('hits-".$DB_hitsid."').innerHTML='".$DB_hits."';";