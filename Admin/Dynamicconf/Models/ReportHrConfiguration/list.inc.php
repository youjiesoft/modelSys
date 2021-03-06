<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => 'ID',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'id',
		'sortnum' => '1',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'isexport' => '0',
	),
	'3' => array(
		'name' => 'name',
		'showname' => '等级名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'name',
		'sortnum' => '4',
		'searchField' => 'mis_hr_report_configuration.name',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '4',
		'status' => '1',
		'isexport' => '0',
	),
	'4' => array(
		'name' => 'startage',
		'showname' => '年龄开始值',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'startage',
		'sortnum' => '5',
		'searchField' => 'mis_hr_report_configuration.startage',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '5',
		'status' => '1',
		'isexport' => '0',
	),
	'5' => array(
		'name' => 'endage',
		'showname' => '成绩结束值',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'endage',
		'sortnum' => '6',
		'searchField' => 'mis_hr_report_configuration.endage',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '6',
		'status' => '1',
		'isexport' => '0',
	),
	'7' => array(
		'name' => 'remark',
		'showname' => '备注',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'remark',
		'sortnum' => '8',
		'searchField' => 'mis_hr_report_configuration.remark',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '8',
		'status' => '1',
		'isexport' => '0',
	),
	'8' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '9',
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
				'0' => 'getOperateStatus',
			),
			'1' => array(
				'0' => 'getStatus',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '#createid#',
					'1' => '#auditState#',
					'2' => 'id/#id#',
					'3' => '',
					'4' => '',
					'5' => 'dialog',
					'6' => '年龄设置',
					'7' => '350',
					'8' => '340',
				),
			),
			'1' => array(
				'0' => array(
					'0' => '#status#',
				),
			),
		),
		'isexport' => '0',
	),
);

?>