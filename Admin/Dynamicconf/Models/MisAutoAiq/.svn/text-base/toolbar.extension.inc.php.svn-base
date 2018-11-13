<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-操作权限配置文件)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-12-13 12:35:41
 * @version V1.0
*/
$original = array(
	'js-add' => array(
		'ifcheck' => '1',
		'permisname' => 'misautoaiq_add',
		'html' => '<a class="js-add add tml-btn tml_look_btn tml_mp" href="__URL__/add" target="dialog" width="720" height="500"  mask="true" rel="MisAutoAiqview"  title="评审模式_新增"><span><span class="icon icon-plus icon_lrp"></span>新增</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	'js-delete' => array(
		'ifcheck' => '1',
		'extendurl' => '"id/".$_REQUEST["defaultid"]',
		'permisname' => 'misautoaiq_delete',
		'html' => '<a title="确定要删除此条数据吗?" target="ajaxTodo" href="__URL__/delete/#extendurl#/navTabId/__MODULE__" class="delete tml-btn tml_look_btn tml_mp"><span><span class="icon icon-plus icon_lrp"></span>删除</span></a>',
		'shows' => '1',
		'sortnum' => '2',
	),
	'js-printOut' => array(
		'ifcheck' => '0',
		'permisname' => 'misbusinesscontractcivilianblasting_printOut',
		'html' => '<a class="js-printOut tml-btn tml_look_btn tml_mp" title="打印" id="printOut" print_url="__URL__/printout" onclick="printOut(this,1)" href="javascript:;" ><span><span class="icon icon-edit icon_lrp"></span>打印</span></a>',
		'shows' => '1',
		'sortnum' => '7',
	),
);
$extedsTool = require 'toolbar.extensionExtend.inc.php';
return array_merge($original , $extedsTool);
?>