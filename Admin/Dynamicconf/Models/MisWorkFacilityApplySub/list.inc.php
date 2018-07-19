<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => '序号',
		'shows' => '0',
		'widths' => '30',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'id',
		'sortnum' => '1',
		'issearch' => '0',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'13' => array(
		'name' => 'orderno',
		'showname' => '设备编号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '2',
		'issearch' => '1',
		'searchField' => 'mis_work_facility_apply_sub.manageid',
		'table' => 'mis_work_facility_manage',
		'field' => '',
		'conditions' => '',
		'type' => 'db|orderno',
		'isallsearch' => '0',
		'searchsortnum' => '1',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'1' => array(
		'name' => 'equipmentname',
		'showname' => '设备名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'equipmentname',
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'mis_work_facility_apply_sub.manageid',
		'table' => 'mis_work_facility_manage',
		'field' => '',
		'conditions' => '',
		'type' => 'db',
		'isallsearch' => '0',
		'searchsortnum' => '2',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'2' => array(
		'name' => 'equipmenttype',
		'showname' => '设备类型',
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
					'3' => 'mis_work_facility_type',
				),
			),
		),
		'sortname' => 'equipmenttype',
		'sortnum' => '4',
		'issearch' => '1',
		'searchField' => 'mis_work_facility_apply_sub.equipmenttype',
		'table' => 'mis_work_facility_type',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db|name',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'35' => array(
		'name' => 'manageid',
		'showname' => '设备id',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'place',
		'sortnum' => '5',
		'issearch' => '0',
		'searchField' => 'mis_work_facility_manage.manageid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '36',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'3' => array(
		'name' => 'version',
		'showname' => '设备型号(厂家)',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'version',
		'sortnum' => '5',
		'issearch' => '0',
		'searchField' => 'mis_work_facility_apply_sub.version',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '4',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'4' => array(
		'name' => 'qty',
		'showname' => '数量',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'qty',
		'sortnum' => '6',
		'issearch' => '1',
		'searchField' => 'mis_work_facility_apply_sub.qty',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '5',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
		'func' => array(
			'0' => array(
				'0' => 'getDigits',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
				),
			),
		),
	),
	'5' => array(
		'name' => 'kymove',
		'showname' => '可异动数量',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'kymove',
		'sortnum' => '7',
		'issearch' => '1',
		'searchField' => 'mis_work_facility_apply_sub.kymove',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '6',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
		'func' => array(
			'0' => array(
				'0' => 'getDigits',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
				),
			),
		),
	),
	'7' => array(
		'name' => 'departmentid',
		'showname' => '现存放部门',
		'shows' => '0',
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
		'sortname' => 'departmentid',
		'sortnum' => '8',
		'issearch' => '0',
		'searchField' => 'mis_work_facility_apply_mas.departmentid',
		'table' => 'mis_system_department',
		'field' => '',
		'conditions' => '',
		'type' => 'db|name',
		'isallsearch' => '0',
		'searchsortnum' => '7',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'6' => array(
		'name' => 'unit',
		'showname' => '单位',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => 'MisProductUnit',
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
					'3' => 'mis_product_unit',
				),
			),
		),
		'sortname' => 'unit',
		'sortnum' => '11',
		'issearch' => '0',
		'searchField' => 'mis_work_facility_apply_sub.unit',
		'table' => 'mis_product_unit',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db|name',
		'isallsearch' => '0',
		'searchsortnum' => '10',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'11' => array(
		'name' => 'remark',
		'showname' => '备注说明',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'remark',
		'sortnum' => '12',
		'issearch' => '0',
		'searchField' => 'mis_work_facility_apply_sub.remark',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '11',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'12' => array(
		'name' => 'status',
		'showname' => '状态',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'func' => array(
			'0' => array(
				'0' => 'getStatus',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
				),
			),
		),
		'sortnum' => '13',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
);

?>