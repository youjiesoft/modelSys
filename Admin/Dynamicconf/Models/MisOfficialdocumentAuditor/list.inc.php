<?php 
return array(
	'0' => array(
		'name' => '序号',
		'showname' => 'id',
		'shows' => '0',
		'widths' => '30',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'id',
		'sortnum' => '1',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.id',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'isexport' => '0',
	),
	'1' => array(
		'name' => 'orderno',
		'showname' => '编号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '2',
		'issearch' => '1',
		'searchField' => 'mis_officialdocument_type.orderno',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '1',
		'status' => '1',
		'isexport' => '1',
	),
	'3' => array(
		'name' => 'secrecylevel',
		'showname' => '密级',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'secrecylevel',
		'sortnum' => '3',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.secrecylevel',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '2',
		'status' => '-1',
		'isexport' => '0',
	),
	'2' => array(
		'name' => 'referencenum',
		'showname' => '文号',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'referencenum',
		'sortnum' => '3',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.referencenum',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '2',
		'status' => '-1',
		'isexport' => '0',
	),
	'5' => array(
		'name' => 'draftunit',
		'showname' => '拟稿单位',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'draftunit',
		'sortnum' => '3',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.draftunit',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '-1',
		'isexport' => '0',
	),
	'4' => array(
		'name' => 'priorities',
		'showname' => '缓急',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'priorities',
		'sortnum' => '3',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.priorities',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '5',
		'status' => '-1',
		'isexport' => '0',
	),
	'6' => array(
		'name' => 'draftemployeeId',
		'showname' => '拟稿人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
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
					'3' => 'MisHrBasicEmployee',
				),
			),
		),
		'sortname' => 'draftemployeeId',
		'sortnum' => '5',
		'issearch' => '1',
		'searchField' => 'mis_officialdocument_type.draftemployeeId',
		'table' => 'mis_hr_personnel_person_info',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'isexport' => '1',
	),
	'7' => array(
		'name' => 'nuclearemployeeId',
		'showname' => '核稿人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
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
					'3' => 'MisHrBasicEmployee',
				),
			),
		),
		'sortname' => 'draftemployeeId',
		'sortnum' => '5',
		'issearch' => '1',
		'searchField' => 'mis_officialdocument_type.draftemployeeId',
		'table' => 'mis_hr_personnel_person_info',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'isexport' => '1',
	),
	'8' => array(
		'name' => 'copynum',
		'showname' => '份数',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'copynum',
		'sortnum' => '9',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.copynum',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '-1',
		'isexport' => '0',
	),
	'9' => array(
		'name' => 'title',
		'showname' => '标题',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'title',
		'sortnum' => '10',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.title',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '-1',
		'isexport' => '0',
	),
	'10' => array(
		'name' => 'reportsend',
		'showname' => '报送',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'reportsend',
		'sortnum' => '11',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.reportsend',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '-1',
		'isexport' => '0',
	),
	'11' => array(
		'name' => 'copysend',
		'showname' => '抄送',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'copysend',
		'sortnum' => '12',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.copysend',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '-1',
		'isexport' => '0',
	),
	'12' => array(
		'name' => 'undertakeempId',
		'showname' => '承办人',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
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
					'3' => 'MisHrBasicEmployee',
				),
			),
		),
		'sortname' => 'undertakeempId',
		'sortnum' => '13',
		'issearch' => '1',
		'searchField' => 'mis_officialdocument_type.undertakeempId',
		'table' => 'mis_hr_personnel_person_info',
		'field' => 'id',
		'conditions' => '',
		'type' => 'db',
		'isallsearch' => '1',
		'searchsortnum' => '3',
		'status' => '1',
		'isexport' => '1',
	),
	'13' => array(
		'name' => 'phone',
		'showname' => '电话',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'phone',
		'sortnum' => '14',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.phone',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '-1',
		'isexport' => '0',
	),
	'14' => array(
		'name' => 'eamil',
		'showname' => '邮箱',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'eamil',
		'sortnum' => '15',
		'issearch' => '0',
		'searchField' => 'mis_officialdocument_type.eamil',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '6',
		'status' => '-1',
		'isexport' => '0',
	),
	'15' => array(
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
		'sortnum' => '16',
		'searchField' => 'mis_officialdocument_type.auditState',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '0',
		'status' => '1',
		'isexport' => '0',
	),
	'16' => array(
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
				'0' => 'getOperateStatus',
			),
			'1' => array(
				'0' => 'getDestroyOption',
			),
			'2' => array(
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
					'5' => 'navTab',
					'6' => '发文拟稿',
				),
			),
			'1' => array(
				'0' => array(
					'0' => 'MisBusinessContractAlarm',
					'1' => '#id#',
					'2' => '#auditState#',
					'3' => '#status#',
					'4' => '__MODULE__',
				),
			),
			'2' => array(
				'0' => array(
					'0' => '#status#',
				),
			),
		),
		'isexport' => '0',
	),
);

?>