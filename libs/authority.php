<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2015/10/24
 * Time: 23:36
 */
$actionCode=0;
session_start();
$aulist=$_SESSION['aulist'];
$authority=$_SESSION['authority'];
session_write_close();
for($a=0;$a<count($aulist);$a++){
	if($aulist[$a]['name']==$action){
		$actionCode=$aulist[$a]['auid'];
		break;
	}
}
if($actionCode==0){
}
preg_match_all('|(.*?)[/]+|',$authority,$out, PREG_PATTERN_ORDER);
for($a=0;$a<count($out[1]);$a++){
	preg_match_all('|(.*)[:](.*)|',$out[1][$a],$out_, PREG_PATTERN_ORDER);
	if(is_numeric($out_[2][0])){
		if($actionCode==$out_[1][0] && $out_[2][0]==0){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'no permission to access'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
	}
	else{
		preg_match_all('|(.*?)[[](.*?)[]]|',$out_[2][0],$out_1, PREG_PATTERN_ORDER);
		if($out_1[1][0]==0){
			$jsonArr=array(
				'code'=>'0',
				'error'=>'no permission to access'
			);
			$jsonData=json_encode($jsonArr);
			die($jsonData);
		}
		else{
			preg_match_all('|(.*?)[!]|',$out_1[2][0],$out_2, PREG_PATTERN_ORDER);
			for($a=0;$a<count($out_2[1]);$a++){
				if($out_2[1][$a]==@$catid){
					$jsonArr=array(
						'code'=>'0',
						'error'=>'no permission to access'
					);
					$jsonData=json_encode($jsonArr);
					die($jsonData);
				}
			}
		}

	}
}
?>