<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/26
 */
$hitsid=@$_GET['hitsid'];
$hitsid=htmlspecialchars($hitsid,ENT_QUOTES);
isSQL($hitsid);
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
$DB_mysql=new database();
$sql="UPDATE `cms_hits` SET `hits`=`hits`+1  WHERE `hitsid`='".$hitsid."'";
$DB_mysql->query($sql);
$img=imagecreatetruecolor(1,1);
$bgColor = imagecolorallocate($img, 255, 255, 255);
imagefill($img, 0, 0, $bgColor);
imagecolortransparent ( $img, $bgColor );
header('Content-type:image/gif');
imagepng($img);
?>