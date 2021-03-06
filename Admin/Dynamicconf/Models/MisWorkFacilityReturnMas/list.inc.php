<?php 
return array(
	'0' => array(
		'name' => '序号',
		'showname' => 'id',
		'shows' => '0',
		'widths' => '30',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'id',
		'sortnum' => '1',
		'issearch' => '0',
		'searchField' => 'mis_work_facility_return_mas.id',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'helpvalue' => '',
	),
	'1' => array(
		'name' => 'orderno',
		'showname' => '退还编号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '2',
		'issearch' => '1',
		'searchField' => 'mis_work_facility_return_mas.orderno',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '2',
		'status' => '1',
		'helpvalue' => '',
	),
	'2' => array(
		'name' => 'returndate',
		'showname' => '退还时间',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
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
		'sortname' => 'returndate',
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'mis_work_facility_return_mas.returndate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'status' => '1',
		'helpvalue' => '',
	),
	'3' => array(
		'name' => 'returndeptid',
		'showname' => '退还部门',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => 'MisSystemDepartment',
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
					'3' => 'mis_system_department',
				),
			),
		),
		'sortname' => 'returndeptid',
		'sortnum' => '4',
		'issearch' => '1',
		'searchField' => 'mis_work_facility_return_mas.returndeptid',
		'table' => 'mis_system_department',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db|name',
		'isallsearch' => '0',
		'searchsortnum' => '4',
		'status' => '1',
		'helpvalue' => '',
	),
	'34' => array(
		'name' => 'remark',
		'showname' => '备注说明',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'remark',
		'sortnum' => '6',
		'issearch' => '0',
		'searchField' => 'mis_work_facility_return_mas.remark',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '35',
		'status' => '1',
		'helpvalue' => '',
	),
	'36' => array(
		'name' => 'auditState',
		'showname' => '审核状态',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'auditState',
		'func' => array(
			'0' => array(
				'0' => 'getAuditState',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => '#id#',
					'2' => '#ptmptid#',
				),
			),
		),
		'sortnum' => '7',
		'searchField' => 'mis_work_facility_return_mas.auditState',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'helpvalue' => '',
	),
	'38' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '8',
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
				'0' => 'getStatus',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
						'0' => '#status#',
						'1' => '#id#',
				),
			),
		),
		'helpvalue' => '',
	),
);

?>