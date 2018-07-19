<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-系统视图list.inc 配置文件)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-11-25 16:07:47
 * @version V1.0
*/
return array(
	'id' => array(
		'name' => 'id',
		'showname' => 'ID',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'id',
		'sortnum' => '5',
		'searchField' => 'mis_system_company.id',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'helpvalue' => '',
	),
	'parentid' => array(
		'name' => 'parentid',
		'showname' => '上级公司',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'parentid',
		'sortnum' => '5',
		'searchField' => 'mis_system_company.parentid',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '1',
		'helpvalue' => '',
	),
	'NAME' => array(
		'name' => 'NAME',
		'showname' => '名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'NAME',
		'sortnum' => '5',
		'searchField' => 'mis_system_company.NAME',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '2',
		'helpvalue' => '',
	),
	'orderno' => array(
		'name' => 'orderno',
		'showname' => '编码',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '5',
		'searchField' => 'mis_system_company.orderno',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'helpvalue' => '',
	),
	'yongyouorderno' => array(
		'name' => 'yongyouorderno',
		'showname' => 'U8编码',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'yongyouorderno',
		'sortnum' => '5',
		'searchField' => 'mis_system_company.yongyouorderno',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '4',
		'helpvalue' => '',
	),
);
?>