/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_组件配置文件-生成添加页面专用JS)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-08-24 11:08:08
 * @version V1.0
*/

$(function(){
    var box = navTab.getCurrentPanel();
	var formname='MisAutoZoq';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;			
			
	var val=$('.field_yewuleixing',box).attr('original');
	if(val=='01'){
		var hidObj = $(".field_jianyiweidaifeilv,.field_rugubili,.field_peiyumubiao,.field_zhitoujine,.field_jianyizongjine,.field_zhitouqixian,.field_fengkongrenyuanjianyk,.field_fengkongrenyuanjianyi,.field_fengkongrenyuanjianyg,.field_yewurenyuanjianyizon,.field_yewurenyuanjianyizhiy,.field_yewurenyuanjianyizhi", box).hide();
		var showObj =$(".field_jianyidanbaolv,.field_shouqubaozhengjinbil,.field_danbaojiekuanleixing", box).show();
	}
	if(val=='02'){
		var hidObj = $(".field_jianyidanbaolv,.field_shouqubaozhengjinbil,.field_rugubili,.field_peiyumubiao,.field_zhitoujine,.field_jianyizongjine,.field_zhitouqixian,.field_danbaojiekuanleixing,.field_jianyiweidaifeilv,.field_fengkongrenyuanjianyk,.field_fengkongrenyuanjianyi,.field_fengkongrenyuanjianyg,.field_yewurenyuanjianyizon,.field_yewurenyuanjianyizhiy,.field_yewurenyuanjianyizhi,.field_chanpinleixing", box).hide();
	}
	if(val=='04'){
		var hidObj = $(".field_jianyiweidaifeilv,.field_shouqubaozhengjinbil,.field_zhitouqixian,.field_jianyizongjine,.field_zhitoujine,.field_peiyumubiao,.field_rugubili,.field_danbaojiekuanleixing", box).hide();
		var showObj =$(".field_jianyidanbaolv", box).show();
	}
	if(val=='08'){
		var hidObj = $(".field_jianyiweidaifeilv,.field_rugubili,.field_peiyumubiao,.field_zhitoujine,.field_jianyizongjine,.field_zhitouqixian,.field_fengkongrenyuanjianyk,.field_fengkongrenyuanjianyi,.field_fengkongrenyuanjianyg,.field_yewurenyuanjianyizon,.field_yewurenyuanjianyizhiy,.field_yewurenyuanjianyizhi", box).hide();
		var showObj =$(".field_danbaojiekuanleixing", box).show();
	}
	if(val=='05'){
		var hidObj = $(".field_jianyidanbaolv,.field_jianyiweidaifeilv,.field_danbaojiekuanleixing", box).hide();
		var showObj =$(".field_zhitouqixian,.field_jianyizongjine,.field_zhitoujine,.field_peiyumubiao,.field_rugubili,.field_fengkongrenyuanjianyk,.field_fengkongrenyuanjianyi,.field_fengkongrenyuanjianyg,.field_yewurenyuanjianyizon,.field_yewurenyuanjianyizhiy,.field_yewurenyuanjianyizhi", box).show();
	}			
			
	var val=$('.field_danbaojiekuanleixing',box).attr('original');
	if(val=='02'){
		var showObj =$(".field_touzirennianhuashouy,.field_jijianfuwufeilv", box).show();
	}
	if(val!='02'){
		var hidObj = $(".field_touzirennianhuashouy,.field_jijianfuwufeilv", box).hide();
	}			
			
	var val=$('.field_pingshenyijian',box).attr('original');
	if(val=='1'){
		var showObj =$(".field_jianyijine,.field_jianyiqixian", box).show();
	}
	if(val!='1'){
		var hidObj = $(".field_jianyijine,.field_jianyiqixian", box).hide();
	}			
			
	var val=$('.field_fengxiandingjiayijia',box).attr('original');
	if(val=='1'){
		var showObj =$(".field_shouqubaozhengjinbil,.field_jianyidanbaolv,.field_touzirennianhuashouy,.field_jijianfuwufeilv", box).show();
	}
	if(val!='1'){
		var hidObj = $(".field_jianyidanbaolv,.field_shouqubaozhengjinbil,.field_touzirennianhuashouy,.field_jijianfuwufeilv", box).hide();
	}			
			
	var val=$('.field_shifuzhuanjia',box).attr('original');
	if(val=='1'){
		var hidObj = $(".field_xiangmuxinxiwai", box).hide();
		var showObj =$(".field_fieldset27,.field_xiangmuxinxina", box).show();
	}
	if(val=='2'){
		var hidObj = $(".field_fieldset27,.field_xiangmuxinxina", box).hide();
		var showObj =$(".field_xiangmuxinxina", box).show();
	}
});