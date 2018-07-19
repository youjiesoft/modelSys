<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'mismeetinguserecord_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add" rel="__MODULE__add" target="navTab"  title="会议室使用记录_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//删除
	'js-delete' => array(
		'ifcheck' => '1',
		'rules' => '#auditState#==0||#auditState#==-1',
		'permisname' => 'mismeetinguserecord_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'rules' => '#auditState#==0||#auditState#==-1',
		'permisname' => 'mismeetinguserecord_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid}" rel="__MODULE__edit" target="navTab"  title="会议室使用记录_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	//查看
	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'mismeetinguserecord_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/auditView/id/{sid}/" rel="__MODULE__view" target="navTab"   title="会议室使用记录_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	//单据作废
	'js-abolish' => array(
		'ifcheck' => '1',
		'rules' => '#abolish#==2',
		'permisname' => 'mismeetinguserecord_add',
		'html' => '<a class="tbnouse js-abolish tml-btn tml_look_btn tml_mp" href="__URL__/lookupabolish/id/{sid}/navTabId/__MODULE__" warn="请选择节点" target="ajaxTodo" title="您确定将此记录作废吗?"><span><span class="icon icon-remove-sign icon_lrp"></span>作废</span></a>',
		'shows' => '1',
		'sortnum' => '5',
	),
);