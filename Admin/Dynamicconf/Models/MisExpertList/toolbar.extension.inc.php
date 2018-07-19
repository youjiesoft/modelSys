<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'misexpertlist_add',
		'html' => '<a class="add tml-btn tml_look_btn tml_mp" href="__URL__/add" target="navTab" rel="__MODULE__add" title="新增专家信息" ><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//删除
	'js-delete' => array(
			'ifcheck' => '1',
			'permisname' => 'misexpertlist_delete',
			'html' => '<a class="delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/navTabId/__MODULE__" posttype="string" rel="id" target="selectedTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
			'shows' => '1',
			'sortnum' => '2',
	),
	
);