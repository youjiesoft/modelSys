/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_组件配置文件-生成修改页面专用JS)
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
	$('input[name="jianyijine"]',box).change(function(){
	    $('input[name="jianyizongjine"]',box).trigger('addcalcjianyizongjine');
	 });
	 $('input[name="jianyizongjine"]',box).on('addcalcjianyizongjine',function(){
	 	var c ='#jianyijine#+#zhitoujine#';
	 	var c_r=c;
	 	var ret_c=$(this).val();
	 	$.each(["jianyijine","zhitoujine"], function(i,v){
		 	var val =  $('input[name="'+v+'"]',box).val();
		 	if(isNullorEmpty(val)){
		 		ret_c = c_r =c_r.replaceAll('#'+v+'#',val);
			}
		});
		var ret ='';
		var a = c.match(/\#/g);
			try{
			var decimal =0;
			if(a.length==2){
				if($(this).val()){
					apamount = $(this).val();
				}else{
					apamount = ret_c;
				}
				apamount = comboxMathematicalOperation(ret_c, decimal);	
				
			}else{
				apamount = comboxMathematicalOperation(ret_c, decimal);
			}
			$(this).val(apamount).change();
			}catch(e){
				console.log(e||e.message);
			}
		
	});									
	$('[name="jianyizongjine"]',box).trigger('addcalcjianyizongjine');					
	$('input[name="zhitoujine"]',box).change(function(){
	    $('input[name="jianyizongjine"]',box).trigger('addcalcjianyizongjine');
	 });
	 $('input[name="jianyizongjine"]',box).on('addcalcjianyizongjine',function(){
	 	var c ='#jianyijine#+#zhitoujine#';
	 	var c_r=c;
	 	var ret_c=$(this).val();
	 	$.each(["jianyijine","zhitoujine"], function(i,v){
		 	var val =  $('input[name="'+v+'"]',box).val();
		 	if(isNullorEmpty(val)){
		 		ret_c = c_r =c_r.replaceAll('#'+v+'#',val);
			}
		});
		var ret ='';
		var a = c.match(/\#/g);
			try{
			var decimal =0;
			if(a.length==2){
				if($(this).val()){
					apamount = $(this).val();
				}else{
					apamount = ret_c;
				}
				apamount = comboxMathematicalOperation(ret_c, decimal);	
				
			}else{
				apamount = comboxMathematicalOperation(ret_c, decimal);
			}
			$(this).val(apamount).change();
			}catch(e){
				console.log(e||e.message);
			}
		
	});									
	$('[name="jianyizongjine"]',box).trigger('addcalcjianyizongjine');

	$("select[name='yewuleixing']" , box).on('change' ,function(){
		MisAutoZoq_yewuleixing_change(this);
	});
	$("select[name='yewuleixing']" , box).change()
	$("select[name='danbaojiekuanleixing']" , box).on('change' ,function(){
		MisAutoZoq_danbaojiekuanleixing_change(this);
	});
	$("select[name='danbaojiekuanleixing']" , box).change()
	$("select[name='pingshenyijian']" , box).on('change' ,function(){
		MisAutoZoq_pingshenyijian_change(this);
	});
	$("select[name='pingshenyijian']" , box).change()
	$("select[name='fengxiandingjiayijia']" , box).on('change' ,function(){
		MisAutoZoq_fengxiandingjiayijia_change(this);
	});
	$("select[name='fengxiandingjiayijia']" , box).change()
	$("select[name='shifuzhuanjia']" , box).on('change' ,function(){
		MisAutoZoq_shifuzhuanjia_change(this);
	});
	$("select[name='shifuzhuanjia']" , box).change()		
});		

function MisAutoZoq_yewuleixing_change(obj){      var box = navTab.getCurrentPanel();
	var formname='MisAutoZoq';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='01'){
		var hidObj = $(".field_jianyiweidaifeilv,.field_rugubili,.field_peiyumubiao,.field_zhitoujine,.field_jianyizongjine,.field_zhitouqixian,.field_fengkongrenyuanjianyk,.field_fengkongrenyuanjianyi,.field_fengkongrenyuanjianyg,.field_yewurenyuanjianyizon,.field_yewurenyuanjianyizhiy,.field_yewurenyuanjianyizhi", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_jianyidanbaolv,.field_shouqubaozhengjinbil,.field_danbaojiekuanleixing", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val=='02'){
		var hidObj = $(".field_jianyidanbaolv,.field_shouqubaozhengjinbil,.field_rugubili,.field_peiyumubiao,.field_zhitoujine,.field_jianyizongjine,.field_zhitouqixian,.field_danbaojiekuanleixing,.field_jianyiweidaifeilv,.field_fengkongrenyuanjianyk,.field_fengkongrenyuanjianyi,.field_fengkongrenyuanjianyg,.field_yewurenyuanjianyizon,.field_yewurenyuanjianyizhiy,.field_yewurenyuanjianyizhi,.field_chanpinleixing", box);
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
	if(val=='04'){
		var hidObj = $(".field_jianyiweidaifeilv,.field_shouqubaozhengjinbil,.field_zhitouqixian,.field_jianyizongjine,.field_zhitoujine,.field_peiyumubiao,.field_rugubili,.field_danbaojiekuanleixing", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_jianyidanbaolv", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val=='08'){
		var hidObj = $(".field_jianyiweidaifeilv,.field_rugubili,.field_peiyumubiao,.field_zhitoujine,.field_jianyizongjine,.field_zhitouqixian,.field_fengkongrenyuanjianyk,.field_fengkongrenyuanjianyi,.field_fengkongrenyuanjianyg,.field_yewurenyuanjianyizon,.field_yewurenyuanjianyizhiy,.field_yewurenyuanjianyizhi", box);
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
	if(val=='05'){
		var hidObj = $(".field_jianyidanbaolv,.field_jianyiweidaifeilv,.field_danbaojiekuanleixing", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_zhitouqixian,.field_jianyizongjine,.field_zhitoujine,.field_peiyumubiao,.field_rugubili,.field_fengkongrenyuanjianyk,.field_fengkongrenyuanjianyi,.field_fengkongrenyuanjianyg,.field_yewurenyuanjianyizon,.field_yewurenyuanjianyizhiy,.field_yewurenyuanjianyizhi", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
};		

function MisAutoZoq_danbaojiekuanleixing_change(obj){      var box = navTab.getCurrentPanel();
	var formname='MisAutoZoq';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='02'){
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_touzirennianhuashouy,.field_jijianfuwufeilv", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val!='02'){
		var hidObj = $(".field_touzirennianhuashouy,.field_jijianfuwufeilv", box);
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

function MisAutoZoq_pingshenyijian_change(obj){      var box = navTab.getCurrentPanel();
	var formname='MisAutoZoq';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='1'){
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_jianyijine,.field_jianyiqixian", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val!='1'){
		var hidObj = $(".field_jianyijine,.field_jianyiqixian", box);
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

function MisAutoZoq_fengxiandingjiayijia_change(obj){      var box = navTab.getCurrentPanel();
	var formname='MisAutoZoq';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='1'){
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_shouqubaozhengjinbil,.field_jianyidanbaolv,.field_touzirennianhuashouy,.field_jijianfuwufeilv", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val!='1'){
		var hidObj = $(".field_jianyidanbaolv,.field_shouqubaozhengjinbil,.field_touzirennianhuashouy,.field_jijianfuwufeilv", box);
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

function MisAutoZoq_shifuzhuanjia_change(obj){      var box = navTab.getCurrentPanel();
	var formname='MisAutoZoq';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
	if(val=='1'){
		var hidObj = $(".field_xiangmuxinxiwai", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_fieldset27,.field_xiangmuxinxina", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
	if(val=='2'){
		var hidObj = $(".field_fieldset27,.field_xiangmuxinxina", box);
		if(typeof(hidObj) != 'undefined'){
			hidObj.hide();
			setReq(hidObj.find(':input'));
			hidObj.find(':input').attr('disabled',true);
		}
		var showObj =$(".field_xiangmuxinxina", box);
		if(typeof(showObj) != 'undefined'){
			showObj.show();
			setReq(showObj.find(':input'));
			setClsReq(showObj.find(':input'));
			showObj.find(':input').attr('disabled',false);
		}
	}
};