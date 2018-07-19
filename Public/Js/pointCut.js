/**
 * Created by nqq on 15-08-29.
 **/
$(function(){
	var content = $(".content > .pic");
	var nav = $("div.nav");
	var navContent = nav.find('li');
	var timer = '';
	
	init();
	setTimer();
	function init(){
		var cur = content.find('li.cur');
		if(navContent.length == 0){
//			console.log(nav.find('ul'));
			var navContentHtml = '';
			for( var index = 1 ; index <= content.find('li').length ; index ++ ){
				navContentHtml = navContentHtml + "<li>"+index+"</li>";
			}
//			console.log(navContentHtml);
			nav.find('ul').html(navContentHtml);
			navContent = nav.find('li');
			nav.find('li:first').addClass('navCur');
		}
		if( cur.length > 0 ){
			if(cur.next().length == 0){
				cur = content.find('li:first');
			}else{
				cur = cur.next();
			}
			setShow(cur);
		}else{
			cur=content.find('li:first');
			cur.addClass('cur');
		}
	}
	function setTimer(){
		timer = setInterval(function(){
		init();
	} , 4000);
	}
	function setShow(obj){
		obj.addClass('cur').siblings().removeClass('cur');
		navContent.eq(obj.index()).addClass('navCur').siblings().removeClass('navCur');
	}
	navContent.hover(function(){
		if(timer != ''){
			clearInterval(timer);
		}
	},function(){
		setTimer();
	});
	navContent.click(function(){
		setShow(content.find('li').eq($(this).index()));
	});
	$('.left_btn,.right_btn,.stopRun').hover(function(){
		if(timer != ''){
			clearInterval(timer);
		}
	},function(){
		setTimer();
	});
	$('.left_btn').click(function(){
		var curObj = content.find('li.cur');
		if(curObj.prev().length == 0){
			var curObj = content.find('li:last');
		}else{
			curObj = curObj.prev();
		}
		setShow(curObj);
	});
	$('.right_btn').click(function(){
		var curObj = content.find('li.cur');
		if(curObj.next().length == 0){
			var curObj = content.find('li:first');
		}else{
			curObj = curObj.next();
		}
		setShow(curObj);
	});
});

$(function() {
	$('.navigation_ul li>div').hover(function(){
		$(this).closest("ul").find("div").removeClass('active');
		$(this).addClass('active');
	});
});