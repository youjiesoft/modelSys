<?php 
return array(
		//新增
		'js-add' => array(
				'ifcheck' => '1',
				'permisname' => 'mismeetingroomusemange_add',
				'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add"  rel="__MODULE__add" title="会议室申请-新增"  target="navTab" mask="true" ><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
				'shows' => '1',
				'sortnum' => '1',
		),
		//删除
		'js-delete' => array(
				'ifcheck' => '1',
				'rules' => '#auditState#==0||#auditState#==-1',
				'permisname' => 'mismeetingroomusemange_delete',
				'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid_node}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
				'shows' => '1',
				'sortnum' => '2',
		),
		//edit按钮
		'js-edit' => array(
				'ifcheck' => '1',
				'rules' => '#auditState#==0||#auditState#==-1',
				'permisname' => 'mismeetingroomusemange_edit',
				'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}" rel="__MODULE__edit" target="navTab" mask="true" title="会议室申请_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
				'shows' => '1',
				'sortnum' => '3',
		),
		//查看
		'js-view' => array(
			'ifcheck' => '1',
			'permisname' => 'mismeetingroomusemange_view',
			'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid_node}" rel="__MODULE__view" target="navTab" mask="true"  title="会议室申请_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
			'shows' => '1',
			'sortnum' => '4',
		),
		//单据撤回
		'js-iconBack' => array(
				'ifcheck' => '1',
				'rules' => '#auditState#==1',
				'permisname' => 'mismeetingroomusemange_add',
				'html' => '<a class="js-iconBack tbundo tml-btn tml_look_btn tml_mp" href="__URL__/lookupGetBackprocess/id/{sid_node}/navTabId/__MODULE__" warn="请选择节点" target="ajaxTodo" title="您确定要撤回单据吗?"><span><span class="icon icon-external-link icon_lrp"></span>单据撤回</span></a>',
				'shows' => '1',
				'sortnum' => '5',
		),
);