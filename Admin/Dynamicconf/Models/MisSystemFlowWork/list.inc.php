<?php 
return array(
	'27' => array(
		'name' => 'orderno',
		'showname' => '任务编号',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '1',
		'searchField' => 'mis_system_flow_form.orderno',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '0',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'0' => array(
		'name' => 'name',
		'showname' => '任务名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'name',
		'sortnum' => '2',
		'searchField' => 'mis_system_flow_form.name',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '0',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'1' => array(
		'name' => 'supcategory',
		'showname' => '业务类型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'supcategory',
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'mis_system_flow_form.supcategory',
		'table' => 'mis_system_flow_type',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db|name',
		'isallsearch' => '1',
		'searchsortnum' => '1',
		'status' => '1',
		'helpvalue' => '',
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
					'3' => 'mis_system_flow_type',
				),
			),
		),
		'rules' => '0',
		'message' => '0',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'2' => array(
		'name' => 'category',
		'showname' => '业务阶段',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'category',
		'sortnum' => '4',
		'searchField' => 'mis_system_flow_form.category',
		'table' => 'mis_system_flow_type',
		'conditions' => '',
		'type' => 'db|name',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '2',
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
					'3' => 'mis_system_flow_type',
				),
			),
		),
		'field' => 'id',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'4' => array(
		'name' => 'parentid',
		'showname' => '业务节点',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'parentid',
		'sortnum' => '5',
		'searchField' => 'mis_system_flow_form.parentid',
		'conditions' => '',
		'type' => 'db|name',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '4',
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
					'3' => 'mis_system_flow_form',
				),
			),
		),
		'table' => 'mis_system_flow_form',
		'field' => 'id',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'3' => array(
		'name' => 'formobj',
		'showname' => '对应模板',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'formobj',
		'sortnum' => '6',
		'searchField' => 'mis_system_flow_form.formobj',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '1',
		'sortstype' => 'asc',
	),
	'5' => array(
		'name' => 'summary',
		'showname' => '是否为子任务',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'summary',
		'sortnum' => '7',
		'searchField' => 'mis_system_flow_form.summary',
		'conditions' => '',
		'type' => 'radio',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '5',
		'func' => array(
			'0' => array(
				'0' => 'getSelectlistValue',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'debit',
				),
			),
		),
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'6' => array(
		'name' => 'days',
		'showname' => '工作日',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'days',
		'sortnum' => '8',
		'searchField' => 'mis_system_flow_form.days',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'7' => array(
		'name' => 'begintime',
		'showname' => '计划开始时间',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'begintime',
		'sortnum' => '9',
		'searchField' => 'mis_system_flow_form.begintime',
		'conditions' => '',
		'type' => 'time',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '7',
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
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'8' => array(
		'name' => 'endtime',
		'showname' => '计划结束时间',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'endtime',
		'sortnum' => '10',
		'searchField' => 'mis_system_flow_form.endtime',
		'conditions' => '',
		'type' => 'time',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '8',
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
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'9' => array(
		'name' => 'outlinenumber',
		'showname' => '大纲数字',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'outlinenumber',
		'sortnum' => '11',
		'searchField' => 'mis_system_flow_form.outlinenumber',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '9',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'10' => array(
		'name' => 'outlinelevel',
		'showname' => '大纲级别',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'outlinelevel',
		'sortnum' => '12',
		'searchField' => 'mis_system_flow_form.outlinelevel',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '10',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'11' => array(
		'name' => 'readyonly',
		'showname' => '只读',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'readyonly',
		'sortnum' => '13',
		'searchField' => 'mis_system_flow_form.readyonly',
		'conditions' => '',
		'type' => 'radio',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '11',
		'func' => array(
			'0' => array(
				'0' => 'getSelectlistValue',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'debit',
				),
			),
		),
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'12' => array(
		'name' => 'percentcomplete',
		'showname' => '完成百分比',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'percentcomplete',
		'sortnum' => '14',
		'searchField' => 'mis_system_flow_form.percentcomplete',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '12',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'13' => array(
		'name' => 'notes',
		'showname' => '任务备注',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'notes',
		'sortnum' => '15',
		'searchField' => 'mis_system_flow_form.notes',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '13',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'14' => array(
		'name' => 'constrainttype',
		'showname' => '任务的限制类型',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'constrainttype',
		'sortnum' => '16',
		'searchField' => 'mis_system_flow_form.constrainttype',
		'conditions' => '',
		'type' => 'select',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '14',
		'func' => array(
			'0' => array(
				'0' => 'getSelectlistValue',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'debit',
				),
			),
		),
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'15' => array(
		'name' => 'hyperlink',
		'showname' => '超级链接的文本',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'hyperlink',
		'sortnum' => '17',
		'searchField' => 'mis_system_flow_form.hyperlink',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '15',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'16' => array(
		'name' => 'hyperlinkurl',
		'showname' => '超级链接的URL',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'hyperlinkurl',
		'sortnum' => '18',
		'searchField' => 'mis_system_flow_form.hyperlinkurl',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '16',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'17' => array(
		'name' => 'classname',
		'showname' => '任务的显示样式',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'classname',
		'sortnum' => '19',
		'searchField' => 'mis_system_flow_form.classname',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '17',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'18' => array(
		'name' => 'critical',
		'showname' => '关键任务',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'critical',
		'sortnum' => '20',
		'searchField' => 'mis_system_flow_form.critical',
		'conditions' => '',
		'type' => 'radio',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '18',
		'func' => array(
			'0' => array(
				'0' => 'getSelectlistValue',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'debit',
				),
			),
		),
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'table' => '',
		'field' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'19' => array(
		'name' => 'custtypeid',
		'showname' => '客户主体',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'custtypeid',
		'sortnum' => '21',
		'searchField' => 'mis_system_flow_form.custtypeid',
		'conditions' => '',
		'type' => 'db|orderno',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '19',
		'table' => 'mis_sale_client_type',
		'field' => 'id',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
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
					'3' => 'mis_sale_client_type',
				),
			),
		),
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'20' => array(
		'name' => 'hyid',
		'showname' => '行业',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'hyid',
		'sortnum' => '22',
		'searchField' => 'mis_system_flow_form.hyid',
		'conditions' => '',
		'type' => 'db|orderno',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '20',
		'table' => 'mis_sale_profession',
		'field' => 'id',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
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
					'3' => 'mis_sale_profession',
				),
			),
		),
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'21' => array(
		'name' => 'cylid',
		'showname' => '产业链',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'cylid',
		'sortnum' => '23',
		'searchField' => 'mis_system_flow_form.cylid',
		'conditions' => '',
		'type' => 'db|orderno',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '21',
		'table' => 'mis_sale_industry',
		'field' => 'id',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
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
					'3' => 'mis_sale_industry',
				),
			),
		),
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'22' => array(
		'name' => 'formtype',
		'showname' => '清单类型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'formtype',
		'sortnum' => '24',
		'searchField' => 'mis_system_flow_form.formtype',
		'table' => 'mis_system_flow_inventory_type',
		'conditions' => '',
		'type' => 'group',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '22',
		'status' => '1',
		'helpvalue' => '',
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
					'3' => 'mis_system_flow_inventory_type',
				),
			),
		),
		'rules' => '0',
		'message' => '0',
		'field' => '',
		'sortsorder' => '2',
		'sortstype' => 'asc',
	),
	'23' => array(
		'name' => 'yzid',
		'showname' => '印章编码',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'yzid',
		'sortnum' => '25',
		'searchField' => 'mis_system_flow_form.yzid',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '23',
		'func' => array(
			'0' => array(
				'0' => 'getFieldBy',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'a',
					'2' => '',
					'3' => 'a',
				),
			),
		),
		'table' => '',
		'field' => '',
		'helpvalue' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'26' => array(
		'name' => 'sort',
		'showname' => '显示顺序',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'sort',
		'sortnum' => '26',
		'searchField' => 'mis_system_flow_form.sort',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '26',
		'table' => '',
		'field' => '',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'isexport' => '1',
		'helpvalue' => '',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'25' => array(
		'name' => 'readtaskrole',
		'showname' => '查看角色',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'readtaskrole',
		'sortnum' => '27',
		'issearch' => '0',
		'searchField' => 'mis_system_flow_form.readtaskrole',
		'table' => 'rolegroup',
		'field' => 'id',
		'conditions' => '',
		'type' => 'group',
		'isallsearch' => '0',
		'searchsortnum' => '26',
		'status' => '1',
		'helpvalue' => '',
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
					'3' => 'rolegroup',
				),
			),
		),
		'rules' => '0',
		'message' => '0',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'24' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'func' => array(
			'0' => array(
				'0' => 'showStatus',
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
		'sortnum' => '28',
		'helpvalue' => '',
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
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
);

?>