<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'missalescustomertype_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add/type/1" rel="__MODULE__add" target="dialog" mask="true" width="700" height="400"  title="新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'missalescustomertype_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid}/type/1" rel="__MODULE__edit" target="dialog" mask="true" width="700" height="400" title="修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	//删除
	'js-delete' => array(
			'ifcheck' => '1',
			'permisname' => 'missalescustomertype_delete',
			'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
			'shows' => '1',
			'sortnum' => '3',
	),
	//view按钮
	'js-view' => array(
		'ifcheck' => '0',
		'permisname' => 'missalescustomertype_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid}" rel="__MODULE__view" target="dialog" mask="true" width="700" height="400" title="查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '5',
	),
);