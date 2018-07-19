<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'missalescustomer_add',
		'extendurl' => '"typeid/".$_REQUEST["typeid"]',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesCustomer/add/#extendurl#" rel="__MODULE__add" target="navTab" title="客户信息_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'misfinanceborrowmas_edit',
		'html' => '<a class="js-edit edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}" target="navTab" title="客户档案_修改" rel="__MODULE__edit"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-runoff' => array(
		'ifcheck' => '1',
		'rules' => '#lossstatus#==1',
		'permisname' => 'missalescustomer_loss',
		'html' => '<a class="js-runoff tbopt tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesCustomer/loss/id/{sid_node}" target="dialog" mask="true" width="450" height="260"  title="流失客户" ><span><span class="icon icon-cogs icon_lrp"></span>设置流失</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-normal' => array(
		'ifcheck' => '1',
		'rules' => '#lossstatus#!=1',
		'permisname' => 'missalescustomer_loss',
		'html' => '<a class="js-normal tbopt tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesCustomer/loss/jump/1/id/{sid_node}/rel/misSalesCustomerTreeBox" target="ajaxTodo"><span><span class="icon icon-undo icon_lrp"></span>设置正常</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
);
?>