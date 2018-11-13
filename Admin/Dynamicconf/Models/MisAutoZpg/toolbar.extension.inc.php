<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-操作权限配置文件)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-12-23 15:20:57
 * @version V1.0
*/
$original = array(
	'js-add' => array(
		'ifcheck' => '1',
		'rules' => '#conveneStatus#==2 && #shifoujieshu#==0',
		'permisname' => 'misautozpg_add',
		'html' => '<a class="js-add add tml-btn tml_look_btn tml_mp" href="__URL__/add/id/{sid_node}"   target="navTab" rel="MisAutoZpgindexview" title="表决"><span><span class="icon icon-plus icon_lrp"></span>表决</span></a>',
		'shows' => '1',
		'sortnum' => '1',
	),
	'js-edit' => array(
		'ifcheck' => '1',
		'rules' => '#shifoujieshu#==0',
		'permisname' => 'misautozpg_edit',
		'html' => '<a class="js-edit edit tml-btn tml_look_btn tml_mp"  href="__URL__/edit/id/{sid_node}/pingshenhuileixing/'.$_REQUEST['pingshenhuileixing'].'" rel="MisAutoZpgindexview"  target="navTab"  title="表决_修改"><span><span class="icon icon-edit icon_lrp"></span>修改</span></a>',
		'shows' => '1',
		'sortnum' => '3',
	),
	'js-view' => array(
		'ifcheck' => '0',
		'rules' => '#'.$_REQUEST['biaojueStatus'].'#==2',
		'permisname' => 'misautozpg_view',
		'html' => '<a class="js-view icon tml-btn tml_look_btn tml_mp" href="__APP__/'.$_REQUEST['ModelAction'].'/view/id/{sid_node}/eid/{sid_node}/pingshenhuileixing/'.$_REQUEST['pingshenhuileixing'].'"  target="navTab" title="表决_查看"><span><span class="icon icon-eye-open icon_lrp"></span>查看</span></a>',
		'shows' => '1',
		'sortnum' => '4',
	),
	'js-delete' => array(
		'ifcheck' => '1',
		'permisname' => 'misautozpg_delete',
		'html' => '<a class="js-delete delete tml-btn tml_look_btn tml_mp" href="__URL__/delete/id/{sid_node}/navTabId/__MODULE__" target="ajaxTodo" title="你确定要删除吗？" warn="请选择一条组记录"><span><span class="icon icon-trash icon_lrp"></span>删除</span></a>',
		'shows' => '0',
		'sortnum' => '2',
	),
	/* 'js-itemview' => array(
			'ifcheck' => '0',
			'extendurl' => '"id/".$_REQUEST["projectid"]',
			'permisname' => 'misautozpg_itemview',
			'html' => '<a class="js-itemview icon tml-btn tml_look_btn tml_mp" href="__APP__/MisAutoEbm/view/"  target="navTab" title="项目_查看"><span><span class="icon icon-eye-open icon_lrp"></span>项目查看</span></a>',
			'shows' => '1',
			'sortnum' => '6',
	), */
	'js-addremind' => array(
		'ifcheck' => '0',
		'permisname' => 'misautozpg_remind',
		'html' => '<a class="tml_look_btn  tml_mp js-addremind" mask="true" href="__APP__/MisSystemRemind/lookupaddremind/md/MisAutoZpg" rel="__MODULE__addremind" target="dialog" width="640" height="227"  title="加入提醒"><span class="icon-bell icon_lrp"></span><span>加入提醒</span></a>',
		'shows' => '0',
		'sortnum' => '5',
	),
	'js-printOut' => array(
		'ifcheck' => '0',
		'permisname' => 'misbusinesscontractcivilianblasting_printOut',
		'html' => '<a class="js-printOut tml-btn tml_look_btn tml_mp" title="打印" id="printOut" print_url="__URL__/printout" onclick="printOut(this,1)" href="javascript:;" ><span><span class="icon icon-edit icon_lrp"></span>打印</span></a>',
		'shows' => '0',
		'sortnum' => '7',
	),
);
$extedsTool = require 'toolbar.extensionExtend.inc.php';
return array_merge($original , $extedsTool);
?>