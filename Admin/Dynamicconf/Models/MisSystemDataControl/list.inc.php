<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => 'ID',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'id',
		'sortnum' => '1',
		'issearch' => '1',
		'searchField' => 'mis_system_data_control_mas.id',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '1',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'sortsorder' => '1',
		'sortstype' => 'asc',
	),
	'1' => array(
		'name' => 'name',
		'showname' => '名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'name',
		'sortnum' => '2',
		'issearch' => '1',
		'searchField' => 'mis_system_data_control_mas.name',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'sortsorder' => '0',
		'sortstype' => 'asc',
	),
	'2' => array(
		'name' => 'modelname',
		'showname' => '来源模型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'modelname',
		'sortnum' => '3',
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
		'issearch' => '1',
		'searchField' => 'mis_system_data_control_mas.modelname',
		'table' => 'mis_system_data_control_mas',
		'field' => 'modelname',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
		'sortsorder' => '0',
		'sortstype' => 'asc',
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
		'sortnum' => '4',
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