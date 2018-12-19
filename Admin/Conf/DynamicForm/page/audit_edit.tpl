
<!-- 
审批流模板：修改页面
author:nbmxkj
time:2015-09-06 18
 -->
<script type="text/javascript">
    //多个细分品类值时带回保存处理
	var xifen1=$('.field_xifenpinlei #xifenval').val();
    function xifenvalch()	{
        var xifen2=xifen1;
        var xifen = $('.field_xifenpinlei #xifenval').val();
        if(xifen2 != xifen){
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
{~$appendPageContentArr = getBindTabsContent('#nodeName#',$vo,'edit','',$main)}
{~$formautosetting = setFormControllAutoCreteAppend('#nodeName#' ,'edit' , $main , 'update',$vo,A('#nodeName#')->rebuildSetting())}
{$appendPageContentArr[1]}
 {~$classNodeSettingArr = getModelClassByNodeSetting('#nodeName#','edit')}
<input type="hidden" value="{$_REQUEST['isformcon']}" name="isformcon"/>
<input type="hidden" value='{$vojson}' name='vojson'>
<input type="hidden" value="{$id}" name="id"/>
<input type="hidden" value="edit" name="caozuo"/>
<input type="hidden" value="#nodeName#" name="nodename"/>
<div class="page" <if condition="#nodeName# eq 'MisAutoIbf'">onmouseover="xifenvalch()"</if>>
	<div class="pageContent">
		<div class="pageFormContent applecloth anchorsToolBarParen" <if condition="!$_REQUEST['main'] or $_REQUEST['main'] eq MODULE_NAME">layoutH="40"</if>>
			<div class="new_version_page ">
				<form method="post" id="#nodeName#_edit" {$appendPageContentArr[5]} {$formautosetting[3]} action="__APP__/#nodeName#/{$formautosetting[2]}/navTabId/__MODULE__{$formautosetting[4]}" class="pageForm required-validate" 
				onsubmit="<if condition="$formautosetting[5]">{$formautosetting[5]}<else/>{$appendPageContentArr[0]}</if>">
				<a class='xyz_anchornavi_top' name='#nodeName#_edit_top'></a>
					<input type="hidden" name="id" value="{$vo['id']}" />
					<input type="hidden" name="callbackType" value="closeCurrent">
					<input type="hidden" name="masid" value="{$vo['id']}" />
					{:W('HiddenInput',$vo)}
					{$formautosetting[1]}
					<if condition="$_GET['viewtype'] neq 'view'">
					<div class="new_version_page_header pageFormContent "><span class="left tml-ml20 ">#nodeTitle#</span>
					{:W('ShowRightToolBar',array('edit','#nodeName#',$vo))}{:W('ShowAnchorNavi',array('#nodeName#' , 'edit',$main))}{$formautosetting[0]}</div>
					</if>
					<div class="new_version_page_content">
						 <check name="orderno">
						{:W('ShowOrderno',array(4,'#tableName#',$vo['orderno'],array('contentcls'=>'#class#',	'inputcls'=>'class="input_new "','title'=>$fields["orderno"],'isshow'=>#isshow#)))}
						<else/>
						{:W('ShowOrderno',array(4,'#tableName#',$vo['orderno'],array('contentcls'=>'col_1_3 form_group_lay field_orderno',	'inputcls'=>'class="input_new "','title'=>$fields["orderno"],'isshow'=>1)))}
						</check>
						
						#controll#
						<div class="showFormFlow">{:W('ShowFormFlow',$vo)}</div>
						{:W('ShowNotify',$vo)}
						<if condition="!$appendPageContentArr[4]">{:W('ShowAction',array('data'=>$vo))}</if>
					</div>
					<div class="clear">
						<span style="display:none;" class="anchornaviforshow">#nodeName#_edit</span>
						<a class='xyz_anchornavi_buttom' name='#nodeName#_edit_bottom'></a>
					</div>
				</form>
				{$appendPageContentArr[2]}
				{$appendPageContentArr[3]}
			</div>	
		</div>
	</div>
</div>