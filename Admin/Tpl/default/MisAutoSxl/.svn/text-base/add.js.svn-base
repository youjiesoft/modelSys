/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_组件配置文件-生成添加页面专用JS)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-03-03 14:28:35
 * @version V1.0
*/
$(function(){
    var box = navTab.getCurrentPanel();
	var formname='MisAutoSxl';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;

	$("select[name='yewuleixing']" , box).on('change' ,function(){
		MisAutoSxl_yewuleixing_change(this);
	});
	$("select[name='yewuleixing']" , box).change()		
});		

function MisAutoSxl_yewuleixing_change(obj){      var box = navTab.getCurrentPanel();
	var formname='MisAutoSxl';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='01'){
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_danbaojiekuanleixing", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val=='08'){
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_danbaojiekuanleixing", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val!='01'){
		var hidObj = $(".field_danbaojiekuanleixing", box);
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
	if(val!='08'){
		var hidObj = $(".field_danbaojiekuanleixing", box);
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
};