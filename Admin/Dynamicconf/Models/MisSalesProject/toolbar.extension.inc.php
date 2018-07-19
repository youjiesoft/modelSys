<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'misfinanceborrowmas_add',
		'html' => '<a class="js-add add tml-btn tml_look_btn tml_mp" href="__URL__/add" target="navTab" title="项目初始化" rel="__MODULE__add"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'rules' => '#auditState#==0||#auditState#==-1',
		'permisname' => 'misfinanceborrowmas_edit',
		'html' => '<a class="js-edit edit tml-btn tml_look_btn tml_mp" href="__URL__/lookupEdit/projectid/{sid}" target="navTab" title="项目信息_修改" rel="__MODULE__edit"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-view' => array(
		'ifcheck' => '0',
		'permisname' => 'misfinanceborrowmas_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid}" target="navTab" title="项目信息_查看" rel="__MODULE__view"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	//单据
	'js-delete' => array(
		'ifcheck' => '1',
		'rules' => '#auditState#==0||#auditState#==-1',
		'permisname' => 'misfinanceborrowmas_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
		//单据
	'js-map' => array(
		'ifcheck' => '1',
		'html' => '<a class="js-map map tml-btn tml_look_btn tml_mp" href="__URL__/map" target="navTab" title="项目信息_查看" rel="__MODULE__view"><span><span class="icon icon-eye-open icon_lrp"></span>项目进度</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	
);