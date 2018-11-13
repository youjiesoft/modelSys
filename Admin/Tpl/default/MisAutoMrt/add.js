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

	$("select[name='yewuleixing']" , box).on('change' ,function(){
		MisAutoMrt_yewuleixing_change(this);
	});
	$("select[name='yewuleixing']" , box).change()
	$("select[name='shifushanghui']" , box).on('change' ,function(){
		MisAutoMrt_shifushanghui_change(this);
	});
	$("select[name='shifushanghui']" , box).change()		
});		

function MisAutoMrt_yewuleixing_change(obj){      var box = navTab.getCurrentPanel();
	var formname='MisAutoMrt';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='01'){
		var hidObj = $(".field_jiekuanzhuti,.field_weidaifeilv", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_danbaofeilv,.field_baozhengjinlv,.field_fengkongbujianyijine,.field_yewubujianyiqixian,.field_fengkongbujianyiqixi,.field_yewubujianyijine,.field_yewubuyijian,.field_fengkongbuyijian,.field_danbaojiekuanleixing", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val=='02'){
		var hidObj = $(".field_danbaofeilv,.field_baozhengjinlv,.field_danbaojiekuanleixing", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_weidaifeilv,.field_jiekuanzhuti,.field_fengkongbujianyijine,.field_yewubujianyiqixian,.field_fengkongbujianyiqixi,.field_yewubujianyijine,.field_yewubuyijian,.field_fengkongbuyijian", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val=='08'){
		var hidObj = $(".field_jiekuanzhuti,.field_weidaifeilv,.field_yewubujianyijine,.field_fengkongbujianyijine,.field_yewubujianyiqixian,.field_fengkongbujianyiqixi,.field_fengkongbuyijian,.field_yewubuyijian,.field_baozhengjinlv", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_danbaofeilv,.field_danbaojiekuanleixing", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
};		

function MisAutoMrt_shifushanghui_change(obj){      var box = navTab.getCurrentPanel();
	var formname='MisAutoMrt';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='是'){
		var hidObj = $(".field_pingshenjiyaoyinyong,.field_bushanghuimiaoshu", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val=='否'){
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_pingshenjiyaoyinyong,.field_bushanghuimiaoshu", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
};