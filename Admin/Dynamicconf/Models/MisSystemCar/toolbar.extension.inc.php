<?php 
return array(
		//新增
		'js-add' => array(
			'ifcheck' => '1',
			'permisname' => 'missystemcar_add',
			'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add"  rel="__MODULE__add" title="车辆信息_新增"  target="navTab"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
			'shows' => '1',
			'sortnum' => '1',
		),
		//edit按钮
		'js-edit' => array(
			'ifcheck' => '1',
			'permisname' => 'missystemcar_edit',
			// relx 值有用的 不能删除 ,用于处理刷新
			'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}/relx/1" rel="__MODULE__edit" target="navTab" title="车辆信息_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
			'shows' => '1',
			'sortnum' => '3',
		),
		//删除
		'js-delete' => array(
				'ifcheck' => '1',
				'permisname' => 'miscarinsurance_delete',
				'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid_node}/rel/missystemcar" target="ajaxTodo" title="你确定要删除吗？" warn="删除此数据可能会引起数据不完整,请谨慎操作!"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
				'shows' => '1',
				'sortnum' => '4',
		),	
);

