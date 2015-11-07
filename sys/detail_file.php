<?php
$file=$_SERVER['DOCUMENT_ROOT']."/".$_GET['file'];
$type=$_GET['type'];
$showfile=$_GET['file'];
if($type!='img'){
	$showfile='sys/images/'.$type.'_b.png';
}
$handle = @fopen($file,"r");
$fstat = @fstat($handle);
echo "<p>文件名：".basename($file)."</p>";
$size=$fstat["size"];
$dw=array('B','KB','MB','GB','TB');
$dw_num=0;
while($size/1024>1){
	$size=$size/1024;
	$dw_num++;
}
echo "<p>文件大小：".round($size,2).$dw[$dw_num];
if($type=='img'){
	$arr = getimagesize($file);
	echo "&nbsp;&nbsp;&nbsp;&nbsp;尺寸：".$arr[0].'x'.$arr[1];
}
echo "</p>";
echo "<p>最后访问时间：".date("Y-m-d h:i:s",$fstat["atime"])."</p>";
echo "<p>最后修改时间：".date("Y-m-d h:i:s",$fstat["mtime"])."</p>";
echo '<script>$("#look_img").attr("src","'.$showfile.'");</script>';
@fclose($handle);