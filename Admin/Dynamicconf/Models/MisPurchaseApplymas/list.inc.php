<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => 'ID',
		'shows' => '1',
		'widths' => '20',
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
	'1' => array(
		'name' => 'orderno',
		'showname' => '申请单号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '2',
		'issearch' => '1',
		'searchField' => 'mis_purchase_applymas.orderno',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '2',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'7' => array(
		'name' => 'typeid',
		'showname' => '申请类型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => 'MisPurchaseBasicType',
		'sortname' => 'typeid',
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
					'3' => 'mis_order_types',
				),
			),
		),
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'mis_purchase_applymas.typeid',
		'table' => 'mis_order_types',
		'field' => 'id',
		'conditions' => 'type=5 and status=1',
		'type' => 'group|name',
		'isallsearch' => '0',
		'searchsortnum' => '9',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'17' => array(
		'name' => 'userid',
		'showname' => '申请人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => 'User',
		'sortname' => 'userid',
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
					'3' => 'User',
				),
			),
		),
		'sortnum' => '4',
		'issearch' => '1',
		'searchField' => 'mis_purchase_applymas.userid',
		'table' => 'user',
		'field' => 'id',
		'conditions' => 'status=1',
		'type' => 'db',
		'isallsearch' => '1',
		'searchsortnum' => '16',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'11' => array(
		'name' => 'apdate',
		'showname' => '申请日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'apdate',
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
		'sortnum' => '5',
		'issearch' => '1',
		'searchField' => 'mis_purchase_applymas.apdate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '12',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'6' => array(
		'name' => 'dmsdate',
		'showname' => '需求开始日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'dmsdate',
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
		'sortnum' => '6',
		'issearch' => '1',
		'searchField' => 'mis_purchase_applymas.dmsdate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '7',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'2' => array(
		'name' => 'dmedate',
		'showname' => '需求结束日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'dmedate',
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
		'sortnum' => '7',
		'issearch' => '1',
		'searchField' => 'mis_purchase_applymas.dmedate',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '8',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'10' => array(
		'name' => 'apreason',
		'showname' => '申请理由',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'apreason',
		'sortnum' => '8',
		'issearch' => '0',
		'searchField' => 'mis_purchase_applymas.apreason',
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
	'14' => array(
		'name' => 'ptmptid',
		'showname' => '流程选择',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => 'ProcessInfo',
		'sortname' => 'ptmptid',
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
					'3' => 'process_info',
				),
			),
		),
		'sortnum' => '9',
		'issearch' => '0',
		'searchField' => 'mis_purchase_applymas.ptmptid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '13',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'16' => array(
		'name' => 'status',
		'showname' => '状态',
		'shows' => '0',
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
		'sortnum' => '10',
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
	'18' => array(
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
		'sortnum' => '11',
		'issearch' => '0',
		'searchField' => 'mis_purchase_applymas.auditState',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '17',
		'status' => '1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'12' => array(
		'name' => 'grossamount',
		'showname' => '',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'grossamount',
		'sortnum' => '14',
		'issearch' => '0',
		'searchField' => 'mis_purchase_applymas.grossamount',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '-1',
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
		'rules' => '0',
		'message' => '0',
	),
	'19' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '12',
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
					'6' => '采购申请',
					'7' => '700',
					'8' => '500',
				),
			),
			'1' => array(
				'0' => array(
					'0' => '#status#',
				),
			),
		),
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
	'15' => array(
		'name' => 'remark',
		'showname' => '',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'remark',
		'sortnum' => '18',
		'issearch' => '0',
		'searchField' => 'mis_purchase_applymas.remark',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '14',
		'status' => '-1',
		'helpvalue' => '',
		'rules' => '0',
		'message' => '0',
	),
);

?>