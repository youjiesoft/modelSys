<?php 
return array(
	'js-edit' => array(
		'ifcheck' => '0',
		'permisname' => 'missalebusiness_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp"  href="__APP__/MisSaleBusiness/edit/id/{sid_node}" rel="__MODULE__edit"  target="navTab" title="商机_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-view' => array(
		'ifcheck' => '0',
		'permisname' => 'missalebusiness_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleBusiness/view/id/{sid_node}" rel="__MODULE__view" target="navTab"  title="商机_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	'js-delete' => array(
		'ifcheck' => '0',
		'permisname' => 'missalebusiness_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleBusiness/delete/id/{sid_node}/rel/MisSaleBusiness_jbsx" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '0',
		'sortnum' => '2',
		'rules' => '',
		'disabledrules' => '#businessstatus#==1',
		'rulesinfo' => '',
		'showrules' => '',
		'disabledmap' => '',
	),
	'js-allot' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==1 && ==1',
		'permisname' => 'missalebusiness_allot',
		'html' => '<a class="js-allot icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleBusiness/allot/id/{sid_node}/rel/MisSaleBusiness_jbsx"   rel="MisSaleBusiness" target="dialog" width="720" height="400"  mask="true"   title="商机_分派"><span><span class="icon icon-stackexchange icon_lrp"></span>分派</span></a>',
		'shows' => '1',
		'sortnum' => '5',
	),
	'js-turn' => array(
		'ifcheck' => '0',
		'rules' => '#businessstatus#==1  && ==1',
		'permisname' => 'missalebusiness_turn',
		'html' => '<a class="js-turn turn tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleBusiness/lookupturn/id/{sid_node}" target="dialog" width="720" height="400"  mask="true" title="商机转交" warn="请选择一条组记录"><span><span class="icon icon-share-alt icon_lrp"></span>转交</span></a>',
		'shows' => '1',
		'sortnum' => '6',
	),
	'js-reallot' => array(
		'ifcheck' => '0',
		'rules' => '==1',
		'permisname' => 'missalebusiness_reallot',
		'html' => '<a class="js-reallot icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleBusiness/reallot/id/{sid_node}" rel="MisSaleBusiness_jbsx"  target="dialog" width="720" height="400"  mask="true"  title="商机_再分派"><span><span class="icon icon-stackexchange icon_lrp"></span>再分派</span></a>',
		'shows' => '1',
		'sortnum' => '9',
	),
	'js-check' => array(
		'ifcheck' => '0',
		'permisname' => 'missalebusiness_check',
		'html' => '<a class="js-check check tml-btn tml_look_btn tml_mp" href="__APP__/MisSaleBusiness/check/id/{sid_node}/rel/MisSaleBusiness_jbsx" target="ajaxTodo" title="你确定通过吗？" warn="请选择一条组记录"><span><span class="icon icon-check icon_lrp"></span>通过</span></a>',
		'shows' => '1',
		'sortnum' => '10',
	),
);

?>