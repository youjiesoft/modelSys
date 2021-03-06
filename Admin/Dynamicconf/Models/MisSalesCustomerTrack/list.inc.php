<?php 
return array(
	'1' => array(
		'name' => 'enterpriseserve',
		'showname' => '企业需求服务',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'enterpriseserve',
		'sortnum' => '1',
		'func' => array(
			'0' => array(
				'0' => 'excelTplselected',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => '',
					'2' => 'checkbox',
				),
			),
		),
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.enterpriseserve',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '1',
		'helpvalue' => '',
	),
	'2' => array(
		'name' => 'needmoney',
		'showname' => '需求金额',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'needmoney',
		'sortnum' => '2',
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
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.needmoney',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '2',
		'helpvalue' => '',
	),
	'3' => array(
		'name' => 'firstcontacttime',
		'showname' => '首次接触日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'firstcontacttime',
		'sortnum' => '3',
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
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.firstcontacttime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'helpvalue' => '',
	),
	'4' => array(
		'name' => 'deptname',
		'showname' => '服务部门',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'deptname',
		'sortnum' => '4',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.deptname',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '4',
		'helpvalue' => '',
	),
	'5' => array(
		'name' => 'username',
		'showname' => '经办人员',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'username',
		'sortnum' => '5',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.username',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '5',
		'helpvalue' => '',
	),
	'6' => array(
		'name' => 'serverinfo',
		'showname' => '跟踪日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'serverinfo',
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
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.serverinfo',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '6',
		'helpvalue' => '',
	),
	'7' => array(
		'name' => 'qksm',
		'showname' => '服务跟踪情况',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'qksm',
		'sortnum' => '7',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.qksm',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '7',
		'helpvalue' => '',
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
				),
			),
		),
	),
	'8' => array(
		'name' => 'txdata',
		'showname' => '提醒日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'txdata',
		'sortnum' => '8',
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
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.txdata',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '8',
		'helpvalue' => '',
	),
	'13' => array(
		'name' => 'txcontent',
		'showname' => '提醒事宜',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'txcontent',
		'sortnum' => '9',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.txcontent',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '14',
		'helpvalue' => '',
	),
	'9' => array(
		'name' => 'servercompany',
		'showname' => '最终服务机构',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'servercompany',
		'sortnum' => '10',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.servercompany',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '9',
		'helpvalue' => '',
	),
	'10' => array(
		'name' => 'lendamount',
		'showname' => '放款额度（元）',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'lendamount',
		'sortnum' => '11',
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
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.lendamount',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '10',
		'helpvalue' => '',
	),
	'11' => array(
		'name' => 'lendtime',
		'showname' => '放贷日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'lendtime',
		'sortnum' => '12',
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
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_sales_customer_track.lendtime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '11',
		'helpvalue' => '',
	),
	'12' => array(
		'name' => 'action',
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
					'0' => '#status#',
				),
			),
		),
		'sortnum' => '13',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'helpvalue' => '',
	),
);

?>