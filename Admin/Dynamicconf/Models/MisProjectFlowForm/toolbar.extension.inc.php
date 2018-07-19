<?php 
return array(
	'js-lookupprojectadd' => array(
		'ifcheck' => '1',
		'permisname' => 'misprojctflowform_lookupprojectadd',
		'extendurl' => '"supcategory/".$_REQUEST["supcategory"]."/category/".$_REQUEST["category"]."/pid/".$_REQUEST["pid"]."/projectid/".$_REQUEST["id"]',
		'html' => '<a class="add js-lookupprojectadd tml-btn tml_look_btn tml_mp" href="__APP__/MisProjectFlowForm/lookupprojectadd/#extendurl#" target="navTab" rel="__MODULE__add"  title="项目任务_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	'js-lookupprojectedit' => array(
		'ifcheck' => '1',
		'permisname' => 'misprojctflowform_lookupprojectedit',
		'rules' => '#operateid#==0',
		'html' => '<a class="edit js-lookupprojectedit tml-btn tml_look_btn tml_mp"  href="__APP__/MisProjectFlowForm/lookupprojectedit/id/{sid_node}" target="navTab" rel="lookupProjectEdit" title="项目任务_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-view' => array(
		'ifcheck' => '1',
		'permisname' => 'misprojctflowform_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__APP__/MisProjectFlowForm/view/id/{sid_node}" target="navTab"  title="项目任务_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'misprojctflowform_ldelete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__APP__/MisProjectFlowForm/lookupprojectdelete/id/{sid_node}/rel/lookupProjectEdit" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
);

?>