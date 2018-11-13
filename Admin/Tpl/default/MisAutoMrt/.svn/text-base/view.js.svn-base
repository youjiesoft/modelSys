/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_组件配置文件-生成添加页面专用JS)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-09-23 14:11:27
 * @version V1.0
*/

$(function(){
    var box = navTab.getCurrentPanel();
	var formname='MisAutoMrt';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;			
			
	var val=$('.field_yewuleixing',box).attr('original');
	if(val=='01'){
		var hidObj = $(".field_jiekuanzhuti,.field_weidaifeilv", box).hide();
		var showObj =$(".field_danbaofeilv,.field_baozhengjinlv,.field_fengkongbujianyijine,.field_yewubujianyiqixian,.field_fengkongbujianyiqixi,.field_yewubujianyijine,.field_yewubuyijian,.field_fengkongbuyijian,.field_danbaojiekuanleixing", box).show();
	}
	if(val=='02'){
		var hidObj = $(".field_danbaofeilv,.field_baozhengjinlv,.field_danbaojiekuanleixing", box).hide();
		var showObj =$(".field_weidaifeilv,.field_jiekuanzhuti,.field_fengkongbujianyijine,.field_yewubujianyiqixian,.field_fengkongbujianyiqixi,.field_yewubujianyijine,.field_yewubuyijian,.field_fengkongbuyijian", box).show();
	}
	if(val=='08'){
		var hidObj = $(".field_jiekuanzhuti,.field_weidaifeilv,.field_yewubujianyijine,.field_fengkongbujianyijine,.field_yewubujianyiqixian,.field_fengkongbujianyiqixi,.field_fengkongbuyijian,.field_yewubuyijian,.field_baozhengjinlv", box).hide();
		var showObj =$(".field_danbaofeilv,.field_danbaojiekuanleixing", box).show();
	}			
			
	var val=$('.field_shifushanghui',box).attr('original');
	if(val=='是'){
		var hidObj = $(".field_pingshenjiyaoyinyong,.field_bushanghuimiaoshu", box).hide();
	}
	if(val=='否'){
		var showObj =$(".field_pingshenjiyaoyinyong,.field_bushanghuimiaoshu", box).show();
	}
});