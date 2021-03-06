<?php 
return array(
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'missalemybusiness_add',
		'html' => '<a class="add js-add tml-btn tml_look_btn tml_mp" href="__URL__/add" target="navTab" rel="__MODULE__add"  title="商机_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	'js-edit' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==1',
		'permisname' => 'missalemybusiness_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp"  href="__URL__/edit/id/{sid_node}" rel="__MODULE__edit"  target="navTab" title="商机_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-view' => array(
		'ifcheck' => '0',
		'permisname' => 'missalemybusiness_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleBusiness/view/id/{sid_node}" rel="__MODULE__view" target="navTab"  title="商机_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'missalemybusiness_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleMyBusiness/delete/id/{sid_node}/rel/MisSaleMyBusiness_left" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '0',
		'sortnum' => '2',
		'rules' => '',
		'disabledrules' => '#businessstatus#==1',
		'rulesinfo' => '',
		'showrules' => '',
		'disabledmap' => '',
	),
	'js-accept' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==2',
		'permisname' => 'missalemybusiness_accept',
		'html' => '<a class="js-accept accept tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleMyBusiness/accept/id/{sid_node}/rel/MisSaleMyBusiness_left" target="ajaxTodo" title="你确定同意受理吗？" warn="请选择一条组记录"><span><span class="icon icon-ok icon_lrp"></span>同意</span></a>',
		'shows' => '1',
		'sortnum' => '5',
	),
	'js-turn' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==3  && ==1',
		'permisname' => 'missalemybusiness_turn',
		'html' => '<a class="js-turn turn tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleMyBusiness/turn/id/{sid_node}/rel/MisSaleMyBusiness_left" target="dialog" width="720" height="400"  mask="true" title="商机转交" warn="请选择一条组记录"><span><span class="icon icon-share-alt icon_lrp"></span>转交</span></a>',
		'shows' => '1',
		'sortnum' => '6',
	),
	'js-allot' => array(
		'ifcheck' => '0',
		'rules' => '(#businessstatus#==1 || #businessstatus#==3) && ==1',
		'permisname' => 'missalemybusiness_allot',
		'html' => '<a class="js-allot icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleBusiness/allot/id/{sid_node}/rel/MisSaleMyBusiness_left"   rel="__MODULE__" target="dialog" width="720" height="400"  mask="true"   title="商机_分派"><span><span class="icon icon-stackexchange icon_lrp"></span>分派</span></a>',
		'shows' => '1',
		'sortnum' => '7',
	),
	'js-reject' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==2',
		'permisname' => 'missalemybusiness_reject',
		'html' => '<a class="js-reject reject tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleMyBusiness/reject/id/{sid_node}/rel/MisSaleMyBusiness_left" target="dialog" width="720" height="400"  mask="true" title="商机取消受理" warn="请选择一条组记录"><span><span class="icon icon-remove icon_lrp"></span>不同意</span></a>',
		'shows' => '1',
		'sortnum' => '8',
	),
	'js-reserve' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==3',
		'permisname' => 'missalemybusiness_reserve',
		'html' => '<a class="reserve js-reserve tml-btn tml_look_btn tml_mp"  href="__APP__/MisAutoTss/add/id/{sid_node}" rel="__MODULE__resaveadd"   target="navTab" title="商机_转储备" warn="请选择一条组记录"><span><span class="icon icon-archive icon_lrp"></span>转储备</span></a>',
		'shows' => '1',
		'sortnum' => '9',
	),
	'js-item' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==3',
		'permisname' => 'missalemybusiness_item',
		'html' => '<a class="js-item item tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesMyProject/add/bid/{sid_node}/rel/MisSaleMyBusiness_left" rel="__MODULE__itemadd" target="navTab" title="项目初始化" warn="请选择一条组记录"><span><span class="icon icon-sitemap icon_lrp"></span>转项目</span></a>',
		'shows' => '1',
		'sortnum' => '10',
	),
	'js-acquireself' => array(
		'ifcheck' => '0',
		'permisname' => 'missalemybusiness_acquireself',
		'html' => '<a class="js-acquireself icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleMyBusiness/lookupacquireself/id/{sid_node}/rel/MisSaleMyBusiness_left" target="ajaxTodo" title="你确定要获取吗？" warn="请选择一条组记录" ><span><span class="icon icon-stackexchange icon_lrp"></span>获取</span></a>',
		'shows' => '1',
		'sortnum' => '11',
	),
	'js-communicate' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==3',
		'permisname' => 'missalemybusiness_communicate',
		'html' => '<a class="js-communicate icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleCommunicateLog/lookupcommunicate/id/{sid_node}" rel="id" target="dialog" width="720" height="400"  mask="true" title="添加沟通记录" ><span><span class="icon icon-plus icon_lrp"></span>添加沟通记录</span></a>',
		'shows' => '1',
		'sortnum' => '12',
	),
	'js-client' => array(
		'ifcheck' => '0',
		'rules' => '#turncustomer#==0 && #businessstatus#==3',
		'permisname' => 'missalemybusiness_client',
		'html' => '<a class="js-client client tml-btn tml_look_btn tml_mp" href="__APP__/MisAutoCbj/add/bid/{sid_node}/rel/MisSaleMyBusiness_left"  rel="__MODULE____MODULE__clientadd"  target="navTab" title="客户基本信息"  warn="请选择一条组记录"><span><span class="icon icon-sitemap icon_lrp"></span>转客户</span></a>',
		'shows' => '1',
		'sortnum' => '13',
	),
);

?>