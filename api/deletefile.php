<?php
if(!isset($_POST['file'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$file=$_POST['file'];
if(strpos($file,'./')>-1){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'heheda:)'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$arr=explode('|',$file);
$a=0;
$b=0;
for($a=0;$a<count($arr);$a++){
	if($arr[$a]!=""){
		$arr_=explode(':',$arr[$a]);
		if(count($arr_)==2){
			$file_=$_SERVER['DOCUMENT_ROOT']."/".$arr_[1];
			if($arr_[0]!="dir"){
				if(unlink($file_)){
					$b++;
				}
			}
		}
	}
}
$jsonArr=array(
	'code'=>'1',
	'files'=>$b
);
$jsonData=json_encode($jsonArr);
die($jsonData);
?>