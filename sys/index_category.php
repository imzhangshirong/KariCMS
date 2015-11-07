<div style="float: left;width: 500px;height: 300px" id="index_data_left">
	<div class="cardShow" style="width: 96%;height: 80%;margin:30px 0px 0px 30px;" id="index_data_left_1">
		<p class="cardShowTitle" style="border-left: 5px solid #3498DB;">栏目列表</p>
		<div class="cardShowContent" style="overflow: auto;margin: 0px" id="category_list">
			<table style="float: left;width: 100%" cellspacing="0">
				<tr align='center'><th><input type='checkbox' id="cotegory_check"></th><th>catid</th><th>排序</th><th>栏目名称</th><th>地址</th></tr>
				<?php
				$DB_mysql=new database();
				$sql="SELECT * FROM `cms_category` ORDER BY `catid` ASC";
				$DB_mysql->query($sql);
				$DB_result=$DB_mysql->all2array();
				for($a=0;$a<count($DB_result);$a++){
					echo"<tr class='category' catid='".$DB_result[$a]['catid']."' catdir='".$DB_result[$a]['catdir']."'><td align='center'><input type='checkbox'></td><td align='center'>".$DB_result[$a]['catid']."</td><td align='center'>".$DB_result[$a]['listorder']."</td><td
style='text-indent:10px'><a target='_blank' class='link' href='".$DB_result[$a]['url']."'>".$DB_result[$a]['catname']."</a></td><td align='center'>".$DB_result[$a]['catdir']."</td></tr>";
				}
				?>

			</table>
		</div>
		<script>
			$('#cotegory_check').click(function () {
				var value=$(this)[0]['checked'];
				$('#category_list td input').each(function(){
					$(this)[0]['checked']=value;
				});
			});
		</script>
		<div class="cms_page"><p><button onclick="upOpen(['Loading...','正在加载中'],[500,300],'index.php?action=category&method=insert','新建栏目')" style="margin-left: 10px" class="add">新建</button><button onclick="linkAPI('api.php?action=parse&type=list&catid='+$('#category_list .select').attr('catid'))" style="margin-left: 10px" class="modify">生成html</button><button onclick="deleteCategory()" style="margin-left: 10px" class="del">删除</button></p></div>
	</div>

</div>
<div style="float: left;width: 330px;height: 300px" id="index_data_right">
	<div class="cardShow" style="width:96%;margin:30px 0px 0px 30px;height: 80%">
		<p class="cardShowTitle" style="border-left: 5px solid #1FB5AD;">栏目详情</p>
		<div class="cardShowContent" style="margin: 0px" id="category">
			<p style='height: 20px;line-height: 20px;width: 200px;font-size: 18px;font-weight: 300;position: relative;top:50%;margin-top: -15px;text-align: center'>选择栏目即可修改</p>
		</div>
	</div>

</div>
	<div id="index_data_bottom" class="cardShow" style="width:96%;height: 50%;margin:0px 0px 0px 30px;" id="index_data_left_2">
		<p class="cardShowTitle" style="border-left: 5px solid #F04122;">栏目内容</p>
		<div class="cardShowContent" id="category_article" style="margin: 0px;overflow:auto">
			<p style='height: 20px;line-height: 20px;width: 200px;font-size: 18px;font-weight: 300;position: relative;top:50%;margin-top: -15px;text-align: center'>选择栏目即可查看内容</p>
		</div>
		<div class="cms_page"><p><button onclick="if($('#category_list .select').length==1){upOpen(['Loading...','正在加载中'],[1100,600],'index.php?action=content&method=insert&catid='+$('#category_list .select').attr('catid'),'新建文章',function(){ue.destroy()})}else{alert('请选择栏目')}" style="margin-left: 10px" class="add">新建</button><button onclick="if($('#category_article .select').length==1){upOpen(['Loading...','正在加载中'],[1100,600],'index.php?action=content&method=modify&catid='+$('#category_article .select').attr('catid')+'&id='+$('#category_article .select').attr('aid'),'修改文章',function(){ue.destroy()})}else{alert('请选择文章')}" style="margin-left: 10px" class="modify">修改</button><button onclick="htmlPage()" style="margin-left: 10px" class="modify">生成html</button><button onclick="deleteArticle()" style="margin-left: 10px;" class="del">删除</button></p></div>
	</div>
<script>
	$('#content_right #index_data_left').css({'width':$('#content_right').width()*0.65+'px'});
	$('#content_right #index_data_right').css({'width':$('#content_right').width()*0.32+'px'});
	$('#content_right #index_data_bottom').css({'height':$('#content_right #index_data_bottom').parent().height()-320+'px'});
	$('.cardShowContent').each(function(){
		$(this).css('height',$(this).parent().height()-30+'px');
	});
	$('#category_list,#category_article').each(function(){
		$(this).css('height',$(this).parent().height()-70+'px');
	});
	$('.category').click(function(){
		$('.category').removeClass('select');
		$(this).addClass('select');
		$('#category').html("<p class='msg'>Loading...<br><span style='font-size: 20px'>正在加载中</span></p>");
		$('#category_article').html("<p class='msg'>Loading...<br><span style='font-size: 20px'>正在加载中</span></p>");
		$.ajax({
			url:'index.php?action=category&method=modify&catid='+$(this).attr('catid'),
			type:'get',
			success:function(data){
				//console.log(data);
				$('#category').html(data);
			}
		});
		$.ajax({
			url:'index.php?action=list_article&catid='+$(this).attr('catid')+'&catdir='+$(this).attr('catdir'),
			type:'get',
			success:function(data){
				//console.log(data);
				$('#category_article').html(data);
			}
		});
	});
	function deleteCategory(){
		var cidAll='';
		$('#category_list td input').each(function(){
			if($(this)[0]['checked']){
				cidAll+=($(this).parents('tr').attr('catid'))+'|';
			}
		});
		if(cidAll==''){
			alert('请勾选要删除的栏目');
		}
		else{
			linkAPI('api.php?action=category&method=delete&catid='+cidAll,'get',{},function(){getPage(funcData['1.1']);})
		}
	}
</script>