<?php
/**
 * Created by Jarvis.
 * Date: 2015/10/26
 */

function page($prev=1,$next=1,$show=8){
	$pageData="";
	global $page;
	global $maxPage;
	if($maxPage<=$show){
		for($a=1;$a<=$maxPage;$a++){
			$url="index";
			if($a>1){
				$url.=$a;
			}
			$url.=".html";
			if($a==$page){
				$pageData.='<a class="page_now">'.$a.'</a>';
			}
			else{
				$pageData.='<a href="'.$url.'">'.$a.'</a>';
			}
		}
	}
	else{

		$start=$page-ceil($show/2);
		if($start<=0){$start=1;}
		else if($start>2){
			$pageData.="...";
		}
		if($start>=2){
			$pageData='<a href="index.html">1</a>'.$pageData;
		}
		for($a=$start;$a<=$maxPage && $a-$start<$show;$a++){
			$url="index";
			if($a>1){
				$url.=$a;
			}
			$url.=".html";
			if($a==$page){
				$pageData.='<a class="page_now">'.$a.'</a>';
			}
			else{
				$pageData.='<a href="'.$url.'">'.$a.'</a>';
			}
		}
		if($start+$show<$maxPage){
			$pageData.="...";
		}
		if($start+$show-1<$maxPage){
			$pageData.='<a href="index'.$maxPage.'.html">1</a>';
		}
	}
	if($maxPage>1){
		if($prev){
			if($page>1){
				$url="index";
				if($page>2){
					$url.=$page-1;
				}
				$url.=".html";
				$pageData='<a href="'.$url.'" class="page_prev">上一页</a>'.$pageData;
			}
		}
		if($next){
			if($page<$maxPage){
				$url="index";
				$url.=$page+1;
				$url.=".html";
				$pageData.='<a href="'.$url.'" class="page_next">下一页</a>';
			}
		}
	}
	return $pageData;
}