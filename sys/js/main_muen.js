/**
 * Created by Jarvis on 2015/11/1.
 */
function muen_init(){
	var a=0;
	$('#muen0 .muen0_li').each(function(){
		$(this).attr('muenid',a);
		$(this).attr('id','muen_'+a);
		$(this).click(function(){
			muen_click($(this));
		});
		var b=1;
		$(this).find('.muen1 li').each(function () {
			$(this).attr('id','muen_'+ a.toString()+'.'+b.toString());
			$(this).attr('muenid',a.toString()+'.'+b.toString());
			$(this).click(function(){
				muen_click($(this));
			});
			b++;
		});
		a++;
	})
}
function muen_click(ele){
	if(ele.attr('class').indexOf('muen0')>-1 && ele.attr('class').indexOf('click')<0){
		$('#muen0 .muen0_li').removeClass('click');
		$('#muen0 .muen1').css('display','none');
		$('#muen0 .muen1_li').removeClass('click_');
		$('#muen0 .muen0_li').css('margin-bottom','0px');
		$('#muen0 .muen0_li').children('ul:first').css('display','none');
		ele.addClass('click');
		if(ele.attr('class').indexOf('drop_down')>0){
			ele.children('ul:first').css('display','block');
			ele.css('margin-bottom',ele.children('ul:first').height());
		}
	}
	else if(ele.attr('class').indexOf('muen1')>-1){
		$('#muen0 .muen1_li').removeClass('click_');
		ele.addClass('click_');
	}
	var temp=funcData[ele.attr('muenid')];
	if(temp){
		getPage(temp);
	}

}