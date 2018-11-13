/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_组件配置文件-生成添加页面专用JS)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2017-12-03 15:48:49
 * @version V1.0
*/

$(function(){
	initTableWNEW();
	checkidcard();
    var box = navTab.getCurrentPanel();
	var formname='MisAutoAam';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
    $(".into_table_tj span",box).each(function(i,val){
       var decimals = $(".into_table_tj span",box).eq(i).attr("decimals");
       var numTol =  $(".into_table_tj span",box).eq(i).html();
       $(".into_table_tj span",box).eq(i).html(Number(numTol).toFixed(decimals));
    });			
			
	var val=$('.field_yewuleixing',box).attr('original');
	if(val!='01'){
		var hidObj = $(".field_danbaojiekuanleixing", box).hide();
	}
	if(val!='08'){
		var hidObj = $(".field_danbaojiekuanleixing", box).hide();
	}
	if(val=='01'){
		var showObj =$(".field_danbaojiekuanleixing", box).show();
	}
	if(val=='08'){
		var showObj =$(".field_danbaojiekuanleixing", box).show();
	}
});