<?php 
return array(
	//新增
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'selectlist_add',
		'html' => '<a class="js-add add tml-btn tml_look_btn tml_mp" href="__URL__/add/model/modelName" target="navTab" title="新增" mask="true" rel="__MODULE__add"><span  class="icon icon-plus icon_lrp">新增</span></a>',
		
		'shows' => '1',
		'sortnum' => '1',
	),
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'selectlist_edit',
		'html' => '<a class="js-edit edit  add tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}" target="navTab" mask="true" title="修改" rel="__MODULE__edit"><span class="icon icon-plus icon_lrp">修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	/* 'js-view' => array(
		'ifcheck' => '0',
		'permisname' => '',
		'html' => '<a class="js-view icon" href="__URL__/view/id/{sid_node}" target="dialog" width="700" height="350" mask="true" title="查看" rel="__MODULE__view"><span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	), */
);