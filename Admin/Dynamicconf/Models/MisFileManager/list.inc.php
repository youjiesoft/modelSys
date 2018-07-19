<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-list)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-06-02 13:58:15
 * @version V1.0
*/
return array(
	'name' => array(
		'name' => 'name',
		'showname' => '名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'name',
		'sortnum' => '1',
		'searchField' => 'mis_file_manager.name',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '1',
		'status' => '1',
		'func' => array(
			'0' => array(
				'0' => 'getExtension',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
				),
			),
		),
		'helpvalue' => '',
	),
	'size' => array(
		'name' => 'size',
		'showname' => '大小',
		'shows' => '1',
		'widths' => '200',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'size',
		'sortnum' => '2',
		'searchField' => 'mis_file_manager.size',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '2',
		'status' => '1',
		'helpvalue' => '',
	),
	'ext' => array(
		'name' => 'ext',
		'showname' => '类型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'ext',
		'sortnum' => '3',
		'searchField' => 'mis_file_manager.ext',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'status' => '1',
		'helpvalue' => '',
	),
	'updatetime' => array(
		'name' => 'updatetime',
		'showname' => '修改日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'updatetime',
		'sortnum' => '5',
		'searchField' => 'mis_file_manager.updatetime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '4',
		'status' => '1',
		'func' => array(
			'0' => array(
				'0' => 'transTime',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'Y-m-d H:i',
				),
			),
		),
		'helpvalue' => '',
	),
	'createtime' => array(
		'name' => 'createtime',
		'showname' => '创建日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createtime',
		'sortnum' => '6',
		'searchField' => 'mis_file_manager.createtime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '5',
		'status' => '1',
		'func' => array(
			'0' => array(
				'0' => 'transTime',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'Y-m-d H:i',
				),
			),
		),
		'helpvalue' => '',
	),
	'action' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '7',
		'issearch' => '0',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'extention_html_end' => array(
			'0' => ' ',
		),
		'func' => array(
			'0' => array(
				'0' => 'createUrl',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '[共享]',
					'1' => 'id/#id#',
					'2' => 'MisFileManager',
					'3' => 'lookupWriteAss',
					'4' => 'lookupWriteAss',
					'5' => 'dialog',
					'6' => '#name# 共享',
					'7' => '',
					'8' => '660',
					'9' => '400',
				),
			),
		),
		'helpvalue' => '',
	),
	'remark' => array(
		'name' => 'remark',
		'showname' => '备注',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'ext',
		'sortnum' => '4',
		'searchField' => 'mis_file_manager.remark',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'status' => '1',
		'helpvalue' => '',
	),
);

?>