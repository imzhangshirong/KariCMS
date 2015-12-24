<?php
session_start();
if(!$_SESSION['username']){
	header("Location:http://".$_SERVER['HTTP_HOST']."/index.php?action=login");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="height=768,initial-scale=1.0,minimum-scale=1.0,user-scalable=yes" />
	<title>后台管理 - KariCMS</title>
	<script src="./sys/js/jquery.min.js"></script>
	<script src="./sys/js/TweenMax.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="./sys/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="./sys/ueditor/ueditor.all.min.js"> </script>
	<script type="text/javascript" charset="utf-8" src="./sys/ueditor/lang/zh-cn/zh-cn.js"></script>
	<script src="./sys/js/main.js"></script>
	<script src="./sys/js/main_muen.js"></script>
	<link rel="stylesheet" type="text/css" href="./sys/css/main.css">
	<link rel="stylesheet" type="text/css" href="./sys/css/treeList.css">
	<script src="./sys/js/echarts/echarts.js"></script>
	<script type="text/javascript">
		// 路径配置
		require.config({
			paths: {
				echarts: './sys/js/echarts'
			}
		});
	</script>
	<script>
		var funcData= {
			'0':'index',
			'1.1':'index_category',
			'1.2':'index_file',
			'2.1':'changyan',
			'3.1':'shuju',
			'3.2':'daochubaobiao',
			'4.1':'ipforbid',
			'4.2':'usergroup',
			'4.3':'database'

		};
		$(window).ready(function(){
			muen_init();
		});
	</script>
</head>
<body>
<div id="upshadow">
	<div id="up_container"></div>
</div>
<div id="container">
	<div id="muen_left">
		<p id="user_curr">Hi，<span><?=@$_SESSION['username']?></span><a href="index.php?action=loginout" style="color: #fff;font-size: 12px;margin-left: 20px">退出</a></p>
		<ul id="muen0">
			<li class="muen0_li click">首页</li>
			<li class="muen0_li drop_down">
				内容<div class="drop"></div>
				<ul class="muen1">
					<li class="muen1_li">栏目管理</li>
					<li class="muen1_li">附件管理</li>
				</ul>
			</li>
			<li class="muen0_li drop_down">
				模块<div class="drop"></div>
				<ul class="muen1">
					<li class="muen1_li">畅言</li>
				</ul>
			</li>
			<li class="muen0_li drop_down">
				运营<div class="drop"></div>
				<ul class="muen1">
					<li class="muen1_li">数据分析</li>
					<li class="muen1_li">报告导出</li>
				</ul>
			</li>
			<li class="muen0_li drop_down">
				高级设置<div class="drop"></div>
				<ul class="muen1">
					<li class="muen1_li">IP屏蔽</li>
					<li class="muen1_li">用户组</li>
					<li class="muen1_li">数据库</li>
				</ul>
			</li>
		</ul>
		<div id="info">Copyright © 2015<br>Jarvis All Right Reserved</div>
	</div>
	<div id="content_right">
		<div id="content" style="overflow: auto"></div>
		<script>getPage(funcData['0']);</script>
	</div>
</div>
<script>
</script>
</body>
</html>