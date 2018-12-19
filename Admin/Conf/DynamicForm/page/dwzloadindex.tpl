<input type="hidden" id="sid_node"/>
<volist id="vo" name="list" key="key2">
	<tr   target="sid_node" rel="{$vo['id']}" data-tool='{$vo[classarr]}' <if condition="$vo['isVoid'] eq 1"> style="text-decoration:line-through;"</if>>
	<td class="tml-first-td"><input type="checkbox" name="check_row" value="{$vo['id']}" onclick="checkk(this)"  target="sid_node" rel="{$vo['id']}" /></td>
	<td class="tml-first-td">{$numPerPage*($currentPage-1)+$key+1}</td>
	<volist id="vo1" name="detailList">
		<if condition="$vo1[shows] eq 1">
			<td width="{$vo1[widths]}" align="<?php echo empty($vo1[yangshi])?'left':$vo1[yangshi];?>">
				<if condition="count($vo1['func']) gt 0">
					<volist name="vo1.func" id="nam">
						<if condition="!empty($vo1['extention_html_start'][$key])">{$vo1['extention_html_start'][$key]}</if>
                        {:getConfigFunction($vo[$vo1['name']],$nam,$vo1['funcdata'][$key],$list[$key2-1])}
						<if condition="!empty($vo1['extention_html_end'][$key])">{$vo1['extention_html_end'][$key]}</if>
					</volist>
					<else />
                    {$vo[$vo1['name']]}
				</if>
			</td>
		</if>
	</volist>
	</tr>
</volist>
<script>
    //全选按钮的操作
    function chk(){
        var all = document.getElementsByName('all');
        var mychk = document.getElementsByName("check_row");
        var sid_node = document.getElementById('sid_node');
        var str='';
        var links=document.getElementsByClassName('tml_look_btn');
        var tool = mychk[0].parentNode.parentNode.parentNode.getAttribute("data-tool");
        if(all[0].checked==true){
            if(tool=='[]'){
                for(var i =0 ;i<links.length;i++){
                    if(links[i].className.search('disabled')==-1){
                        links[i].className+=' disabled';     //每个都加
                    }
                }
            }
            if(tool.search("js-delete")!=-1)  {  //如果包含delete   除了delete 全变灰
                for(var i =0 ;i<links.length;i++){
                    if(links[i].className.search('js-delete')==-1){
                        if(links[i].className.search('disabled')==-1){
                            links[i].className+=' disabled';     //每个都加
                        }
                    }
                }
            }
            if(tool.search("js-void")!=-1)  {  //如果包含void   除了作废 全变灰
                for(var i =0 ;i<links.length;i++){
                    if(links[i].className.search('js-void')==-1){
                        if(links[i].className.search('disabled')==-1){
                            links[i].className+=' disabled';     //每个都加
                        }
                    }
                }
            }
            if(mychk.length){
                for(var i=0;i<mychk.length;i++){
                    mychk[i].checked = true;
                    mychk[i].parentNode.parentNode.parentNode.className = 'selected';
                    if(str==''){
                        str=mychk[i].value
                    }else{
                        str+=','+mychk[i].value
                    }
                }
                sid_node.value=str;
            }
            mychk.chcked=true;
        }else{
            for(var i =0 ;i<links.length;i++){
                if(links[i].className.search('js-void')==-1){
                    var classname = links[i].className;
                    classname= classname.replace('disabled','') ;
                    links[i].className=classname;
                }
            }
            if(mychk.length){
                for(var i=0;i<mychk.length;i++){
                    mychk[i].checked = false;
                    mychk[i].parentNode.parentNode.parentNode.className = '';
                }
                sid_node.value='';
            }
        }
    }
    //复选框的操作
    function  checkk(e){
        var tool = e.parentNode.parentNode.parentNode.getAttribute("data-tool");
        butt(tool);
    }

    function butt(tool){
        var obj = document.getElementsByName("check_row");
        var check_val = [];
        for(var k in obj){
            if(obj[k].checked)
                check_val.push(obj[k].value);     //选中值
        }
        var links=document.getElementsByClassName('tml_look_btn');
        if(check_val.length>1){    //如果长度大于1只可以删除可作废
            if(tool==''){
                for(var i =0 ;i<links.length;i++){
                    if(links[i].className.search('disabled')==-1){
                        links[i].className+=' disabled';     //每个都加
                    }
                }
            }
            if(tool.search("js-delete")!=-1)  {  //如果包含delete   除了delete 全变灰
                for(var i =0 ;i<links.length;i++){
                    if(links[i].className.search('js-delete')==-1){
                        if(links[i].className.search('disabled')==-1){
                            links[i].className+=' disabled';     //每个都加
                        }
                    }
                }
            }
            if(tool.search("js-void")!=-1)  {  //如果包含void   除了作废 全变灰
                for(var i =0 ;i<links.length;i++){
                    if(links[i].className.search('js-void')==-1){
                        if(links[i].className.search('disabled')==-1){
                            links[i].className+=' disabled';     //每个都加
                        }
                    }
                }
            }

        }else if(check_val.length==1){
            for(var i =0 ;i<links.length;i++){
                if(links[i].className.search('disabled')==-1){
                    links[i].className+=' disabled';     //每个都加
                }

            }
            var obj = eval('(' + tool + ')');
            for(var o in obj){
                var a = document.getElementsByClassName(o);   // 去掉disabled
                var classname = a[0].className;
                classname= classname.replace('disabled','') ;
                a[0].className=classname;
            }

        }

    }
</script>
