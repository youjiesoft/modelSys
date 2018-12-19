
<!-- 
审批流模板：审批主页
author:nbmxkj
time:2015-09-06 18
 -->
 <div class="pageContent">
	<form id="pagerForm" action="__URL__/{$jumpUrl}" method="post">
		<input type="hidden" name="pageNum" value="1"/>
		<input type="hidden" name="orderField" value="{$order}" />
		<input type="hidden" name="orderDirection" value="{$sort}" />
	</form>
	<div class="panelBar">
		<ul class="toolBar">
			<if condition="$audit eq 0">
				<li><a class="redo tml-btn tml_look_btn tml_mp" href="__URL__/auditEdit/id/{sid}" target="navTab" title="意向担保函审核" rel="__MODULE__auditEdit" warn="请选择节点"><span><span class="icon-plus icon_lrp"></span>{$Think.lang.auditprocess}</span></a></li>
			</if>
			<if condition="$audit eq 1">
				<li><a class="icon tml-btn tml_look_btn tml_mp" href="__URL__/auditView/id/{sid}" target="navTab" title="查看" rel="__MODULE__auditView" warn="请选择节点"><span><span class="icon-eye-open"></span>查看</span></a></li>
			</if>
			<li><a class="detail tml-btn tml_look_btn tml_mp" href="__URL__/seeProcessDetail/id/{sid}" target="dialog" height="450" width="580" mask="true" title="流程查看" rel="__MODULE__seeProcessDetail" warn="请选择节点"><span><span class="icon icon-plus icon_lrp"></span>流程查看</span></a></li>
		</ul>
		<form rel="pagerForm" onsubmit="return divSearch(this, '__MODULE__indexview')" action="__URL__/{$jumpUrl}" method="post">
			<div class="searchBar">
				<table class="searchContent">
					<tr>
						<include file="Public:quickSearchCondition" />
					</tr>
				</table>
			</div>
		</form>
	</div>
	<table class="table" width="100%" layoutH="146">
		<thead>
		<tr>
			<th width="26"><input type="checkbox" name="all" onclick="chk()"></th>
			<th width="26">序号</th>
			<volist id="vo" name="detailList">
				<if condition="$vo[shows] eq 1"><th <if condition="$vo[widths]">width="{$vo[widths]}"</if><if condition="$vo[sorts]"> rel="__MODULE__indexview" orderField="{$vo[sortname]}" class="{$sort}"</if>>{$vo[showname]}</th></if>	<!--类型-->
			</volist>
		</tr>
		</thead>
		<tbody>
			<volist id="vo" name="list" key="key2">
				<tr target="sid" rel="{$vo['id']}" onclick="onTrClickCheckbox(this,'id')" <if condition="$vo[curNodeUser] && in_array($_SESSION[C('USER_AUTH_KEY')],explode(',',$vo[curNodeUser]))"> class="auditformeselected" </if>  <if condition="$audit eq 1">  title="查看" ondblclick="ondblclick_navTab(this,'__MODULE__auditView','__URL__/auditView/id/{$vo['id']}');"</if><if condition="$audit eq 0">title="申请单审核" ondblclick="ondblclick_navTab(this,'__MODULE__auditEdit','__URL__/auditEdit/id/{$vo['id']}');"</if>>
					<td class="tml-first-td">{$numPerPage*($currentPage-1)+$key+1}</td>
					<volist id="vo1" name="detailList">
						<if condition="$vo1[shows] eq 1">
							<td width="{$vo1[widths]}">
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
		</tbody>
   </table>
	<div class="panelBar panelPageBar">
		<div class="pages">
			<span>共{$totalCount}条</span>
		</div>
		<div class="pagination" rel="__MODULE__indexview" totalCount="{$totalCount}" numPerPage="{$numPerPage}" pageNumShown="10" currentPage="{$currentPage}"></div>
	</div>
</div>