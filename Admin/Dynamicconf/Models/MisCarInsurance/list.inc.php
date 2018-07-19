<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => '编号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
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
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'1' => array(
		'name' => 'carid',
		'showname' => '车辆名',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'carid',
		'sortnum' => '2',
		'searchField' => 'mis_car_insurance.carid',
		'table' => 'mis_system_car',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db|name',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '1',
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
		'status' => '1',
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'2' => array(
		'name' => 'business',
		'showname' => '全保商业金额',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'business',
		'sortnum' => '3',
		'searchField' => 'mis_car_insurance.business',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '1',
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
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'3' => array(
		'name' => 'compulsory',
		'showname' => '交强险',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'compulsory',
		'sortnum' => '4',
		'searchField' => 'mis_car_insurance.compulsory',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '7',
		'status' => '1',
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
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'4' => array(
		'name' => 'company',
		'showname' => '保险公司',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'company',
		'sortnum' => '5',
		'searchField' => 'mis_car_insurance.company',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '5',
		'status' => '1',
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'5' => array(
		'name' => 'buy_time',
		'showname' => '购买日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'buy_time',
		'sortnum' => '6',
		'func' => array(
			'0' => array(
				'0' => 'date',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => 'Y-m-d',
					'1' => '###',
				),
			),
		),
		'searchField' => 'mis_car_insurance.buy_time',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '4',
		'status' => '1',
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'6' => array(
		'name' => 'expire_time',
		'showname' => '到期日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'expire_time',
		'sortnum' => '7',
		'func' => array(
			'0' => array(
				'0' => 'date',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => 'Y-m-d',
					'1' => '###',
				),
			),
		),
		'searchField' => 'mis_car_insurance.expire_time',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'status' => '1',
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'7' => array(
		'name' => 'beneficiary',
		'showname' => '投保人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'beneficiary',
		'sortnum' => '8',
		'searchField' => 'mis_car_insurance.beneficiary',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '2',
		'status' => '1',
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'8' => array(
		'name' => 'remark',
		'showname' => '备注',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'remark',
		'sortnum' => '9',
		'searchField' => 'mis_car_insurance.remark',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '8',
		'status' => '1',
		'isexport' => '1',
		'rules' => '0',
		'message' => '0',
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
		'sortnum' => '47',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
);

?>