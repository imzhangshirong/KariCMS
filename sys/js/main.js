/**
 * Created by Jarvis on 2015/11/1.
 */
function getPage(page){//获取编辑操作页面
	$('#content').html("<p class='msg'>Loading...<br><span style='font-size: 20px'>正在加载中</span></p>");
	$.ajax({
		url:'index.php?action='+page,
		type:'get',
		success:function(data){
			$('#content').html(data);
		}
	});
}
function upOpen(msg,size,url,headline,closeFunc){//可视化操作过程,提示弹出
	$('#up_container').css({'width':'1100px','height':'600px'});
	if(size){
		$('#up_container').css({'width':size[0]+'px','height':size[1]+'px'});//自定义窗口大小
	}
	if(msg.length=2){
		$('#up_container').html("<p class='msg'>"+msg[0]+"<br><span style='font-size: 20px'>"+msg[1]+"</span></p>");
	}
	else if(msg.length=1){
		$('#up_container').html("<p class='msg'>"+msg[0]+"</p>");
	}
	TweenMax.fromTo(document.getElementById('upshadow'),0.5,{'display':'none','opacity':'0'},{'display':'block','opacity':'1'});
	if(url){
		$.ajax({
			url:url,
			type:'get',
			success:function(data){
				//console.log(data);
				$('#up_container').html("<p style='font-size: 18px;line-height: 20px;font-weight: 300;width: 100%;padding:10px;float: left;background-color: #3498DB;color:#fff'>"+headline+"<a href='javascript:upClose("+closeFunc+")' style='float: right;display: block;margin-right: 30px;font-weight: 700;color: #fff;font-size: 20px'>X</a></p>"+data);
			}
		});
	}
}
function upClose(func){//关闭顶层操作页面
	if(typeof(func)=="function"){
		func();
	}
	TweenMax.fromTo(document.getElementById('upshadow'),0.2,{'display':'block','opacity':'1'},{'display':'none','opacity':'0'});
	$('#up_container').html("");
}
function linkAPI(url,type,data,complete){//api提交过程，后台静默完成
	upOpen(['Processing...','正在操作中'],[400,300]);
	$.ajax({
		url:url,
		type:type,
		data:data,
		success:function(data){
			console.log(data);
			var json=JSON.parse(data);
			if(json['code']==0){
				alert(data);
			}
			upClose(complete);
		}
	});
}
function doUpload(id,callBack) {
	var formData = new FormData($(id)[0]);
	$.ajax({
		url: 'sys/ueditor/php/controller.php?action=uploadfile' ,
		type: 'POST',
		data: formData,
		async: false,
		cache: false,
		contentType: false,
		processData: false,
		success: function (returndata) {
			callBack(returndata);
		},
		error: function (returndata) {
			callBack(returndata);
		}
	});
}