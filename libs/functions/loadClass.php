<?php
/**
 * Created by PhpStorm.
 * User: Jarvis
 * Date: 2015/10/22
 * Time: 0:01
 */
funcLoadClassFile($CMS_PAGE_DIR);
function funcLoadClassFile($dirc){
	$fileArr=funcListClassFile($dirc."libs/classes");
	for($a=0;$a<count($fileArr);$a++){
		require $fileArr[$a];
	}
}
function funcListClassFile($dir)
{
	$dp = opendir($dir);
	$fileArr = array();
	while (!false == $curFile = readdir($dp)) {
		if ($curFile!="." && $curFile!=".." && $curFile!="") {
			if (!is_dir($curFile) && substr($curFile,-10)==".class.php") {
				$fileArr[] = $dir."/".$curFile;
			}
		}
	}
	return $fileArr;
}
?>