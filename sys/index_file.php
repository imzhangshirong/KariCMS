<div style="width: 40%;height: 100%;overflow: hidden;float: left">
	<ul id="list_uploadfile" class="treeList" style="padding:15px 10px;height: 80%">
		<?php
		$dir_='upload/';
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
					echo "<li class='dir' type='dir' path='".$dir_.$file."/'>".$file."<ul></ul></li>";
					closedir($isdir);
				}
				else{
					echo "<li path='".$dir_.$file."' class='".$type."' type='".$type."'>".$file."</li>";
				}
			}
		}
		?>
	</ul>
	<div class="cms_page" style="position: absolute;bottom: 10px;">
		<p><button onclick="deleteFile()" style="margin-left: 20px" class="del">删除</button></p>
		<p style="color: gray;font-size: 12px;margin-top:10px;margin-left: 20px ">请谨慎操作！！</p>
	</div>
</div>
<div style="width: 56%;height: 100%;overflow: hidden;float: left;margin-left: 20px;text-align: center;
background-color: #f5f5f5;position: relative">
	<img src="sys/images/other_b.png" style="max-width: 80%;margin-top: 60px;max-height: 55%" id="look_img">
	<div id="detail_file" style="position:absolute;width: 80%;left: 10%;text-align:inherit;height: 130px;bottom: 64px;line-height:30px">
		<p class='msg' style="font-size: 20px">选择文件，查看详情<br><span style='font-size: 20px'></span></p>
	</div>
</div>
<script src="sys/js/treeList.js"></script>
<script>
    $('#list_uploadfile').css('height',$(window).height()-120+'px');
	var path_page='<?=PATH_HOST_HTTP?>';
	treeList_init(
		function(e){
			var dir=e.attr('path');
			e.children('ul').html('loading...');
			$.ajax({
				url:'index.php?action=list_file&dir='+dir,
				type:'get',
				success:function(data){
					e.children('ul').html(data);
					treeList_bond();
					//console.log(data);
				}
			});
		},function(e){
			$('#detail_file').html("<p class='msg'>Loading...<br><span style='font-size: 20px'>正在加载中</span></p>");
			$('#look_img').attr('src','sys/images/loading.png');
			$.ajax({
				url:'index.php?action=detail_file&file='+e.attr('path')+'&type='+ e.attr('type'),
				type:'get',
				success:function(data){
					$('#detail_file').html(data);
				}
			});
		}
	);
	$('.treeList li').each(function(){
		$(this).children('.treeButton').html('+');
		$(this).css('height',$(this).css('line-height'));
	});
	function deleteFile(){
		var allFile="";
		$('.treeList li').each(function(){
			if($(this).children('input')[0]['checked']){
				if($(this).attr('type')!='dir'){
					allFile+=$(this).attr('type')+":"+$(this).attr('path')+"|";
				}
			}
		});
		linkAPI('api.php?action=deletefile','post',{'file':allFile},function(){getPage(funcData['1.2'])
		;});
	}
</script>