<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'mismeetingroom_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add" mask="true" target="dialog" title="会议室管理_新增" rel="__MODULE__add" ><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'rules' => '#status#>0',
		'permisname' => 'mismeetingroom_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}"  mask="true"  mask="true" target="dialog" title="会议室管理_修改" rel="__MODULE__edit"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	//单据查看
 	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'mismeetingroom_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid_node}" target="dialog" title="会议室管理_查看" ><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	), 
	//单据删除
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'mismeetingroom_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid_node}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a></a>',
		'shows' => '1',
		'sortnum' => '7',
	),
);