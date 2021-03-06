<?php 
return array(
	'0' => array(
		'name' => 'id',
		'showname' => 'ID',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => '',
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
	),
	'1' => array(
		'name' => 'title',
		'showname' => '标题',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'title',
		'sortnum' => '2',
		'issearch' => '1',
		'isexport' => '1',
		'searchField' => 'mis_system_announcement.title',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '2',
	),
	'3' => array(
		'name' => 'type',
		'showname' => '公告类型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'type',
		'sortnum' => '4',
		'issearch' => '1',
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
					'3' => 'mis_system_announcement_set',
				),
			),
		),
		'searchField' => 'mis_system_announcement.type',
		'table' => 'mis_system_announcement_set',
		'field' => 'id',
		'conditions' => 'pid=0',
		'type' => 'group',
		'isallsearch' => '1',
		'searchsortnum' => '4',
	),
	'4' => array(
		'name' => 'ptype',
		'showname' => '公告子类型',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'ptype',
		'sortnum' => '5',
		'issearch' => '0',
		'isexport' => '0',
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
					'3' => 'mis_system_announcement_set',
				),
			),
		),
		'searchField' => 'mis_system_announcement.ptype',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '5',
	),
	'5' => array(
		'name' => 'content',
		'showname' => '公告内容',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'content',
		'sortnum' => '6',
		'issearch' => '0',
		'isexport' => '0',
		'searchField' => 'mis_system_announcement.content',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '6',
	),
	'8' => array(
		'name' => 'commit',
		'showname' => '是否发布',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'commit',
		'sortnum' => '9',
		'issearch' => '0',
		'isexport' => '0',
		'searchField' => 'mis_system_announcement.commit',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '9',
		'func' => array(
			'0' => array(
				'0' => 'getSelectByname',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => 'commit',
					'1' => '###',
					'2' => '',
				),
			),
		),
	),
	'9' => array(
		'name' => 'top',
		'showname' => '是否置顶',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'top',
		'sortnum' => '10',
		'issearch' => '0',
		'isexport' => '0',
		'searchField' => 'mis_system_announcement.top',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '10',
		'func' => array(
			'0' => array(
				'0' => 'getSelectByname',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => 'top',
					'1' => '###',
					'2' => '',
				),
			),
		),
	),
	'11' => array(
		'name' => 'starttime',
		'showname' => '生效日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'starttime',
		'sortnum' => '12',
		'issearch' => '1',
		'isexport' => '1',
		'searchField' => 'mis_system_announcement.starttime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '12',
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
	),
	'12' => array(
		'name' => 'createtime',
		'showname' => '创建时间',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createtime',
		'sortnum' => '13',
		'issearch' => '0',
		'searchField' => 'mis_system_announcement.createtime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '13',
		'status' => '1',
	),
	'13' => array(
		'name' => 'endtime',
		'showname' => '截止日期',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'endtime',
		'sortnum' => '14',
		'issearch' => '1',
		'isexport' => '1',
		'searchField' => 'mis_system_announcement.endtime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'time',
		'isallsearch' => '0',
		'searchsortnum' => '14',
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
	),
	'14' => array(
		'name' => 'createid',
		'showname' => '创建人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createid',
		'sortnum' => '15',
		'issearch' => '1',
		'searchField' => 'mis_system_announcement.createid',
		'table' => 'user',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'isallsearch' => '0',
		'searchsortnum' => ' 15',
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
	),
	'15' => array(
		'name' => 'updateid',
		'showname' => '更新人',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createid',
		'sortnum' => '16',
		'issearch' => '0',
		'searchField' => 'mis_system_announcement.createid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => ' 16',
		'status' => '1',
	),
	'16' => array(
		'name' => 'status',
		'showname' => '状态',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '17',
		'issearch' => '0',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
	),
	'17' => array(
		'name' => 'companyid',
		'showname' => '公司',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'companyid',
		'sortnum' => '18',
		'issearch' => '0',
		'searchField' => 'mis_system_announcement.companyid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '18',
		'status' => '1',
	),
	'18' => array(
		'name' => 'updatetime',
		'showname' => '更新时间',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'updatetime',
		'sortnum' => '19',
		'issearch' => '0',
		'searchField' => 'mis_system_announcement.updatetime',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '19',
		'status' => '1',
	),
	'19' => array(
		'name' => 'roles',
		'showname' => '按照角色发布',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'roles',
		'sortnum' => '20',
		'issearch' => '0',
		'searchField' => 'mis_system_announcement.roles',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '20',
		'status' => '1',
	),
	'20' => array(
		'name' => 'personsid',
		'showname' => '按照人员发布',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'personsid',
		'sortnum' => '21',
		'issearch' => '0',
		'searchField' => 'mis_system_announcement.personsid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '21',
		'status' => '1',
	),
	'fujian' => array(
			'name' => 'fujian',
			'showname' => '附件',
			'widths' => '',
			'sorts' => '0',
			'models' => '',
			'sortname' => 'fujian',
			'sortnum' => '18',
			'shows' => '0',
			'status' => '1',
			'rules' => '1',
			'message' => '1',
			'isexport' => '1',
			'fieldtype' => 'varchar',
			'fieldcategory' => 'upload',
			'searchField' => 'mis_auto_dzzvn.fujian',
			'conditions' => '',
			'type' => 'upload',
			'ischosice' => '1',
			'table' => 'mis_auto_dzzvn',
			'field' => 'fujian',
	),
	'30' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'status',
		'sortnum' => '30',
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
	),
);

?>