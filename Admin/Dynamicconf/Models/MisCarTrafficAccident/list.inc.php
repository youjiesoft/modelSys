<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => '编号',
		'shows' => '0',
		'widths' => '',
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
		'isexport' => '1',
		'helpvalue' => '',
	),
	'1' => array(
		'name' => 'carid',
		'showname' => '车牌号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'carid',
		'sortnum' => '2',
		'extention_html_end' => array(
			'0' => '-',
		),
		'func' => array(
			'0' => array(
				'0' => 'getFieldBy',
			),
			'1' => array(
				'0' => 'getFieldBy',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'id',
					'2' => 'carno',
					'3' => 'mis_system_car',
				),
			),
			'1' => array(
				'0' => array(
					'0' => '###',
					'1' => 'id',
					'2' => 'name',
					'3' => 'mis_system_car',
				),
			),
		),
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.carid',
		'table' => 'mis_system_car',
		'field' => '',
		'conditions' => '',
		'type' => 'db|carno',
		'isallsearch' => '1',
		'searchsortnum' => '1',
		'status' => '1',
		'isexport' => '1',
		'helpvalue' => '',
	),
	'2' => array(
		'name' => 'accidentdate',
		'showname' => '事故发生日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'accidentdate',
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.accidentdate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '2',
		'status' => '1',
		'isexport' => '1',
		'func' => array(
			'0' => array(
				'0' => 'transtime',
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
	'3' => array(
		'name' => 'accidentcaddr',
		'showname' => '事故发生地点',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'accidentcaddr',
		'sortnum' => '4',
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.accidentcaddr',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'isexport' => '1',
		'helpvalue' => '',
	),
	'4' => array(
		'name' => 'accidentnature',
		'showname' => '事故性质',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'accidentnature',
		'sortnum' => '5',
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.accidentnature',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '4',
		'status' => '1',
		'isexport' => '1',
		'helpvalue' => '',
	),
	'5' => array(
		'name' => 'accidentliability',
		'showname' => '责任方',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'accidentliability',
		'sortnum' => '6',
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.accidentliability',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '5',
		'status' => '1',
		'isexport' => '1',
		'helpvalue' => '',
	),
	'6' => array(
		'name' => 'accidentcause',
		'showname' => '事故原因',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'accidentcause',
		'sortnum' => '7',
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.accidentcause',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '6',
		'status' => '1',
		'isexport' => '1',
		'helpvalue' => '',
	),
	'7' => array(
		'name' => 'vehicledamage',
		'showname' => '车辆损坏程度',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'vehicledamage',
		'sortnum' => '8',
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.vehicledamage',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '7',
		'status' => '1',
		'isexport' => '1',
		'helpvalue' => '',
	),
	'8' => array(
		'name' => 'directeconomic',
		'showname' => '赔付金额',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'directeconomic',
		'sortnum' => '9',
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.directeconomic',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '8',
		'status' => '1',
		'isexport' => '1',
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
		'helpvalue' => '',
	),
	'9' => array(
		'name' => 'employeeid',
		'showname' => '驾驶人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'employeeid',
		'sortnum' => '10',
		'issearch' => '1',
		'searchField' => 'mis_car_traffic_accident.employeeid',
		'table' => 'mis_hr_personnel_person_info',
		'field' => '',
		'conditions' => '',
		'type' => 'db',
		'isallsearch' => '1',
		'searchsortnum' => '9',
		'status' => '1',
		'isexport' => '1',
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
		'helpvalue' => '',
	),
	'46' => array(
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
		'sortnum' => '11',
		'helpvalue' => '',
	),
);

?>