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
		'issearch' => '',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '',
		'searchsortnum' => '',
	),
	'1' => array(
		'name' => 'orderno',
		'showname' => '培训编号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '2',
		'issearch' => '1',
		'searchField' => 'mis_hr_personnel_training_manage.orderno',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '2',
	),
	'2' => array(
		'name' => 'personid',
		'showname' => '员工姓名',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'personid',
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
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'mis_hr_personnel_training_manage.personid',
		'table' => 'mis_hr_personnel_person_info',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'isallsearch' => '',
		'searchsortnum' => '3',
	),
	'3' => array(
		'name' => 'deptid',
		'showname' => '部门',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'deptid',
		'sortnum' => '4',
		'issearch' => '1',
		'func' => array(
			'1' => array(
				'0' => 'getFieldBy',
				'1' => 'getFieldBy',
			),
		),
		'funcdata' => array(
			'1' => array(
				'0' => array(
					'0' => '#personid#',
					'1' => 'id',
					'2' => 'deptid',
					'3' => 'mis_hr_personnel_person_info',
				),
				'1' => array(
					'0' => '###',
					'1' => 'id',
					'2' => 'name',
					'3' => 'mis_system_department',
				),
			),
		),
		'searchField' => 'mis_hr_personnel_training_manage.personid',
		'table' => 'mis_system_department,mis_hr_personnel_person_info',
		'field' => '',
		'conditions' => '',
		'type' => 'db|name,deptid',
		'isallsearch' => '',
		'searchsortnum' => '4',
	),
	'4' => array(
		'name' => 'dutyname',
		'showname' => '职务',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'dutyname',
		'func' => array(
			'0' => array(
				'0' => 'getFieldBy',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '#personid#',
					'1' => 'id',
					'2' => 'dutyname',
					'3' => 'mis_hr_personnel_person_info',
				),
			),
		),
		'sortnum' => '5',
		'issearch' => '1',
		'searchField' => 'mis_hr_personnel_training_manage.personid',
		'table' => 'mis_hr_personnel_person_info',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db|dutyname',
		'isallsearch' => '',
		'searchsortnum' => '5',
	),
	'5' => array(
		'name' => 'entrytime',
		'showname' => '入职时间',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'entrytime',
		'sortnum' => '6',
		'issearch' => '1',
		'func' => array(
			'0' => array(
				'0' => 'getFieldBy',
				'1' => 'transTime',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '#personid#',
					'1' => 'id',
					'2' => 'indate',
					'3' => 'mis_hr_personnel_person_info',
				),
				'1' => array(
					'0' => '###',
				),
			),
		),
		'searchField' => 'mis_hr_personnel_training_manage.entrytime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '',
		'searchsortnum' => '6',
	),
	'7' => array(
		'name' => 'createtime',
		'showname' => '创建时间',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createtime',
		'sortnum' => '8',
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
		'issearch' => '',
		'searchField' => 'mis_hr_personnel_training_manage.createtime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '',
		'searchsortnum' => '8',
	),
	'8' => array(
		'name' => 'updatetime',
		'showname' => '修改时间',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'updatetime',
		'sortnum' => '9',
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
		'issearch' => '',
		'searchField' => 'mis_hr_personnel_training_manage.updatetime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '',
		'searchsortnum' => '9',
	),
	'9' => array(
		'name' => 'createid',
		'showname' => '创建人',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createid',
		'sortnum' => '10',
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
					'3' => 'user',
				),
			),
		),
		'issearch' => '',
		'searchField' => 'mis_hr_personnel_training_manage.createid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '',
		'searchsortnum' => '10',
	),
	'10' => array(
		'name' => 'updateid',
		'showname' => '修改人',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'updateid',
		'sortnum' => '11',
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
					'3' => 'user',
				),
			),
		),
		'issearch' => '',
		'searchField' => 'mis_hr_personnel_training_manage.updateid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '',
		'searchsortnum' => '11',
	),
	'11' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '12',
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
					'5' => 'navTab',
					'6' => '员工培训',
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