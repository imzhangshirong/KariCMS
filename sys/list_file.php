<div class="line"></div>
<?php
$dir_=@$_GET['dir'];
$dir=$_SERVER['DOCUMENT_ROOT']."/".$dir_;
$dp = opendir($dir);
while (false !== ($file = readdir($dp))) {
	if($file!="." && $file!=".." && $file!=""){
		$isdir=@opendir($dir.$file);
		$img='/.jpg/.gif/.png/.jpeg/.jpe/';
		$rar='/.rar/.7z/.iso/.zip/.gz/.tar/';
		$web='/.html/.htm/.jsp/.js/.css/.aps/.php/.exe/';
		$type='other';
		$temp0="/".substr($file,-3)."/";
		$temp1="/".substr($file,-4)."/";
		$temp2="/".substr($file,-5)."/";
		if(strpos($img,$temp0)>-1){$type='img';}
		if(strpos($img,$temp1)>-1){$type='img';}
		if(strpos($img,$temp2)>-1){$type='img';}
		if(strpos($rar,$temp0)>-1){$type='rar';}
		if(strpos($rar,$temp1)>-1){$type='rar';}
		if(strpos($rar,$temp2)>-1){$type='rar';}
		if(strpos($web,$temp0)>-1){$type='web';}
		if(strpos($web,$temp1)>-1){$type='web';}
		if(strpos($web,$temp2)>-1){$type='web';}
		if($isdir){
			echo "<li class='dir' type='dir' path='".$dir_.$file."/'><div class='treeButton'>+</div><input type='checkbox'>".$file."<ul></ul></li>";
			closedir($isdir);
		}
		else{
			echo "<li path='".$dir_.$file."' class='".$type."' type='".$type."'><input type='checkbox'>".$file."</li>";
		}
	}
}
?>