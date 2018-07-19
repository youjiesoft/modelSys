<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'extendurl' => '"pid/".$_REQUEST["pid"]',
		'permisname' => 'mismeetingroomurged_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add/#extendurl#"  rel="__MODULE__add" title="物品-新增"  target="dialog" mask="true" width="700" height="300"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//删除
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'mismeetingroomurged_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	//修改
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'mismeetingroomurged_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid}" rel="__MODULE__edit" target="dialog" mask="true" width="700" height="300" title="物品_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	//查看
	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'mismeetingroomurged_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid}/" rel="__MODULE__view" target="dialog" mask="true" width="700" height="300" title="物品_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
);