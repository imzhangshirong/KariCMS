<table style="float: left;width: 100%" cellspacing="0">
	<tr align='center'><th><input type='checkbox' id="article_check"></th><th>id</th><th>排序</th><th width="230">标题</th><th width="50%">描述</th><th width="100">创建时间</th><th width="100">更新时间</th></tr>
	<?php
	$DB_mysql=new database();
	$sql="SELECT * FROM `".@$_GET['catdir']."` ORDER BY `id` DESC, `listorder` DESC";
	$DB_mysql->query($sql);
	$DB_result=$DB_mysql->all2array();
	for($a=0;$a<count($DB_result);$a++){
		echo"<tr class='list' aid='".$DB_result[$a]['id']."' catid='".@$_GET['catid']."'><td align='center'><input type='checkbox'></td><td align='center'>".$DB_result[$a]['id']."</td><td align='center'>".$DB_result[$a]['listorder']."</td><td
style='padding:0px 8px'><a class='link' target='_blank' href='".$DB_result[$a]['url']."'>".$DB_result[$a]['title']."</a></td><td style='padding:0px 8px'>".mb_substr($DB_result[$a]['description'],0,60,'utf-8')."...</td><td align='center'>".$DB_result[$a]['inputtime']."</td><td align='center'>".$DB_result[$a]['updatetime']."</td></tr>";
	}
	?>

</table>
<script>
	$('.list').click(function(){
		$('.list').removeClass('select');
		$(this).addClass('select');
	});
	$('#article_check').click(function () {
		var value=$(this)[0]['checked'];
		$('#category_article td input').each(function(){
			$(this)[0]['checked']=value;
		});
	});
	function deleteArticle(){
		var aidAll='';
		$('#category_article td input').each(function(){
			if($(this)[0]['checked']){
				aidAll+=($(this).parents('tr').attr('aid'))+'|';
			}
		});
		if(aidAll==''){
			alert('请勾选要删除的文章');
		}
		else{
			linkAPI('api.php?action=content&method=delete&catid='+$('#category_list .select').attr('catid')+'&id='+aidAll,'get',{},function(){linkAPI('api.php?action=parse&type=list&catid='+$('#category_list .select').attr('catid'),'get',{},function(){$("#category_list .select").trigger('click');});});

		}
	}
	function htmlPage(){
		var aidAll='';
		$('#category_article td input').each(function(){
			if($(this)[0]['checked']){
				aidAll+=($(this).parents('tr').attr('aid'))+'|';
			}
		});
		if(aidAll==''){
			alert('请勾选要生成html的文章');
		}
		else{
			linkAPI('api.php?action=parse&type=page&catid='+$('#category_list .select').attr('catid')+'&id='+aidAll,'get',{},function(){linkAPI('api.php?action=parse&type=list&catid='+$('#category_list .select').attr('catid'),'get',{},function(){$("#category_list .select").trigger('click');});});

		}
	}
</script>