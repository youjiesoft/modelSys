<?php 
return array(
	//edit按钮
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'misworkplancontent_edit',
		'html' => '<a class="edit js-edit tml-btn tml_look_btn tml_mp" href="__URL__/edit/id/{sid_node}" target="navTab" title="工作计划查阅_点评" rel="__MODULE__edit"><span><span class="icon icon-edit icon_lrp"></span>点评</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-view' => array(
		'ifcheck' => '0',
		'permisname' => '',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__URL__/view/id/{sid_node}" target="navTab" title="工作计划查阅_查看" rel="__MODULE__view"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
);