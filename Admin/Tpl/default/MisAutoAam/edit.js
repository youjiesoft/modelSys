/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_组件配置文件-生成修改页面专用JS)
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

	$("select[name='yewuleixing']" , box).on('change' ,function(){
		MisAutoAam_yewuleixing_change(this);
	});
	$("select[name='yewuleixing']" , box).change()
	$(".form_group_lay input").change();
	$(".form_group_lay select").change();
	$(".form_group_lay textarea").change();		
});		

function MisAutoAam_yewuleixing_change(obj){
      var box = navTab.getCurrentPanel();
	var formname='MisAutoAam';
	box = $('form[id^="'+formname+'"]',box)?$('form[id^="'+formname+'"]',box):box;
	var val=$(obj).val();
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
};
/**
 * Created by benjamin on 17/4/26.
 */
/**
 * 获取各种值更新值
 * @param option
 * @returns {string}
 */
function valeditfunc(option){
    try {
        var result='';
        if(option.gtype&&option.gtype=='api'){
            $.ajax({
                url:option.url,
                type: option.stype,
                data: option.param,
                async:false,
                success: function(data){
                    try {
                        var res=eval("("+data+")");
                        console.log('res',res);
                        if(res.status==1){
                            result=res.data;
                            if(!isNaN(res.data)){
                                result=parseFloat(res.data);
                            }
                        }
                        return result;
                    }catch(err){
                        console.log(err.description);
                    }
                }
            });
        }else {
            $.ajax({
                url: 'valeditfunc',
                type: 'post',
                data: option,
                async: false,
                success: function (data) {
                    try {
                        var res = eval("(" + data + ")");
                        if (res.status == 1) {
                            result = res.data;
                            if (!isNaN(res.data)) {
                                result = parseFloat(res.data);
                            }
                        }
                        return result;
                    } catch (err) {
                        console.log(err.description);
                    }
                }
            });
        }
        return result;
    }catch(e){
        console.log(e.description);
    }
}
/**
 * 获取单选按钮值
 * @param radio
 * @returns {string}
 */
function getradioval(radio){
    var radios=$("input[name='"+radio+"']");
    var val='';
    if(radios.length>0){
        for(var i=0;i<radios.length;i++){
            if(radios[i].checked==true){
                val=radios[i].value;
                break;
            }
        }
    }
    return val;
}
//循环radio赋值
function redio_chk(objs,val){
    if(objs.length>0) {
        for (var i = 0; i < objs.length; i++) {
            if(objs.eq(i).val()==val){
                objs.eq(i).prop('checked', 'true');
            }
        }
    }
}
//循环checkbox赋值
function checkbox_chk(objs,vals){
    vals=vals.split(",");
    if(objs.length>0) {
        for (var i = 0; i < objs.length; i++) {
            if(vals.toString().indexOf(objs.eq(i).val().toString())>-1){
                objs.eq(i).prop('checked', 'true');
            }
        }
    }
}

//浮动框
function gLayerTips(con, th){
    layer.open({
        type: 4,
        tips: [2, '#3595CC'],
        content: [con, $(th).parent()] //数组第二项即吸附元素选择器或者DOM
    });
    $(".layui-layer-shade").remove();
    setTimeout(function(){layer.closeAll()},3000);
}