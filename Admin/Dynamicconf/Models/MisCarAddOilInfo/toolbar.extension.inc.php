<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'miscaraddoilinfo_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add"  rel="__MODULE__add" title="加油记录_新增"  target="dialog" mask="true" width="700" height="450"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'miscaraddoilinfo_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}" rel="__MODULE__edit" target="dialog" mask="true" width="700" height="450" title="加油记录_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'miscaraddoilinfo_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid_node}/" rel="__MODULE__view" target="dialog" mask="true" width="700" height="450" title="加油记录_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-exportout' => array(
			'ifcheck' => '1',
			'permisname' => 'miscaraddoilinfo_add',
			'html' => '<a class="tbexcel tml-btn tml_look_btn tml_mp" href="__APP__/MisImportExcel/misimportexceladd/id/25" target="dialog" mask="true"><span><span class="icon icon-circle-arrow-down icon_lrp"></span>导入</span></a>',
			'shows' => '1',
			'sortnum' => '4',
	),
	//删除
	'js-delete' => array(
			'ifcheck' => '1',
			'permisname' => 'miscaraddoilinfo_delete',
			'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid_node}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
			'shows' => '1',
			'sortnum' => '4',
	),		
);

