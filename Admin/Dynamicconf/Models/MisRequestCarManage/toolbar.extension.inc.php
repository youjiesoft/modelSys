<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'misrequestcar_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add"  rel="__MODULE__add" title="派车申请_新增"  target="dialog" mask="true" width="670" height="510"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'misrequestcar_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}" rel="__MODULE__edit" target="dialog" mask="true" width="670" height="510" title="派车申请_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'misrequestcar_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/auditView/id/{sid_node}/" rel="__MODULE__view" target="dialog" mask="true" width="670" height="510" title="派车申请_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	//单据撤回
	'js-iconBack' => array(
		'ifcheck' => '1',
		'permisname' => 'misrequestcar_add',
		'html' => '<a class="js-iconBack tbundo tml-btn tml_look_btn tml_mp" href="__URL__/lookupGetBackprocess/id/{sid_node}/navTabId/__MODULE__" warn="请选择节点" target="ajaxTodo" title="您确定要撤回单据吗?"><span><span class="icon icon-external-link icon_lrp"></span>单据撤回</span></a>',
		'shows' => '1',
		'sortnum' => '7',
	),
		
		
);

