<div style="float: left;width: 780px;height: 100%;min-height: 600px" id="index_data_left">
	<div class="cardShow" style="width: 96%;height: 46%;margin:30px 0px 0px 30px;" id="index_data_left_1">
		<p class="cardShowTitle" style="border-left: 5px solid #3498DB;">首页近期流量报告</p>
		<div class="cardShowContent">
			<div id="index_data1" style="height:100%;width:100%"></div>
		</div>
	</div>
	<div class="cardShow" style="width:96%;height: 40%;margin:30px 0px 0px 30px;" id="index_data_left_2">
		<p class="cardShowTitle" style="border-left: 5px solid #F04122;">本月首页各栏目</p>
		<div class="cardShowContent">
			<div id="index_data2" style="height:100%;width:100%;float: left"></div>

		</div>


	</div>
</div>
<div style="float: left;width: 330px" id="index_data_right">
	<div class="cardShow" style="width:96%;margin:30px 0px 0px 30px;">
		<p class="cardShowTitle" style="border-left: 5px solid #1FB5AD;">系统概况</p>
		<div class="cardShowContent">
			<p class="lable"><span>系统版本：</span><span><?=CMS_VERSON?></span></p>
			<p class="lable"><span>运行环境：</span><span style="width: 200px"><?=php_uname('s')
									.' '.php_uname('r')
									?><br><?=php_sapi_name()
									?></span></p>
			<p class="lable"><span>开发：</span><span>Jarvis</span></p>
		</div>
	</div>
	<div class="cardShow" style="width:96%;margin:30px 0px 0px 30px;">
		<p class="cardShowTitle" style="border-left: 5px solid #00A651;">快捷操作</p>
		<div class="cardShowContent">
			<p class="lable"><a href=""><font color="#0078D7">清除缓存</font></a></p>
			<p class="lable"><a href=""><font color="#0078D7">生成首页</font></a></p>
		</div>
	</div>

</div>
<script>
	$('#index_data_left').css({'width':$('#content_right').width()*0.67+'px'});
	$('#index_data_right').css({'width':$('#content_right').width()*0.28+'px'});
	$('.cardShowContent').each(function(){
		$(this).css('height',$(this).parent().height()-50+'px');
		//$(this).css('width',$(this).parent().width()-20+'px');
		//$(this).css('margin-left','10px');
	})
	//$('#content_right #index_data_left #index_data_left_1').css({'height':$('#content_right').width()*0.67+'px'});
	//$('#content_right #index_data_right #index_data_left_2').css({'height':$('#content_right').width()*0.28+'px'});
</script>
<script type="text/javascript">
	require(
		[
			'echarts',
			'echarts/theme/macarons', // 皮肤
			'echarts/chart/line', // 使用柱状图就加载bar模块，按需加载
		],
		function (ec,theme) {
			var myChart = ec.init(document.getElementById('index_data1'),theme);
			var option = {
				grid:{x:60, y:40, x2:40, y2:30},
				tooltip : {trigger: 'axis'},
				legend: {data:['直接访问','搜索引擎']},
				xAxis : [{type : 'category', boundaryGap : false, data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']}],
				yAxis : [{type : 'value'}],
				series : [
					{name:'直接访问', type:'line', stack: '总量', data:[320, 332, 301, 334, 390, 330, 320,500,845,1003,1461,1285]},
					{name:'搜索引擎', type:'line', stack: '总量', data:[820, 932, 901, 934, 1290, 1330, 1320,1500,1845,1303,1461,1285]}
				]
			};
			myChart.setOption(option);
		}
	);
</script>
<script type="text/javascript">
	require(
		[
			'echarts',
			'echarts/theme/macarons',
			'echarts/chart/bar',
		],
		function (ec,theme) {
			var myChart = ec.init(document.getElementById('index_data2'),theme);
			var option = {
				grid:{x:60, y:40, x2:40, y2:30},
				tooltip : {trigger: 'axis'},
				xAxis : [
					{type : 'category', data : [
							<?php
							$DB_mysql=new database();
							$sql="SELECT * FROM `cms_category`";
							$DB_mysql->query($sql);
							$DB_result=$DB_mysql->all2array();
							for($a=0;$a<count($DB_result);$a++){
							$sql="SELECT * FROM `cms_hits` WHERE `hitsid`='c-".$DB_result[$a]['catid']."'";
							$DB_mysql->query($sql);
							$result=$DB_mysql->result->fetch_assoc ();
							$DB_result[$a]['hits']=$result['hits'];
							echo "'".$DB_result[$a]['catname']."'";
							if($a<count($DB_result)-1){
							echo ",";
							}
							}
							?>
						]}],
				yAxis : [{type : 'value'}],
				series : [
					{name:'访问量', type:'bar',
						data:[
							<?php
							for($a=0;$a<count($DB_result);$a++){
							echo $DB_result[$a]['hits'];
							if($a<count($DB_result)-1){
							echo ",";
							}
							}
							?>
						],
						markPoint : {data : [{type : 'max', name: '最大值'}, {type : 'min', name: '最小值'}]}
					}]
				};
			myChart.setOption(option);
		}
	);
</script>