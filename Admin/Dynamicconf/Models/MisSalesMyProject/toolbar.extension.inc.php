<?php 
$original = array(
	'js-edit' => array(
		'ifcheck' => '1',
		'permisname' => 'missalesmyproject_edit',
		'html' => '<a class="js-edit edit tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesProject/view/id/{sid_node}" target="navTab" title="项目信息_修改" rel="__MODULE__edit"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '0',
		'sortnum' => '2',
		'ismore' => '1',
	),
	'js-view1' => array(
		'ifcheck' => '0',
		'permisname' => 'missalesmyproject_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesMyProject/lookupEdit/projectid/{sid_node}" target="navTab" title="项目信息_执行" rel="MisSalesMyProjectlookupEdit"><span><span class="icon icon-eye-open icon_lrp"></span>执行</span></a>',
		'shows' => '0',
		'sortnum' => '3',
	),
	'js-map' => array(
		'ifcheck' => '0',
		'permisname' => 'missalesmyproject_lookupmap',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesMyProject/lookupmap/project/{sid_node}" rel="MisSalesMyProjectlookupmap" target="navTab"  title="执行/进度"><span><span class="icon icon-eye-open icon_lrp"></span>执行/进度</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	'js-view' => array(
		'ifcheck' => '0',
		'permisname' => 'missalesmyproject_view',
		'html' => '<a class="js-map xmzl icon tml-btn tml_look_btn tml_mp" href="__APP__/MisAutoPvb/view/id/{sid_node}" rel="missalesmyproject_view" target="navTab"  title="项目总览"><span><span class="icon icon-eye-open icon_lrp"></span>项目总览</span></a>',
		'shows' => '1',
		'sortnum' => '6',
	),
//	'js-delete' => array(
//		'ifcheck' => '1',
//		'permisname' => 'missalesmyproject_delete',
//		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesMyProject/delete/id/{sid_node}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
//		'shows' => '1',
//		'sortnum' => '5',
//		'ismore' => '1',
//	),
	'js-lookupprojectedit' => array(
		'ifcheck' => '0',
		'permisname' => 'missalesmyproject_lookupprojectedit',
		'html' => '<a class="js-lookupprojectedit icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesMyProject/lookupProjectEdit/id/{sid_node}" rel="missalesmyproject_view" target="navTab"  title="项目任务"><span><span class="icon icon-instagram icon_lrp"></span>项目任务</span></a>',
		'shows' => '1',
		'sortnum' => '7',
		'ismore' => '1',
	),
//	'js-lookupGaiKuang' => array(
//		'ifcheck' => '0',
//		'permisname' => 'missalesmyproject_view',
//		'html' => '<a class="js-map icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesProjectAllocation/lookupGaiKuang/projectid/{sid_node}" target="navTab" rel="MisSalesMyProjectlookupmap" title="项目结构_查看"><span><span class="icon icon-eye-open icon_lrp"></span>项目结构</span></a>',
//		'shows' => '1',
//		'sortnum' => '2',
//		'ismore' => '1',
//	),
	/* 'js-lookupisfile' => array(
		'ifcheck' => '0',
		'permisname' => 'missalesmyproject_lookupisfile',
		'html' => '<a class="js-lookupisfile icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesMyProject/lookupisfile/id/{sid_node}" rel="missalesmyproject_view" target="navTab"  title="归档"><span><span class="icon icon-file icon_lrp"></span>归档</span></a>',
		'shows' => '1',
		'sortnum' => '8',
	), */
//	'js-lookupapprove' => array(
//		'ifcheck' => '0',
//		'permisname' => 'missalesmyproject_lookupapprove',
//		'html' => '<a class="js-lookupapprove icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesMyProject/lookupapprove/id/{sid_node}" rel="missalesmyproject_view" target="navTab"  title="审批文档节点"><span><span class="icon icon-sitemap icon_lrp"></span>审批节点</span></a>',
//		'shows' => '1',
//		'sortnum' => '9',
//	),
//	'js-lookupexport' => array(
//		'ifcheck' => '0',
//		'permisname' => 'missalesmyproject_lookupexport',
//		'html' => '<a class="js-lookupexport icon tml-btn tml_look_btn tml_mp" href="__APP__/MisSalesMyProject/lookupexport/id/{sid_node}" target="outexcel" rel="missalesmyproject_view"   title="导出项目审批意见"><span><span class="icon icon-share-alt  icon_lrp"></span>导出意见</span></a>',
//		'shows' => '1',
//		'sortnum' => '10',
//		'ismore' => '1',
//	),
);
$extedsTool = require "toolbar.extensionExtend.inc.php";
return array_merge($original , $extedsTool);
?>
