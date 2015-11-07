/**
 * Created by Jarvis on 2015/11/2.
 */
var treeListFunc=Array(3);
function treeList_init(outFunc,clickFunc,closeFunc){
	treeListFunc[0]=outFunc;
	treeListFunc[1]=clickFunc;
	treeListFunc[2]=closeFunc;
	$('.treeList li').prepend('<input type="checkbox">');
	$('.treeList ul').each(function (){
		if($(this).parent('li').length>0){
			$(this).parent('li').prepend('<div class="treeButton">-</div>');
		}

	});
	treeList_bond();

}
function treeList_bond(){
	$('.treeList li').unbind();
	$('.treeList .treeButton').unbind();
	$('.treeList input').unbind();
	$('.treeList li').on('click',function(e){
		$(this).parents('.treeList').find('li').removeClass('select');
		$(this).addClass('select');
		if(typeof (treeListFunc[1])=="function"){
			treeListFunc[1]($(this));
		}
		e['originalEvent'].stopPropagation();

	});
	$('.treeList li').on('mouseover',function(e){
		$(this).parents('.treeList').find('li').removeClass('hover');
		$(this).addClass('hover');
		e['originalEvent'].stopPropagation();

	});
	$('.treeList .treeButton').on('click',function(){
		if($(this).html()=='-'){
			$(this).html('+');
			$(this).parent('li').css('height',$(this).parent('li').css('line-height'));
			if(typeof (treeListFunc[2])=="function"){
				treeListFunc[2]($(this).parent());
			}
		}
		else if($(this).html()=='+'){
			$(this).html('-');
			$(this).parent('li').css('height','auto');
			if(typeof (treeListFunc[0])=="function"){
				treeListFunc[0]($(this).parent());
			}
		}
	});
	$('.treeList input').on('click',function(){
		if($(this).attr('type')=='checkbox'){
			var  t=$(this)[0]['checked'];
			//console.log($(this).children('input'));
			$(this).parent('li').find('input').each(function(){
				$(this)[0]['checked']=t;
				//console.log($(this)[0]['checked'])
			});
			var temp=$(this).parent('li').parent('ul').prev('input')[0]['checked'];

			if(temp==true & t==false){
				$(this).parent('li').parent('ul').prev('input')[0]['checked']=false;
			}
		}
	});
}



