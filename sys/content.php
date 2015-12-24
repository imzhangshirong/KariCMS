<?php
if(!isset($_GET['method']) || !isset($_GET['catid'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$method=$_GET['method'];
$catid=$_GET['catid'];
$DB_mysql=new database();
$DB_mysql->query('SELECT * FROM `cms_category` WHERE catid='.$catid);
$DB_row=$DB_mysql->result->fetch_assoc ();
$DB_table=$DB_row["catdir"];
if($method=='insert'){
	$title="";
	$type="";
	$label="";
	$keywords="";
	$desc="";
	$content="";
	$listorder=0;
}
else if($method=='modify'){
	if(!isset($_GET['id'])){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	$id=$_GET['id'];
	$sql="SELECT * FROM `".$DB_table."` WHERE `id`='".$id."'";
	$DB_mysql->query($sql);
	$DB_row=$DB_mysql->result->fetch_assoc ();
	$title=$DB_row['title'];
	$type=$DB_row['type'];
	$label=$DB_row['label'];
	$keywords=$DB_row['keywords'];
	$desc=str_replace('<br />',"\n", $DB_row['description']);
	$listorder=$DB_row['listorder'];
	$content=$DB_row['content'];
	$url=$DB_row['url'];
	$thumb=$DB_row['thumb'];
<<<<<<< HEAD
	$relation=$DB_row['relation'];
=======
>>>>>>> parent of 746edef... Revert "Alpha 1.0.0.5"
}
else{
	$jsonArr=array(
		'code'=>'0',
		'error'=>'wrong command'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
?>
<div style="width:100%;overflow: auto;height: 86%;padding:20px 0px">
	<div class="cms_page" style="width:1000px;" id="content">
<<<<<<< HEAD
		<img id="thumb" width="160px" height="120px" style="float: left;display: block" src="<?=$thumb?>" data="<?=$thumb?>">
=======
		<img id="thumb" width="160px" height="120px" style="float: left;display: block" src="<?=$thumb?>">
>>>>>>> parent of 746edef... Revert "Alpha 1.0.0.5"
		<form id="uploadimg" style="float: left;display: block;margin-left: 20px;margin-bottom: 10px">
			<p><label>文章图片：</label><input name="upfile" type="file" style="height: 24px;line-height: 24px;width:
			300px"></p>
		</form>
		<script>
			function uploadImg(){
				$('#upload').html("正在上传");
				$('#upmsg').html("正在上传图片...");
				$('#upload').css("background-color","#666666");
				$('#upload').attr('disabled','true');
				doUpload('#uploadimg',function(e){
					var json=JSON.parse(e);
					var url=json.url;
					if(url){
						$('#upmsg').html("上传图片成功");
						url=url.replace(/\\/, "");
						console.log(url);
						$('#thumb').attr('src',url);
						$('#thumb').attr('data',url);
					}
					else{
						$('#upmsg').html("上传图片失败，请重试");
					}
					$('#upload').html("重新上传");
					$('#upload').css("background-color","#4285F4");
					$('#upload').removeAttr('disabled');

				});
			}
		</script>
		<button onclick="uploadImg()" class="upload" id="upload" style="margin: 1px 0px;
		">上传图片</button><span id="upmsg" style="margin-left: 20px;line-height: 30px"></span>
<<<<<<< HEAD
		<div style="float: left;margin-left: 20px"><p style="margin-bottom: 10px"><label>文章标题：</label><input id="title" style="width: 300px" value="<?=$title?>"><label>类型：</label><input id="type" style="width: 80px" value="<?=$type?>"><label>标签：</label><input id="label" style="width: 200px" value="<?=$label?>"></p>
			<p><label>关键字词：</label><input id="keywords"  value="<?=$keywords?>" style="width: 300px"><label>排序：</label><input id="listorder" style="width: 80px"  value="<?=$listorder?>"><label>跳转：</label><input id="relation" style="width: 200px" value="<?=$relation?>"></p>
=======
		<div style="float: left;margin-left: 20px"><p style="margin-bottom: 10px"><label>文章标题：</label><input id="title" style="width: 300px" value="<?=$title?>"><label>类型：</label><input id="type" style="width: 80px" value="<?=$type?>"><label>标签：</label><input id="label" style="width: 120px" value="<?=$label?>"></p>
			<p><label>关键字词：</label><input id="keywords"  value="<?=$keywords?>" style="width: 300px"><label>排序：</label><input id="listorder" style="width: 80px"  value="<?=$listorder?>"></p>
>>>>>>> parent of 746edef... Revert "Alpha 1.0.0.5"
		</div>

		<p style="margin-top: 10px"><label>描述：</label></p><textarea style="width: 99.5%;height: 50px;margin-bottom:10px" id="desc"><?=$desc?></textarea>
		<script id="editor" type="text/plain" style="width:1000px;height:260px;"></script>
		<div id="data" style="display: none"><?=$content?></div>
		<p style="margin: 10px"><button onclick="saveData()" class="modify">保存</button></p>
	</div>
	</div>
<script type="text/javascript">
	//实例化编辑器
	//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	var ue = UE.getEditor('editor');
	var method='<?=$method?>';
	var id='<?=@$id?>';
	//var url='<?=@$url?>';
	var api='api.php?action=content&method=<?=$method?>&catid=<?=$catid?>';
	var apiPage='api.php?action=parse&catid=<?=$catid?>';
	var apiCategory='api.php?action=parse&type=list&catid=<?=$catid?>';
	ue.ready(function() {
		var data=$('#data').html();
		ue.setContent(data);
	});
	function saveData(){
		var title=document.getElementById("title").value;
		var type=document.getElementById("type").value;
		var label=document.getElementById("label").value;
		var keywords=document.getElementById("keywords").value;
		var desc=document.getElementById("desc").value;
		var listorder=document.getElementById("listorder").value;
		var content=ue.getContent();
<<<<<<< HEAD
		var thumbPic=document.getElementById("thumb").getAttribute('data');
		var relation=document.getElementById("relation").value;
		var data={title:title,type:type,label:label,keywords:keywords,desc:desc,content:content,username:'test',listorder:listorder,thumb:thumbPic,relation:relation};
=======
		var thumbPic=$('#thumb').attr('data');
		var data={title:title,type:type,label:label,keywords:keywords,desc:desc,content:content,username:'test',listorder:listorder,thumb:thumbPic};
>>>>>>> parent of 746edef... Revert "Alpha 1.0.0.5"
		if(method=="modify"){
			api=api+'&id='+id;
			apiPage=apiPage+'&id='+id;
		}
		else if(method=="insert"){
			//data['url']=url;
		}
		ue.destroy();
		$('#up_container').css({'width':'400px','height':'300px'});
		TweenMax.fromTo(document.getElementById('upshadow'),0.5,{'display':'none','opacity':'0'},{'display':'block','opacity':'1'});
		$('#up_container').html("<p class='msg'>Processing...<br><span style='font-size: 20px'>正在操作中</span></p>");
		$.ajax({
			type:'post',
			url:api,
			data:data,
			success: function(data) {
				var json=JSON.parse(data);
				if(json['code']==0){
					alert(data);
					upClose(function(){$("#category_list .select").trigger('click');});
				}
				else{
					id=json['id'];
					if(id>0){
						$.ajax({
							type:'get',
							url:apiPage+'&type=page&id='+id,
							success: function(data_) {
								var json=JSON.parse(data_);
								if(json['code']==0){
									alert(data_);
									upClose(function(){$("#category_list .select").trigger('click');});
								}
								else{
									$.ajax({
										type:'get',
										url:apiCategory,
										success: function(data_1) {
											var json=JSON.parse(data_1);
											if(json['code']==0){
												alert(data_1);
											}
											upClose(function(){$("#category_list .select").trigger('click');});
										}
									});
								}
							}
						});
					}
					else{
						$.ajax({
							type:'get',
							url:apiPage+'&type=page',
							success: function(data_) {
								var json=JSON.parse(data_);
								if(json['code']==0){
									alert(data_);
									upClose(function(){$("#category_list .select").trigger('click');});
								}
								else{
									$.ajax({
										type:'get',
										url:apiCategory,
										success: function(data_1) {
											var json=JSON.parse(data_1);
											if(json['code']==0){
												alert(data_1);
											}
											upClose(function(){$("#category_list .select").trigger('click');});
										}
									});
								}
							}
						});
					}
				}
			}
		});
	}

</script>