<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-操作权限配置文件)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-08-15 13:01:16
 * @version V1.0
*/
$original = array(
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'missalebusinesssource_add',
		'html' => '<a class="js-add add tml-btn tml_look_btn tml_mp" href="__URL__/add" target="ajax" rel="MisSaleBusinessSourceview"  title="商机来源_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	'js-delete' => array(
		'ifcheck' => '1',
		'extendurl' => '"id/".$_REQUEST["defaultid"]',
		'permisname' => 'missalebusinesssource_delete',
		'html' => '<a title="确定要删除此条数据吗?" target="ajaxTodo" href="__URL__/delete/#extendurl#/navTabId/__MODULE__" class="delete tml-btn tml_look_btn tml_mp"><span><span class="icon icon-plus icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-printOut' => array(
		'ifcheck' => '0',
		'permisname' => 'missalebusinesssource_printout',
		'html' => '<a class="js-printOut tml-btn tml_look_btn tml_mp" title="打印" rel_id="{sid_node}" id="printOut" print_url="__URL__/printout" onclick="printOut(this,1)" href="javascript:;" ><span><span class="icon icon-edit icon_lrp"></span>打印</span></a>',
		'shows' => '0',
		'sortnum' => '7',
	),
);
$extedsTool = require 'toolbar.extensionExtend.inc.php';
return array_merge($original , $extedsTool);
?>