<?php 
return array(
	'9' => array(
		'name' => 'setdate',
		'showname' => '建档日期',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'setdate',
		'sortnum' => '0',
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
		'issearch' => '0',
		'searchField' => 'mis_performance_assess.setdate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '9',
		'status' => '1',
	),
	'1' => array(
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
	),
	'2' => array(
		'name' => 'orderno',
		'showname' => '计划编码',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '2',
		'searchField' => 'mis_performance_assess.orderno',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '2',
		'status' => '1',
	),
	'3' => array(
		'name' => 'name',
		'showname' => '计划名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'name',
		'sortnum' => '3',
		'searchField' => 'mis_performance_assess.name',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
	),
	'4' => array(
		'name' => 'cycle',
		'showname' => '绩效周期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'cycle',
		'sortnum' => '4',
		'searchField' => 'mis_performance_assess.cycle',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '4',
		'status' => '1',
	),
	'5' => array(
		'name' => 'course',
		'showname' => '绩效期间/名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'course',
		'sortnum' => '5',
		'searchField' => 'mis_performance_assess.course',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '5',
		'status' => '1',
	),
	'6' => array(
		'name' => 'tempid',
		'showname' => '关联模版',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'func' => array(
			'0' => array(
				'0' => 'getFieldBy',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'id',
					'2' => 'name',
					'3' => 'mis_performance_template',
				),
			),
		),
		'sortname' => 'tempid',
		'sortnum' => '6',
		'searchField' => 'mis_performance_assess.tempid',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '1',
	),
	'7' => array(
		'name' => 'salarydate',
		'showname' => '薪资关联期间',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'salarydate',
		'sortnum' => '7',
		'issearch' => '1',
		'searchField' => 'mis_performance_assess.salarydate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '7',
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
					'1' => 'Y-m',
					'2' => '',
				),
			),
		),
	),
	'8' => array(
		'name' => 'userid',
		'showname' => '建档人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'func' => array(
			'0' => array(
				'0' => 'getFieldBy',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'id',
					'2' => 'name',
					'3' => 'mis_hr_personnel_person_info',
				),
			),
		),
		'sortname' => 'userid',
		'sortnum' => '8',
		'searchField' => 'mis_performance_assess.userid',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '8',
		'status' => '1',
		'table' => 'mis_hr_personnel_person_info',
	),
	'10' => array(
		'name' => 'mostscore',
		'showname' => '最高分',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'mostscore',
		'sortnum' => '10',
		'searchField' => 'mis_performance_assess.mostscore',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '10',
		'status' => '1',
	),
	'11' => array(
		'name' => 'levelid',
		'showname' => '绩效等级',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'func' => array(
			'0' => array(
				'0' => 'getFieldBy',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'id',
					'2' => 'name',
					'3' => 'MisPerformanceType',
				),
			),
		),
		'sortname' => 'levelid',
		'sortnum' => '11',
		'searchField' => 'mis_performance_assess.levelid',
		'table' => 'mis_performance_type',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '11',
		'status' => '1',
	),
	'12' => array(
		'name' => 'ostatus',
		'showname' => '计划状态',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'ostatus',
		'sortnum' => '12',
		'issearch' => '0',
		'func' => array(
			'0' => array(
				'0' => 'ostatuslist',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => '0:起草,1:发布,2:执行,3:暂停,4:结束',
				),
			),
		),
		'searchField' => 'mis_performance_assess.ostatus',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '12',
		'status' => '1',
	),
	'13' => array(
		'name' => 'byusers',
		'showname' => '被考核人',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'byusers',
		'sortnum' => '13',
		'searchField' => 'mis_performance_assess.byusers',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '13',
		'status' => '1',
	),
	'14' => array(
		'name' => 'inusers',
		'showname' => '考核人',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'inusers',
		'sortnum' => '14',
		'searchField' => 'mis_performance_assess.inusers',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '14',
		'status' => '1',
	),
	'15' => array(
		'name' => 'inusersqz',
		'showname' => '考核人权重',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'inusersqz',
		'sortnum' => '15',
		'searchField' => 'mis_performance_assess.inusersqz',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '15',
		'status' => '1',
	),
	'16' => array(
		'name' => 'remark',
		'showname' => '备注',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'remark',
		'sortnum' => '16',
		'searchField' => 'mis_performance_assess.remark',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '16',
		'status' => '1',
	),
	'17' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '17',
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
					'5' => 'navTab',
					'6' => '绩效评估',
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