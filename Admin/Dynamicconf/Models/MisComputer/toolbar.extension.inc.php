<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'extendurl' => '"deptid/".$_REQUEST["deptid"]',
		'permisname' => 'miscomputer_add',
		'html' => '<a class="js-add add tml-btn tml_look_btn tml_mp" href="__URL__/add/#extendurl#" target="navTab" title="电脑配置_新增" rel="__MODULE__add"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'miscomputer_edit',
		'html' => '<a class="js-edit edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid}" target="navTab" title="电脑配置_修改" rel="__MODULE__edit"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'miscomputer_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid}" target="navTab" title="电脑配置_查看" rel="__MODULE__view"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'miscomputer_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid}/rel/computermodel" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '7',
	),
);