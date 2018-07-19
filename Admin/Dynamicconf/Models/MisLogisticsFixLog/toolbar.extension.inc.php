<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'mislogisticsfixlog_add',
		'html' => '<a class="js-add add tml-btn tml_look_btn tml_mp" href="__URL__/add" target="navTab" title="日常维护申请_新增" rel="__MODULE__add" ><span><span class="icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'rules' => '#auditState#==0||#auditState#==-1',
		'permisname' => 'mislogisticsfixlog_edit',
		'html' => '<a class="js-edit edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid}" target="navTab" title="日常维护申请_修改" rel="__MODULE__edit"><span><span class="icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-view' => array(
		'ifcheck' => '0',
		'permisname' => 'mislogisticsfixlog_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid}" target="navTab" title="日常维护申请_查看" ><span><span class="icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	//单据删除
	'js-delete' => array(
		'ifcheck' => '1',
		'rules' => '#auditState#==0||#auditState#==-1',
		'permisname' => 'mislogisticsfixlog_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid}/rel/__MODULE__indexview" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组申请"><span><span class="icon-trash icon_lrp"></span>删除</span></a></a>',
		'shows' => '1',
		'sortnum' => '7',
	),
	//单据撤回
	'js-iconBack' => array(
			'ifcheck' => '1',
			'rules' => '#auditState#==1',
			'permisname' => 'mislogisticsfixlog_add',
			'html' => '<a class="js-iconBack tbundo tml-btn tml_look_btn tml_mp" href="__URL__/lookupGetBackprocess/id/{sid}/navTabId/__MODULE__" warn="请选择节点" target="ajaxTodo" title="您确定要撤回单据吗?"><span><span class="icon-external-link icon_lrp"></span>单据撤回</span></a>',
			'shows' => '1',
			'sortnum' => '8',
	),
);