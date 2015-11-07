<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
	<meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
	<script type="text/javascript" charset="utf-8" src="./sys/js/jquery-1.11.3.min.js"> </script>
	<style>
		html,body{width: 100%;height: 100%;position: relative;overflow: hidden}
		body{background-image: url('./sys/images/bg.png');background-repeat: no-repeat;background-size: 100% 100%}
		*{margin: 0px auto;padding: 0px auto;font-family: "微软雅黑", "Lucida Grande", "Lucida Sans", Helvetica, Arial, Sans;font-size: 14px}
		#container{width: 280px;float: left;height: 300px;position: absolute;left: 50%;margin-left: -140px;top: 50%;margin-top: -150px;}
		#container p{height: 28px;line-height: 28px;float: left;clear: left;height: 40px;color: #fff}
		#container input{display: block;float: left;height: 20px;margin-right: 18px;border-radius: 3px;border: 1px solid #D4D4D4;padding: 3px}
		#container textarea{border-radius: 3px;border: 1px solid #D4D4D4}
		#container button{background-color: #4285F4;border: none;border-radius: 4px;color: #fff;text-align: center;padding: 8px 10px;float: left;display: block;margin: 0px;cursor: pointer;margin: 10px}
		#container button:hover{box-shadow: 0px 0px 5px #4285F4}
		#info{width: 100%;text-align: center;color: #aaa;height: 40px;line-height: 40px;position: absolute;bottom: 0px;font-size: 12px}
		label{float: left;display: block;line-height: inherit;width:100px;color: #fff}
	</style>
</head>
<body>
<div id="container" style="width:300px">
	<p style="color:#fff;font-size: 70px;text-align: center;width: 400px;font-weight: 300;margin-bottom: 60px;position: relative;left: 50%;margin-left: -210px;">KariCMS<span><?=CMS_VERSON?></span></p>
	<p><label>username:</label><input id="username" style="width: 165px"></p>
	<p><label>password:</label><input type="password" id="password" style="width: 165px"></p>
	<p><label>checkcode:</label><input id="checkcode" style="width: 50px"><a href="javascript:newCheck()"><img
				id="cc" src="api
	.php?action=captcha"></a></p>
	<p><a href="javascript:login()"><button style="width: 250px;" id="login_go">登录</button></a></p>
</div>
<div id="info">Copyright © 2015 Jarvis,zhangshirong All Right Reserved</div>
<script>
	function newCheck(){
		document.getElementById('cc').src="api.php?action=captcha";
	}
	function login(){
		$('input').attr('disabled','true');
		$('#login_go').css('background-color','#999');
		$('#login_go').html('正在登录...');
		var username=document.getElementById('username').value;
		var password=document.getElementById('password').value;
		var checkcode=document.getElementById('checkcode').value;
		var data={username:username,password:password,checkcode:checkcode};
		var url='api.php?action=login';
		$.ajax({
			url:url,
			type:'post',
			data:data,
			success:function(data){
				console.log(data);
				var json = JSON.parse(data);
				if(json['code']==0){
					alert(data);
					window.location.href="index.php?action=login";
				}
				else{
					window.location.href="main.php";
				}
			}
		});
	}
</script>
</body>
</html>
