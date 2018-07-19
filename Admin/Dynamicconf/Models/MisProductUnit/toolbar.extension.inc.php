<?php 
return array(
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'misproductunit_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add/mdtype/MisProductUnit" target="dialog"  rel="__MODULE__add" width="555" height="291" mask="true" title="设备单位_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'misproductunit_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}/mdtype/MisProductUnit" target="dialog"  rel="__MODULE__edit" width="555" height="291" mask="true" warn="请选择节点!" title="设备单位_修改" ><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	//单据删除
	'js-delete' => array(
		'ifcheck' => '1',
		'extendurl' => '"table/".$_REQUEST["md"]',
		'permisname' => 'misproductunit_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid_node}/rel/misworkfacilitytype/#extendurl#" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '7',
	),
		
);

