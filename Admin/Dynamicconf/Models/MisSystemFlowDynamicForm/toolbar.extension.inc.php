<?php 
return array(
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'missystemflowdynamicform_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__APP__/MisSystemFlowDynamicForm/add" mask="true" target="dialog" width="720" height="400" rel="__MODULE__add"  title="任务动态表单_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'missystemflowdynamicform_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp"  href="__APP__/MisSystemFlowDynamicForm/edit/id/{sid_node}" mask="true" rel="id" target="dialog" width="720" height="400" title="任务动态表单_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-view' => array(
		'ifcheck' => '0',
		'permisname' => 'missystemflowdynamicform_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSystemFlowDynamicForm/view/id/{sid_node}" mask="true" target="dialog" width="720" height="400"  title="任务动态表单_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'missystemflowdynamicform_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__APP__/MisSystemFlowDynamicForm/delete/id/{sid_node}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
);

?>