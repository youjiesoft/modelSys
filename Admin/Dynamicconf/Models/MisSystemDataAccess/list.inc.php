<?php 
return array(
	'id' => array(
		'name' => 'id',
		'showname' => 'ID',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'id',
		'sortnum' => '1',
		'issearch' => '1',
		'searchField' => 'mis_system_data_access_mas.id',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'actiontitle' => array(
		'name' => 'actiontitle',
		'showname' => '模型名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'actiontitle',
		'sortnum' => '2',
		'issearch' => '1',
		'searchField' => 'mis_system_data_access_mas.actiontitle',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'tabletitle' => array(
		'name' => 'tabletitle',
		'showname' => '数据表名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'field',
		'sortnum' => '4',
		'issearch' => '1',
		'searchField' => 'mis_system_data_access_mas.tabletitle',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'fieldtitle' => array(
		'name' => 'fieldtitle',
		'showname' => '字段名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'fieldtitle',
		'sortnum' => '5',
		'issearch' => '1',
		'searchField' => 'mis_system_data_access_mas.fieldtitle',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),

	'accesscontenttype' => array(
			'name' => 'accesscontenttype',
			'showname' => '字段类型',
			'shows' => '1',
			'widths' => '',
			'sorts' => '0',
			'models' => '',
			'sortname' => 'type',
			'sortnum' => '5',
			'issearch' => '1',
			'searchField' => 'mis_system_data_access_mas.accesscontenttype',
			'table' => '',
			'field' => '',
			'conditions' => '',
			'type' => 'text',
			'isallsearch' => '1',
			'searchsortnum' => '3',
			'status' => '1',
			'rules' => '0',
			'message' => '0',
			'func' => array(
					'0' => array(
							'0' => 'excelTplselected',
					),
			),
			'funcdata' => array(
					'0' => array(
							'0' => array(
									'0' => '###',
									'1' => '1:直接授权,2:分组授权',
							),
					),
			),
	),
	'startstatus'=>array(
		'name' => 'action',
		'showname' => '状态',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'mis_system_data_access_mas.startstatus',
		'sortnum' => '6',
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
						'0' => 'getStatus',
				),
		),
		'funcdata' => array(
				'0' => array(
						'0' => array(
								'0' => '#startstatus#',
						),
				),
		),
		'helpvalue' => '',
	),
);

?>