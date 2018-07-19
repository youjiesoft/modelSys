/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_组件配置文件-生成修改页面专用JS)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-06-16 09:21:10
 * @version V1.0
*/
$(function(){
    var box = navTab.getCurrentPanel();
	var formname='MisSaleBusiness';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;

	$("select[name='shifuzhuanweixiangmu']" , box).on('change' ,function(){
		MisSaleBusiness_shifuzhuanweixiangmu_change(this);
	});
	$("select[name='shifuzhuanweixiangmu']" , box).change()		
});		

function MisSaleBusiness_shifuzhuanweixiangmu_change(obj){
      var box = navTab.getCurrentPanel();
	var formname='MisSaleBusiness';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='1'){
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_xiangmubianhao,.field_supcategory,.field_category,.field_xiangmuzhudiao,.field_pifujine,.field_pifuqixian,.field_fangkuanjine,.field_fangkuanqixian", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val!='1'){
		var hidObj = $(".field_xiangmubianhao,.field_supcategory,.field_category,.field_xiangmuzhudiao,.field_pifujine,.field_pifuqixian,.field_fangkuanjine,.field_fangkuanqixian", box);
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