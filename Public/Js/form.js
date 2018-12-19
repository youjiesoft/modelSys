//多个细分品类值时带回保存处理

//表单容器的显示隐藏
function contrllshow(e){
    var bindform = e.getAttribute('bindform');
    var c = $('#'+$("[name='nodename']").val()+bindform + '_edit');
    console.log(c)
    var formtitle = document.getElementsByClassName('formtitle');    //获取所有容
    if(e.parentNode.parentNode.parentNode.nextElementSibling.style.display=='none'){
        e.parentNode.parentNode.parentNode.nextElementSibling.style.display="";
        if( c){
            c.css('display','');
        }
    }else{
        e.parentNode.parentNode.parentNode.nextElementSibling.style.display="none";
        if( c){
            c.css('display','none');
        }
    }
    for(var i= 0;i<formtitle.length;i++) {
        var field = formtitle[i].getAttribute('field');
        var bindform = formtitle[i].getAttribute('bindform');
        var top = formtitle[i].parentNode.parentNode.parentNode.parentNode.parentNode.offsetTop;
        var top1 = formtitle[i].parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.offsetTop
        var top2 = formtitle[i].parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.offsetTop
        var element =  document.getElementsByClassName('form_'+field);
        var para =$("#"+ $("[name='nodename']").val()+bindform + '_edit');
        para.css('top',top+top1+top2+'px');
    }

}

function controll() {
    console.log('jin')
    var all= document.getElementsByClassName('new_version_page')
    var formtitle = document.getElementsByClassName('formtitle');    //获取所有容器标题
    var arr =new Array();
    var nodename=document.getElementsByName('nodename');
    var url =TP_APP+'/'+nodename[0].value+'/formcontroll';
    for(var i= 0;i<formtitle.length;i++) {
        if(formtitle[i].parentNode.parentNode.parentNode.parentNode.parentNode.style.display!='none') {
            var field = formtitle[i].getAttribute('field');
            var bindform = formtitle[i].getAttribute('bindform');
            var caozuo = $("[name='caozuo']").val();
            //得到容器 在后台生成代码  传过来    再写入到页面上
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'html',
                async: false,
                data: {
                    field: field,
                    tp: TP_APP,
                    caozuo:caozuo ,
                    id: $("[name='id']").val(),
                    vojson: $("[name='vojson']").val(),
                    model: nodename[0].value,
                },
                success: function (msg) {
                    var para = document.createElement("div");     //創建form
                    para.innerHTML = msg;
                    para.style.display = 'block';
                    var classn = $("[name='nodename']").val()+bindform + '_edit';
                    para.setAttribute('class',' form_');
                    para.setAttribute('id', classn);
                    para.setAttribute('field', field);
                    all[0].appendChild(para);
                    $(para).off("DOMNodeInserted", ".dataTables_wrapper ");
                    $(para).on("DOMNodeInserted",".dataTables_wrapper ", function (e) {
                        var newfiled = para.getAttribute('field')
                        var ro = document.getElementsByClassName(newfiled);
                        if(caozuo=='add'){
                            height=182  +'px';
                        }else{
                            var height = $(this).height() + 'px';
                        }
                        console.log(height)
                        para.style.height = height;
                        ro[0].style.height = height;
                        var top1 = ro[0].parentNode.parentNode.offsetTop;
                        var top2 = ro[0].parentNode.parentNode.parentNode.offsetTop
                        var top3 = ro[0].parentNode.parentNode.parentNode.parentNode.offsetTop
                        para.style.top = top1 + top2 + top3  + 'px';

                    });
                    $(para).off("DOMNodeInserted", ".page");
                    $(para).on("DOMNodeInserted", ".page", function (e) {
                        var newfiled = para.getAttribute('field')
                        var ro = document.getElementsByClassName(newfiled);
                        var pc = para.childNodes;
                        var height = para.offsetHeight + 'px';
                        // var height = '300px';     //当为 miniindex  并且为新增的时候  指定（无值）
                        para.style.height = height;
                        ro[0].style.height = height;
                        // para.parentNode.style.width= ro[0].parentNode.parentNode.offsetWidth + 'px';
                        // para.parentNode.style.overflow= 'hidden';
                        // para.style.width = ro[0].parentNode.parentNode.offsetWidth + 'px';
                        // para.style.left = ro[0].parentNode.parentNode.offsetLeft + "px";

                        var top1 = ro[0].parentNode.parentNode.offsetTop;
                        var top2 = ro[0].parentNode.parentNode.parentNode.offsetTop
                        var top3 = ro[0].parentNode.parentNode.parentNode.parentNode.offsetTop
                        para.style.top = top1 + top2 + top3  + 'px';

                        var curAction = $("[name='nodename']").val();
                        var curMain = $("[name='curMain']").val();
                        var autoJson = $('[name="autoJson"]').val();
                        autoJson = $.parseJSON(autoJson);
                        $.each(autoJson , function(kk , vv) {
                            var obj = $('[name="' + kk + '"]');
                            if(obj.val()){
                                var fieldName = kk;
                                var fieldValue = obj.val();
                                var tag = obj.closest('form').attr('tabfor');
                                var mainid =  obj.closest('form').find('input[name="id"]').val();
                                mainid = isNullorEmpty(mainid)?mainid:'';
                                var mainprojectid =  obj.closest('form').find('input[name="projectid"]').val();
                                projectid = isNullorEmpty(mainprojectid)?mainprojectid:'';
                                var parames = new Object();
                                parames.action=curAction;
                                parames.main=curMain;
                                parames.val=fieldValue;
                                parames.filedval=fieldName;
                                parames.bindrdid=mainid;
                                if(fieldValue){
                                    $.ajax({
                                        url:TP_APP+'/Common/getAutoFormTabs',
                                        data:{'action':curAction,'main':curMain,'val':fieldValue,'filedval':fieldName,'projectid':projectid,
                                            'bindrdid':mainid ,caozuo:$("[name='caozuo']").val(),},
                                        type:'post',
                                        dataType:'json',
                                        success:function(msg){
                                            if(isNullorEmpty(msg.data)){
                                                var obj = $('#tabsContent_'+tag);
                                                var header = obj.find('div.tabsHeader');
                                                $.each(msg.data , function(key , val){
                                                    $.each(val , function(k , v){
                                                        var c=$('#'+key+k+'_edit');
                                                        if(v.url) {
                                                            // 改url地址
                                                            // 重新请求子表页面
                                                            if(v.isformcon=='0'){
                                                                var tempId = k+'_'+tag;
                                                                var curOprateObj = $('#'+tempId, header);
                                                                curOprateObj.attr('href',v.url);
                                                                var index = curOprateObj.parent().index();
                                                                c.loadUrl(v.url,{},function(){});
                                                            }else if(v.isformcon=='1'){
                                                                c.find('a').attr('href',v.url);
                                                                c.find('.tabsContent').loadUrl(v.url,{},function(){});
                                                            }
                                                        }else{
                                                            var caozuo = c.find("[name='caozuo']").val();
                                                            if(caozuo=='add'){

                                                                if(v.length==2){
                                                                    c.find('[name="'+v[0].field+'"]') .val(v[0].val)
                                                                }else{
                                                                    for(var i = 0; i< v.length-2;i++){
                                                                        if(v[i].val!=null){
                                                                            c.find('[name="'+v[i].field+'"]') .val(v[i].val)
                                                                        }
                                                                    }
                                                                }
                                                            }else if(caozuo=='edit'){
                                                                if(v[v.length-1].isbinval=='1'){
                                                                    if(v[v.length-1].isformcon=='0'){
                                                                        var tempId = k+'_'+tag;
                                                                        var curOprateObj = $('#'+tempId, header);
                                                                        curOprateObj.attr('href',v[v.length-1].url);
                                                                        c.loadUrl(v[v.length-1].url,{},function(){
                                                                            if(v.length==2){
                                                                                c.find('[name="'+v[0].field+'"]') .val(v[0].val)
                                                                            }else{
                                                                                for(var i = 0; i< v.length-2;i++){
                                                                                    if(v[i].val!=null){
                                                                                        c.find('[name="'+v[i].field+'"]') .val(v[i].val)
                                                                                    }
                                                                                }
                                                                            }
                                                                        });
                                                                    }else if(v[v.length-1].isformcon=='1'){
                                                                        c.find('a').attr('href',v[v.length-1].url);
                                                                        c.find('.tabsContent').loadUrl(v[v.length-1].url,{},function(){
                                                                            if(v.length==2){
                                                                                c.find('[name="'+v[0].field+'"]') .val(v[0].val)
                                                                            }else{
                                                                                for(var i = 0; i< v.length-2;i++){
                                                                                    if(v[i].val!=null){
                                                                                        c.find('[name="'+v[i].field+'"]') .val(v[i].val)
                                                                                    }
                                                                                }
                                                                            }
                                                                        });
                                                                    }
                                                                }else{

                                                                    if(v.length==2){
                                                                        c.find('[name="'+v[0].field+'"]') .val(v[0].val)
                                                                    }else{
                                                                        for(var i = 0; i< v.length-2;i++){
                                                                            if(v[i].val!=null){
                                                                                c.find('[name="'+v[i].field+'"]') .val(v[i].val)
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }  else{
                                                                if(v.length==2){
                                                                    c.find('[name="'+v[0].field+'"]') .val(v[0].val)
                                                                }else{
                                                                    for(var i = 0; i< v.length-2;i++){
                                                                        if(v[i].val!=null){
                                                                            c.find('[name="'+v[i].field+'"]') .val(v[i].val)
                                                                        }
                                                                    }

                                                                }
                                                            }
                                                        }
                                                    });
                                                });
                                            }

                                        }
                                    });
                                }
                            }

                        });
                    });
                }
            });
        }

    }
}



