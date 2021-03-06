<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => 'ID',
		'shows' => '0',
		'widths' => '22',
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
		'rules' => '0',
		'message' => '0',
	),
	'2' => array(
		'name' => 'title',
		'showname' => '计划标题',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'title',
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'mis_work_plan.title',
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
	'3' => array(
		'name' => 'summary',
		'showname' => '计划摘要',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'summary',
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'mis_work_plan.summary',
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
	'4' => array(
		'name' => 'typeid',
		'showname' => '计划类型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'typeid',
		'sortnum' => '5',
		'issearch' => '1',
		'searchField' => 'mis_work_plan.typeid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'select|workplan',
		'isallsearch' => '1',
		'searchsortnum' => '5',
		'func' => array(
			'0' => array(
				'0' => 'getSelectByName',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => 'workplan',
					'1' => '###',
					'2' => '',
				),
			),
		),
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'5' => array(
		'name' => 'lookpeoplename',
		'showname' => '查阅人',
		'shows' => '1',
		'widths' => '180',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'lookpeoplename',
		'sortnum' => '6',
		'issearch' => '1',
		'searchField' => 'mis_work_plan.lookpeoplename',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '6',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'7' => array(
		'name' => 'content',
		'showname' => '计划内容',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'content',
		'sortnum' => '8',
		'issearch' => '0',
		'searchField' => 'mis_work_plan.content',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '8',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'8' => array(
		'name' => 'createid',
		'showname' => '创建人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createid',
		'sortnum' => '9',
		'issearch' => '1',
		'isearch' => '0',
		'searchField' => 'mis_work_plan.createid',
		'type' => 'db',
		'isallsearch' => '1',
		'searchsortnum' => '9',
		'status' => '1',
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
		'table' => 'user',
		'field' => 'id',
		'conditions' => '',
		'rules' => '0',
		'message' => '0',
	),
	'9' => array(
		'name' => 'createtime',
		'showname' => '创建时间',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createtime',
		'sortnum' => '10',
		'issearch' => '1',
		'isearch' => '0',
		'searchField' => 'mis_work_plan.createtime',
		'type' => 'time',
		'isallsearch' => '1',
		'searchsortnum' => '10',
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
		'status' => '1',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'rules' => '0',
		'message' => '0',
	),
	'10' => array(
		'name' => 'readpeople',
		'showname' => '阅读状态',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'readpeople',
		'sortnum' => '11',
		'issearch' => '0',
		'searchField' => 'mis_work_plan.readpeople',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '11',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'11' => array(
		'name' => 'commentpeople',
		'showname' => '评论状态',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'commentpeople',
		'sortnum' => '12',
		'issearch' => '0',
		'searchField' => 'mis_work_plan.commentpeople',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '12',
		'status' => '1',
		'rules' => '0',
		'message' => '0',
	),
	'12' => array(
		'name' => 'action',
		'showname' => '状态',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '13',
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
			'1' => array(
				'0' => 'getStatus',
			),
		),
		'funcdata' => array(
			'1' => array(
				'0' => array(
					'0' => '#status#',
				),
			),
		),
		'rules' => '0',
		'message' => '0',
	),
);

?>