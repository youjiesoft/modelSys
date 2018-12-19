<!--
审批流模板：新增页面
author:nbmxkj
time:2015-09-06 18
 -->
	<script type="text/javascript">
        //多个细分品类值时带回保存处理
        function xifenvalch()	{
            var xifen = $('.field_xifenpinlei #xifenval').val();
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
        window.onload=controll();
	</script>
{~$classNodeSettingArr = getModelClassByNodeSetting('#nodeName#','add')}
{~$appendPageContentArr = getBindTabsContent('#nodeName#','','add','',$main)}
{~$formautosetting = setFormControllAutoCreteAppend('#nodeName#' ,'add' , $main , 'insert',$vo,A('#nodeName#')->rebuildSetting())}
{$appendPageContentArr[1]}
<input type="hidden" value="{$_REQUEST['isformcon']}" name="isformcon"/>
<input type="hidden" value='{$vojson}' name='vojson'>
<input type="hidden" value="add" name="caozuo"/>
<input type="hidden" value="#nodeName#" name="nodename"/>
 <div class="page">
	<div class="pageContent" <if condition="#nodeName# eq 'MisAutoIbf'">onmouseover="xifenvalch()"</if> >
		<div class="pageFormContent applecloth anchorsToolBarParen" <if condition="$_REQUEST['dialog']">layoutH="40"</if><if condition="!$_REQUEST['main'] or $_REQUEST['main'] eq MODULE_NAME"> layoutH="40"</if>>
			<div <if condition="!$_REQUEST['dialog']">class="new_version_page"</if>>
				<form method="post" id="#nodeName#_add" {$appendPageContentArr[5]} {$formautosetting[3]} action="__APP__/#nodeName#/{$formautosetting[2]}/navTabId/__MODULE__{$formautosetting[4]}" 
				class="pageForm required-validate"  
				onsubmit="<if condition="$formautosetting[5]">{$formautosetting[5]}<else/>{$appendPageContentArr[0]}</if>">
	 			<if condition="#nodeName# eq 'MisAutoJwf'"><input type="hidden" id="nbpw" value="{$vo['neibupingwei']}"/></if>
				<a class='xyz_anchornavi_top' name='#nodeName#_add_top'></a>
					<input type="hidden" name="callbackType" value="closeCurrent">
					{:W('HiddenInput',$vo)}
					<input type="hidden" name="beforeInsert" value="1">
					{$formautosetting[1]}
					<if condition="$_GET['viewtype'] neq 'view'">
					<div class="new_version_page_header pageFormContent "><span class="left tml-ml20 ">#nodeTitle#</span>
					{:W('ShowRightToolBar',array('add','#nodeName#'))}{:W('ShowAnchorNavi',array('#nodeName#' , 'add',$main))}{$formautosetting[0]}</div>
					</if>
					<div class="new_version_page_content">
					<check name="orderno">
					{:W('ShowOrderno',array(4,'#tableName#',$vo['orderno'],array('contentcls'=>'#class#',	'inputcls'=>'class="input_new "','title'=>$fields["orderno"],'isshow'=>#isshow#)))}
					<else/>
					{:W('ShowOrderno',array(4,'#tableName#',$vo['orderno'],array('contentcls'=>'col_1_3 form_group_lay field_orderno',	'inputcls'=>'class="input_new "','title'=>$fields["orderno"],'isshow'=>1)))}
					</check>
					#controll#
					<div class="showFormFlow">{:W('ShowFormFlow')}</div>
					{:W('ShowNotify')}
					<if condition="!$appendPageContentArr[4]">{:W('ShowAction',array('data'=>$vo))}</if>
					</div>
					<div class="clear">
						<span style="display:none;" class="anchornaviforshow">#nodeName#_add</span>
						<a class='xyz_anchornavi_buttom' name='#nodeName#_add_bottom'></a>
					</div>
				</form>
				<div class="clear"></div>
				{$appendPageContentArr[2]}
				{$appendPageContentArr[3]}
			</div>
		</div>
	</div>
</div>