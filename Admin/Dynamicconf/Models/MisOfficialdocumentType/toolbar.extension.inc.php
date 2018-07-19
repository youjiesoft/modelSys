<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'misofficialdocumenttype_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add" title="公文类型_新增"  target="dialog" mask="true" width="640" height="320"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//删除
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'misofficialdocumenttype_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid_node}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	//修改
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'misofficialdocumenttype_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}"  target="dialog" mask="true" width="640" height="320" title="公文类型_修改" rel="__MODULE__edit"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	//查看
	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'misofficialdocumenttype_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/auditView/id/{sid_node}/" rel="__MODULE__view" target="dialog" mask="true" width="640" height="320" title="公文类型_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),

);