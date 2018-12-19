<script type="text/javascript">
    //多个细分品类值时带回保存处理
    var xifen1=$('.field_xifenpinlei #xifenval').val();
    function xifenvalch()	{
        var xifen2=xifen1;
        var xifen = $('.field_xifenpinlei #xifenval').val();
        if(xifen1 != xifen2){
            var xfstr = new Array();
            $("select[name='quickxifenpinlei']").find("option").each(function(){
                var arr = xifen.split(',');
                for(var i = 0;i <= arr.length;i++){
                    if(arr[i] == $(this).text()){
                        xfstr[i] = $(this).val();
                    }
                }
                return xfstr;
            });
            var xifenstr = xfstr.join(",");
            $('.field_xifenpinlei #xinfenno').val(xifenstr);
        }
    }
    window.onload=controll();
</script>
{~$classNodeSettingArr =getModelClassByNodeSetting('#nodeName#','edit')}
{~$appendPageContentArr =getBindTabsContent('#nodeName#',$vo,'edit','',$main)}
{~$formautosetting = setFormControllAutoCreteAppend('#nodeName#' ,'edit' ,$main , 'update',$vo,A('#nodeName#')->rebuildSetting())}
{$appendPageContentArr[1]}
<input type="hidden" value="{$_REQUEST['isformcon']}" name="isformcon"/>
<input type="hidden" value='{$vojson}' name='vojson'>
<input type="hidden" value="{$id}" name="id"/>
<input type="hidden" value="edit" name="caozuo"/>
<input type="hidden" value="#nodeName#" name="nodename"/>
<div class="page" <if condition="#nodeName# eq 'MisAutoIbf'">onmouseover="xifenvalch()"</if>>
	<div class="pageContent">
		<div class="pageFormContent applecloth anchorsToolBarParen"
			<if condition="!$_REQUEST['main'] or $_REQUEST['main'] eq MODULE_NAME">
			<if condition="!$_REQUEST['bindaname']"> layoutH="40"</if> </if>
			>
			<div class="new_version_page ">
				<form id="#nodeName#_edit"
					{$appendPageContentArr[5]} {$formautosetting[3]}  method="post" action="__APP__/#nodeName#/{$formautosetting[2]}/navTabId/__MODULE__{$formautosetting[4]}" class="pageForm required-validate"	 
					onsubmit="<if condition="$formautosetting[5]">{$formautosetting[5]}<else/>{$appendPageContentArr[0]}</if>">
					<a class='xyz_anchornavi_top' name='#nodeName#_edit_top'></a> 
					<input type="hidden" name="callbackType" value="closeCurrent" />
					{:W('HiddenInput',$vo)} 
					<input type="hidden" name="id" value="{$vo['id']}" />
					<input type="hidden" name="masid" value="{$vo['id']}" />
					<input type="hidden" name="shujukumingcheng" value="{$shujukumingcheng}" />
					{$formautosetting[1]}
					<if condition="$_GET['viewtype'] neq 'view'&& !$_GET['main'] ">
					<div class="new_version_page_header pageFormContent ">
						<span class="left tml-ml20 ">#nodeTitle#</span>
						{:W('ShowRightToolBar',array('edit','#nodeName#',$vo))}
						{:W('ShowAnchorNavi',array('#nodeName#', 'edit',$main))}
						{$formautosetting[0]}
					</div>
					</if>
					<div class="new_version_page_content">
						<check name="orderno">
						{:W('ShowOrderno',array(4,'#tableName#',$vo['orderno'],array('contentcls'=>'#class#',	'inputcls'=>'class="input_new "','title'=>$fields["orderno"],'isshow'=>#isshow#)))}
						<else/>
						{:W('ShowOrderno',array(4,'#tableName#',$vo['orderno'],array('contentcls'=>'col_1_3 form_group_lay field_orderno',	'inputcls'=>'class="input_new "','title'=>$fields["orderno"],'isshow'=>1)))}
						</check>	
						#controll#
						<if condition="!$appendPageContentArr[4]">{:W('ShowAction',array('data'=>$vo))}</if>
					</div>
				</form>
				{$appendPageContentArr[2]}
				{$appendPageContentArr[3]}
			</div>
		</div>
	</div>
</div>