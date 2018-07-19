<?php 
return array(
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'missalescustomerperson_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesCustomerPerson/add" target="navTab" rel="__MODULE__add"  title="个人信息_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'missalescustomerperson_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp"  href="__APP__/MisSalesCustomerPerson/edit/id/{sid_node}" rel="__MODULE__edit"  target="navTab" title="个人信息_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'missalescustomerperson_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesCustomerPerson/view/id/{sid_node}" target="navTab"  title="个人信息_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'missalescustomerperson_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesCustomerPerson/delete/id/{sid_node}/rel/misSalesCustomerTreeBox" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
);

?>