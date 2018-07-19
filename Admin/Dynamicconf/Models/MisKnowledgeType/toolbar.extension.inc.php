<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'extendurl' => '"typeid/".$_REQUEST["typeid"]',
		'permisname' => 'misknowledgetype_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add/#extendurl#"  rel="__MODULE__add" title="分类-新增"  target="dialog" mask="true" width="415" height="280"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	//删除
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'misknowledgetype_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid}/rel/misknowledgetype" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	//修改
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'misknowledgetype_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid}"  target="dialog" mask="true" width="415" height="280" title="公文类型_修改" rel="__MODULE__edit"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
);