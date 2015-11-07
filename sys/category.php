<?php
if(!isset($_GET['method'])){
	$jsonArr=array(
		'code'=>'0',
		'error'=>'missing parameters'
	);
	$jsonData=json_encode($jsonArr);
	die($jsonData);
}
$method=$_GET['method'];
if($method!='insert'){
	if(!isset($_GET['catid'])){
		$jsonArr=array(
			'code'=>'0',
			'error'=>'missing parameters'
		);
		$jsonData=json_encode($jsonArr);
		die($jsonData);
	}
	$catid=$_GET['catid'];
	$DB_mysql=new database();
	$DB_mysql->query('SELECT * FROM `cms_category` WHERE catid='.$catid);
	$DB_row=$DB_mysql->result->fetch_assoc ();
	$DB_table=$DB_row["catdir"];
}
if($method=='insert'){
	$catname='';
	$catdir='';
	$template_list='';
	$template_page='';
	$listorder=0;

}
else if($method=='modify'){
	$catname=$DB_row["catname"];
	$catdir=$DB_row["catdir"];
	$template_list=$DB_row["template_list"];
	$template_page=$DB_row["template_page"];
	$listorder=$DB_row["listorder"];
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
<div style="margin:10px;float: left;margin-left: -150px;left:50%;position: relative;width: 300px" class="cms_page" id="page_category">
	<p><label>栏目名字：</label><input id="catname" style="width: 200px" value="<?=$catname?>"></p><p><label>栏目路径：</label><input id="catdir" style="width: 200px" value="<?=$catdir?>"></p><p><label>列表模版：</label><select id="template_list" style="width: 200px" ><option
			value="<?=$template_list?>"><?=$template_list?></option>
		<?php
		$dp = opendir(PATH_CMS.PATH_TEMPLATES);
		while (false !== ($file = readdir($dp))) {
			if($file!="." && $file!=".." && $file!="" && $file!=$template_list){
				echo "<option value='".$file."'>".$file."</option>";
			}
		}
		?>
		</select></p><p><label>内容模版：</label><select id="template_page" style="width: 200px"><option
		value="<?=$template_page?>"><?=$template_page?></option>
			<?php
			$dp = opendir(PATH_CMS.PATH_TEMPLATES);
			while (false !== ($file = readdir($dp))) {
				if($file!="." && $file!=".." && $file!="" && $file!=$template_page){
					echo "<option value='".$file."'>".$file."</option>";
				}
			}
			?>
		</select></p><p><label>排列顺序：</label><input id="listorder" style="width: 200px" value="<?=$listorder?>"></p>
	<p><button onclick="modifyReady()" class="modify" id="modify" style="display: none">修改</button><button onclick="saveData()" style="display: none" class="modify" id="save">保存</button></p>
</div>
<script>
	var method='<?=$method?>';
	var catid='<?=@$catid?>';

	var api='api.php?action=category&method=<?=$method?>';
	if(method!='insert'){
		api+='&catid='+catid;
	}
	if(method=='modify'){
		$('#modify').css({'display':'block'});
		$('#page_category').css({'margin':'10px','left':'0px'})
		$('#page_category input,#page_category select').attr('disabled',true);
	}
	else{
		$('#save').css({'display':'block'});
		//$('#page_category input,#page_category select').attr('disabled',true);
	}
function modifyReady(){
	$('#modify').css({'display':'none'});
	$('#save').css({'display':'block'});
	$('#page_category input,#page_category select').attr('disabled',false);
}
 function saveData() {
	 var url='/'+document.getElementById('catdir').value+'/';
	 var catname=document.getElementById('catname').value;
	 var catdir=document.getElementById('catdir').value;
	 var template_list=document.getElementById('template_list').value;
	 var template_page=document.getElementById('template_page').value;
	 var listorder=document.getElementById('listorder').value;
	 var data={
		 catname:catname,
		 catdir:catdir,
		 url:url,
		 template_list:template_list,
		 template_page:template_page,
		 listorder:listorder

	 }
	 $('#up_container').css({'width':'400px','height':'300px'});
	 TweenMax.fromTo(document.getElementById('upshadow'),0.5,{'display':'none','opacity':'0'},{'display':'block','opacity':'1'});
	 $('#up_container').html("<p class='msg'>Processing...<br><span style='font-size: 20px'>正在操作中</span></p>");
	 $.ajax({
		 url:api,
		 type:'post',
		 data:data,
		 success:function(data){
			 var json=JSON.parse(data);
			 if(json['code']==0){
				 alert(data);
			 }
			 if(method=="insert"){
				 getPage(funcData['1.1']);
			 }
			 else{
				 $("#category_list .select").trigger('click');
			 }
			 TweenMax.fromTo(document.getElementById('upshadow'),0.2,{'display':'block','opacity':'1'},{'display':'none','opacity':'0'});
			 $('#up_container').html("");

		 }
	 });
 }
</script>