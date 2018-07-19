<?php 
return array(
		//新增
		'js-add' => array(
				'ifcheck' => '1',
				'permisname' => 'misknowledgelevelsvisibility_add',
				'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add"  rel="__MODULE__add" title="等级-新增" rel="__MODULE__add" target="dialog" width="700" height="450" mask="true" ><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
				'shows' => '1',
				'sortnum' => '1',
		),
		//删除
		'js-delete' => array(
				'ifcheck' => '1',
				'rules' => '#auditState#==0||#auditState#==-1',
				'permisname' => 'misknowledgelevelsvisibility_delete',
				'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
				'shows' => '1',
				'sortnum' => '2',
		),
		//edit按钮
		'js-edit' => array(
				'ifcheck' => '1',
				'rules' => '#auditState#==0||#auditState#==-1',
				'permisname' => 'misknowledgelevelsvisibility_edit',
				'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid}" rel="__MODULE__edit" target="dialog" rel="__MODULE__edit"  width="700" height="450" mask="true" title="等级_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
				'shows' => '1',
				'sortnum' => '3',
		),
);