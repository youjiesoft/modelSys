<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => '编号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'id',
		'sortnum' => '1',
		'issearch' => '0',
		'isexport' => '1',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'helpvalue' => '',
	),
	'1' => array(
		'name' => 'name',
		'showname' => '面板名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'name',
		'sortnum' => '2',
		'issearch' => '1',
		'isexport' => '1',
		'searchField' => 'mis_system_panel.name',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '2',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'helpvalue' => '',
	),
	'2' => array(
		'name' => 'methodname',
		'showname' => '方法名',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'methodname',
		'sortnum' => '3',
		'issearch' => '0',
		'isexport' => '1',
		'searchField' => 'mis_system_panel.methodname',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'helpvalue' => '',
	),
	'10' => array(
		'name' => 'group_id',
		'showname' => '所属组',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'methodname',
		'sortnum' => '4',
		'issearch' => '1',
		'isexport' => '1',
		'searchField' => 'mis_system_panel.group_id',
		'table' => 'group',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'isallsearch' => '0',
		'searchsortnum' => '11',
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
					'3' => 'group',
				),
			),
		),
		'helpvalue' => '',
	),
	'11' => array(
		'name' => 'modelname',
		'showname' => '节点名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'modelname',
		'sortnum' => '5',
		'issearch' => '1',
		'isexport' => '1',
		'searchField' => 'mis_system_panel.modelname',
		'table' => 'node',
		'field' => 'name',
		'conditions' => '',
		'type' => 'db|title',
		'isallsearch' => '0',
		'searchsortnum' => '12',
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
					'1' => 'name',
					'2' => 'title',
					'3' => 'node',
				),
			),
		),
		'helpvalue' => '',
	),
	'3' => array(
		'name' => 'color',
		'showname' => '颜色',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'color',
		'sortnum' => '6',
		'issearch' => '0',
		'isexport' => '1',
		'searchField' => 'mis_system_panel.color',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'helpvalue' => '',
	),
	'4' => array(
		'name' => 'isbasepanel',
		'showname' => '基础面板',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'isbasepanel',
		'func' => array(
			'0' => array(
				'0' => 'isDefault',
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
		'issearch' => '0',
		'isexport' => '1',
		'searchField' => 'mis_system_panel.isbasepanel',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'helpvalue' => '',
	),
	'6' => array(
		'name' => 'createid',
		'showname' => '操作员',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createid',
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
		'sortnum' => '8',
		'status' => '1',
		'isexport' => '0',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_system_panel.createid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'helpvalue' => '',
	),
	'7' => array(
		'name' => 'sort',
		'showname' => '排序',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'sort',
		'sortnum' => '9',
		'issearch' => '0',
		'isexport' => '1',
		'searchField' => 'mis_system_panel.sort',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'helpvalue' => '',
	),
	'8' => array(
		'name' => 'createtime',
		'showname' => '操作时间',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createtime',
		'sortnum' => '10',
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
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'status' => '1',
		'isexport' => '0',
		'rules' => '0',
		'message' => '0',
		'searchField' => 'mis_system_panel.createtime',
		'searchsortnum' => '0',
		'helpvalue' => '',
	),
	'9' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
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
					'6' => '修改',
					'7' => '450',
					'8' => '320',
				),
			),
			'1' => array(
				'0' => array(
					'0' => '#status#',
				),
			),
		),
		'sortnum' => '11',
		'issearch' => '0',
		'status' => '1',
		'isexport' => '0',
		'rules' => '0',
		'message' => '0',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'helpvalue' => '',
	),
);

?>