<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/25
 */
//define("PATH_HOST","http://".$_SERVER["HTTP_HOST"].substr(dirname($_SERVER['SCRIPT_NAME']),0,strlen(dirname($_SERVER['SCRIPT_NAME']))-1));//后不带/
if(!isset($_GET['catid']) || !isset($_GET['type'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}

$type_template=$_GET['type'];
$DB_mysql=new database();
$DB_mysql->query('SELECT * FROM `cms_category` WHERE catid='.$_GET['catid']);
$DB_row=$DB_mysql->result->fetch_assoc ();
$DB_table=$DB_row["catdir"];
$template_list=$DB_row["template_list"];
$template_page=$DB_row["template_page"];
$maxPage=1;
$page=1;
if($type_template=='page'){
	if(!isset($_GET['id'])){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	if(strpos($_GET['id'],'|')>0){
		$id=explode('|',$_GET['id']);
	}
	else{
		$id=array($_GET['id']);
	}
	$html=array();
	$id_check=array();
	$a=0;
	for($a=0;$a<count($id);$a++){
		if($id[$a]){
			$id_check[]=$id[$a];
		}
	}
	$id=$id_check;
	for($a=0;$a<count($id);$a++){
		$DB_mysql->query('SELECT * FROM `'.$DB_table.'` WHERE `id`='.$id[$a]);
		$DB_row=$DB_mysql->result->fetch_assoc ();
		$html[]=$DB_row['url'];
	}
	$file=PATH_CMS.PATH_TEMPLATES.$template_page;
}
else if($type_template=='list'){
	$file=PATH_CMS.PATH_TEMPLATES.$template_list;
}
else{
	$jsonArr=array(
		'code'=>'0',
		'error'=>'wrong conmmand'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$url=basename($file.'.'.$DB_table.".php");
$hostpath=PATH_CMS.PATH_CACHE.$url;//php文件路径
$httppath=PATH_HOST_HTTP.PATH_CACHE.$url;//php文件http路径，访问以获取静态页内容
//----------------------------生成php模板---------------------------------
$data='';
$fHandle=@fopen($file,'r');
if($fHandle){
	while(!feof($fHandle)){
		$data.=fgets($fHandle);
	}
}
else{
	$jsonArr=array(
		'code'=>'0',
		'error'=>'template open failed'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
@fclose($fHandle);
//////////////////////////////////解析数据过程//////////////////////////////////////
preg_match_all('|{(.*?)}|',$data,$out, PREG_PATTERN_ORDER);
$match_orig=$out[1];
$match=$out[1];
for($a=0;$a<count($match);$a++){
	$match[$a]=trim(rtrim($match[$a])).' ';
	preg_match_all('|(.*?)[ ]+|',$match[$a],$out, PREG_PATTERN_ORDER);
	$match[$a]=$out[1];
	for($b=0;$b<count($match[$a]);$b++){
		preg_match_all("|(.*?)[ ]*=|",$match[$a][$b],$out1,PREG_PATTERN_ORDER);
		if(count($out1[1])>0){
			preg_match_all("|[ ]*["."'".'"'."](.*?)['".'"]|',$match[$a][$b],$out2,PREG_PATTERN_ORDER);
			$temp=array('name'=>"",'value'=>"");
			if(count($out2[1])>0){
				$temp['name']=$out1[1][0];
				$temp['value']=$out2[1][0];
				$match[$a][$b]=$temp;
			}
		}
		else{
			if($match[$a][$b]=="mc"){
				$temp['name']=$match[$a][$b];
				$temp['value']="";
				$match[$a][$b]=$temp;
			}
		}
	}
}
$matchReplacePHP=codeReplacePHP($match,$match_orig);//替换所有php语法
$codeRunData=codeReplaceData($data,$match_orig,$matchReplacePHP);//转换后的可执行php代码
if($type_template=='list'){
	$relaceHead="<?php ini_set('display_errors','Off'); ".'$CMS_PAGE_DIR="../"'.";require ".'$CMS_PAGE_DIR'.".'libs/config.php';require ".'$CMS_PAGE_DIR'.".'libs/config_parse.php';require ".'$CMS_PAGE_DIR'.".'libs/functions/loadClass.php';require ".'$CMS_PAGE_DIR'.".'libs/global.php';".'$page=@$_GET["page"];$maxPage=@$_GET["maxPage"]; ?>';//生成php文件所需的头部
}
else if($type_template=='page'){
	$relaceHead="<?php ini_set('display_errors','Off'); ".'$CMS_PAGE_DIR="../"'.";require ".'$CMS_PAGE_DIR'.".'libs/config.php';require ".'$CMS_PAGE_DIR'.".'libs/config_parse.php';require ".'$CMS_PAGE_DIR'.".'libs/functions/loadClass.php';require ".'$CMS_PAGE_DIR'.".'libs/global.php';". '$id=$_GET["id"];
$DB_mysql=new database();
$DB_mysql->query("SELECT * FROM `'.$DB_table.'` WHERE `id`=".$'.'id);
$DB_row=$DB_mysql->result->fetch_assoc ();
$title=$DB_row["title"];
$type=$DB_row["type"];
$label=$DB_row["label"];
$keywords=$DB_row["keywords"];
$description=$DB_row["description"];
$content=$DB_row["content"];
$url=$DB_row["url"];
$inputtime=$DB_row["inputtime"];
$updatetime=$DB_row["updatetime"];
$catid='.$_GET['catid'].';
//$DB_mysql->query("SELECT * FROM `cms_hits` WHERE `hitsid`='."'c-".$_GET['catid'].'-".$id."'."'".'");
//$DB_row=$DB_mysql->result->fetch_assoc ();
//$hits=$DB_row["hits"];
$hitsid="c-'.$_GET['catid'].'-".$'.'id'.';?>';
//生成php文件所需的头部
}
$codeRunData=$relaceHead.$codeRunData;
codePutout($hostpath,$codeRunData);//输出php文件
//////////////////////////////////解析数据过程结束//////////////////////////////////////
//----------------------------调用php模板生成html---------------------------------
if($type_template=='list'){
	for($a=1;$a<=$maxPage;$a++){
		$page=$a;
		$temp_get_data_replace=curl_get($httppath."?page=".$a.'&maxPage='.$maxPage).'<img src="../api.php?action=statistic&hitsid=c-'.$_GET['catid'].'">';
		$filename=PATH_CMS.'/'.$DB_table.'/index';
		if($a>1){
			$filename.=$a;
		}
		$filename.=".html";
		codePutout($filename,$temp_get_data_replace);
	}
	$jsonArr=array(
		'code'=>'1',
		'pages'=>$maxPage,
		'cache'=>$url
	);
}
else if($type_template=='page'){
	for($a=0;$a<count($id);$a++){
		$temp_get_data_replace=curl_get($httppath."?id=".$id[$a]).'<img src="../../api.php?action=statistic&hitsid=c-'
			.$_GET['catid'].'-'.$id[$a].'">';
		$filename=PATH_CMS.$html[$a];
		codePutout($filename,$temp_get_data_replace);
	}

	$jsonArr=array(
		'code'=>'1',
		'pages'=>count($id),
		'cache'=>$url
	);
}
$jsonData=json_encode($jsonArr);
die($jsonData);
?>
<?php
function codePutout($fileName,$data){
	$fileHandle=@fopen($fileName,"x");
	if(!$fileHandle){
		@unlink($fileName);
		$fileHandle=@fopen($fileName,"x");
	}
	@fwrite ( $fileHandle,$data);
	@fclose($fileHandle);
}
function codeReplaceData($data,$match_orig,$matchReplacePHP){
	$tempdata=$data;
	$pos2=0;
	for($a=0;$a<count($match_orig);$a++){
		$pos1=strpos($tempdata,$match_orig[$a],$pos2);
		$tempdata=substr_replace($tempdata,$matchReplacePHP[$a],$pos1-1,strlen($match_orig[$a])+2);
		$pos2=$pos1+2+strlen($match_orig[$a]);
	}
	return $tempdata;
}
function codeReplacePHP($match,$match_orig){
	$matchReplace=array();
	$mpo=array(0,count($match)-1);
	for($a=0;$a<=$mpo[0];$a++){
		$matchReplace[]="";
	}
	for($a=$mpo[0];$a<=$mpo[1];$a++){
		if(substr($match_orig[$a],0,1)==' '){
			$matchReplace[$a]="{".$match_orig[$a]."}";
			continue;
		}
		$dataReplace[]="";
		if($match[$a][0]=="php"){
			$temp="<?".$match_orig[$a]."?>";
			$matchReplace[$a]=$temp;
		}
		else if($match[$a][0]=="loop"){
			if(count($match[$a])==3){
				$temp="<?php if(is_array(".$match[$a][1].")) foreach(".$match[$a][1]." AS ".$match[$a][2].") { ?>";
			}
			else if(count($match[$a])==4){
				$temp="<?php if(is_array(".$match[$a][1].")) foreach(".$match[$a][1]." AS ".$match[$a][2]."=>".$match[$a][3].") { ?>";
			}
			$matchReplace[$a]=$temp;
		}
		else if($match[$a][0]=="/loop"){
			$temp="<?php } ?>";
			$matchReplace[$a]=$temp;
		}
		else if($match[$a][0]=="if"){
			$temp="<?php ".$match[$a][0]."(";
			$temp_="";
			for($b=1;$b<count($match[$a]);$b++){
				if($b+1<count($match[$a])){
					$temp_.=$match[$a][$b]." ";
				}
				else{
					$temp_.=$match[$a][$b];
				}
			}
			$temp.=$temp_."){ ?>";
			$matchReplace[$a]=$temp;
		}
		else if($match[$a][0]=="/if"){
			$temp="<?php } ?>";
			$matchReplace[$a]=$temp;
		}
		else if($match[$a][0]=="/mc"){
			$temp="";
			$matchReplace[$a]=$temp;
		}
		else if($match[$a][0]['name']=="mc"){
			$mcdata=array();
			$array1=array();
			$array2=array();
			for($b=0;$b<count($match[$a]);$b++){
				$array1[]=$match[$a][$b]['name'];
				$array2[]=$match[$a][$b]['value'];
			}
			$mcdata=array_combine($array1,$array2);
			$replaceHead='$DB_mysql=new database();$DB_mysql->query("SELECT * FROM `cms_category` WHERE catid='.$mcdata['catid'].'");$DB_row=$DB_mysql->result->fetch_assoc ();$DB_table=$DB_row["catdir"];';
			$sql='"SELECT * FROM `".$DB_table."`';
			if(isset($mcdata['listorder'])){
				if($mcdata['listorder']=="0")$temp="id ASC";
				if($mcdata['listorder']=="1")$temp="id DESC";
				if($mcdata['listorder']=="2")$temp="listorder ASC";
				if($mcdata['listorder']=="3")$temp="listorder DESC";
				if($mcdata['listorder']=="4")$temp="listorder ASC,id ASC";
				if($mcdata['listorder']=="5")$temp="listorder DESC,id DESC";
				$sql.=" ORDER BY ".$temp;
			}
			if(isset($mcdata['num'])){
				if(isset($mcdata['page']) && $mcdata['page']==1){
					$sqlcount=$replaceHead.'$DB_mysql->query('.$sql.'");$DB_count=$DB_mysql->result->num_rows;';
					eval($sqlcount);
					$page_=ceil($DB_count/$mcdata['num']);
					global $maxPage;
					if($maxPage<$page_){
						$maxPage=$page_;
					}
					$sql.=' LIMIT ".'.'(($page-1)*'.$mcdata['num'].').",'.$mcdata['num'];
				}
				else{
					$sql.=' LIMIT '.$mcdata['num'];
				}
			}
			$sql.='"';
			$temp="data";
			if(isset($mcdata['return']))$temp=$mcdata['return'];
			$temp=$replaceHead.'$DB_mysql->query('.$sql.');$'.$temp.'=$DB_mysql->all2array();';
			$temp="<?php ".$temp." ?>";
			$matchReplace[$a]=$temp;

		}
		else{
			$temp="<?=".$match_orig[$a]."?>";
			$matchReplace[$a]=$temp;
		}
	}
	for($a=$mpo[1]+1;$a<count($match);$a++){
		$matchReplace[]="";
	}
	return $matchReplace;
}
function codeSplit($data,$matchOri,$codeRange,$codePos){
	$pos=strpos($data,$matchOri[$codeRange[0]],$codePos);
	$pos_=strpos($data,$matchOri[$codeRange[1]],$pos)+strlen($matchOri[$codeRange[1]]);
	return substr($data,$pos,$pos_-$pos);
}
// 创建一个新cURL资源
function curl_get($url){
	$defaults = array(
		CURLOPT_URL => $url,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => TRUE,
	);
	$ch = curl_init();
	curl_setopt_array($ch, $defaults);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
?>
