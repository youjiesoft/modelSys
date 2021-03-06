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
	),
	'1' => array(
		'name' => 'text',
		'showname' => '主要内容',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'text',
		'sortnum' => '2',
		'searchField' => 'mis_user_events.text',
		'table' => '',
		'field' => 'text',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'func' => array(
			'0' => array(
				'0' => 'missubstr',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => '20',
					'2' => 'true',
				),
			),
		),
	),
	'2' => array(
		'name' => 'scheduletype',
		'showname' => '日程类型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'scheduletype',
		'sortnum' => '3',
		'searchField' => 'mis_user_events.scheduletype',
		'table' => '',
		'field' => 'scheduletype',
		'conditions' => '',
		'type' => '',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'func' => array(
			'0' => array(
				'0' => 'excelTplselected',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => '1:个人日程,2:工作日程',
				),
			),
		),
	),
	'3' => array(
		'name' => 'importancedegree',
		'showname' => '重要程度',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'importancedegree',
		'sortnum' => '4',
		'searchField' => 'mis_user_events.importancedegree',
		'table' => '',
		'field' => 'importancedegree',
		'conditions' => '',
		'type' => '',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'func' => array(
			'0' => array(
				'0' => 'excelTplselected',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => '1:一般处理,2:优先处理,3:急需处理',
				),
			),
		),
	),
	'4' => array(
		'name' => 'startdate',
		'showname' => '开始时间',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'startdate',
		'sortnum' => '5',
		'func' => array(
			'0' => array(
				'0' => 'transTime',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
				),
			),
		),
		'issearch' => '1',
		'searchField' => 'mis_user_events.startdate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'5' => array(
		'name' => 'enddate',
		'showname' => '结束时间',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'enddate',
		'sortnum' => '6',
		'func' => array(
			'0' => array(
				'0' => 'transTime',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
				),
			),
		),
		'issearch' => '1',
		'searchField' => 'mis_user_events.enddate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'6' => array(
		'name' => 'personname',
		'showname' => '关联人员',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'personname',
		'sortnum' => '7',
		'searchField' => 'mis_user_events.personname',
		'table' => '',
		'field' => 'personname',
		'conditions' => '',
		'type' => '',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'7' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '8',
		'issearch' => '',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '',
		'searchsortnum' => '',
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
					'6' => '重要日程',
					'7' => '760',
					'8' => '580',
				),
			),
			'1' => array(
				'0' => array(
					'0' => '#status#',
				),
			),
		),
	),
);

?>