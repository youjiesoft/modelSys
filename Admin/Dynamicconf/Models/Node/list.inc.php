<?php 
return array(
	'id' => array(
		'name' => 'id',
		'showname' => '编号',
		'shows' => '1',
		'widths' => '',
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
	),
	'icon' => array(
		'name' => 'icon',
		'showname' => '图标',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'icon',
		'sortnum' => '2',
		'func' => array(
			'0' => array(
				'0' => 'showhtml',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '<div class="tip"><img class="tip" width="32" height="32" src="__PUBLIC__/Images/xyicon/#icon#"/></div>',
				),
			),
		),
		'issearch' => '1',
		'searchField' => 'node.icon',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'name' => array(
		'name' => 'name',
		'showname' => '模块名',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'name',
		'func' => array(
			'0' => array(
				'0' => 'getnextUrl',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => '#id#',
					'2' => 'pid',
					'3' => 'index',
					'4' => '#title#',
				),
			),
		),
		'sortnum' => '3',
		'issearch' => '1',
		'searchField' => 'node.name',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '1',
		'searchsortnum' => '0',
	),
	'title' => array(
		'name' => 'title',
		'showname' => '名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'title',
		'sortnum' => '4',
		'issearch' => '1',
		'searchField' => 'node.title',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'type' => array(
		'name' => 'type',
		'showname' => '类型',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'type',
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
					'3' => 'nodeType',
				),
			),
		),
		'sortnum' => '5',
		'issearch' => '1',
		'searchField' => 'node.type',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'pid' => array(
		'name' => 'pid',
		'showname' => '树形父节点',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'pid',
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
					'2' => 'title',
					'3' => 'Node',
				),
			),
		),
		'sortnum' => '6',
		'issearch' => '1',
		'searchField' => 'node.pid',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'group_id' => array(
		'name' => 'group_id',
		'showname' => '组名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '1',
		'models' => '',
		'sortname' => 'group_id',
		'sortnum' => '7',
		'issearch' => '1',
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
		'searchField' => 'node.group_id',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'showmenu' => array(
		'name' => 'showmenu',
		'showname' => '是否显示',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'showmenu',
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
		'sortnum' => '8',
		'issearch' => '1',
		'searchField' => 'node.showmenu',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'toolshow' => array(
		'name' => 'toolshow',
		'showname' => '工具栏前移',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'toolshow',
		'sortnum' => '9',
		'func' => array(
			'0' => array(
				'0' => 'isDefault',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => '1',
				),
			),
		),
		'issearch' => '1',
		'searchField' => 'node.toolshow',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'sort' => array(
		'name' => 'sort',
		'showname' => '排序',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'sort',
		'func' => array(
			'0' => array(
				'0' => 'getNodeSortIcon',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '#type#',
					'1' => '#id#',
				),
			),
		),
		'sortnum' => '10',
		'issearch' => '1',
		'searchField' => 'node.sort',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'remark' => array(
		'name' => 'remark',
		'showname' => '描述',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'remark',
		'sortnum' => '11',
		'issearch' => '1',
		'searchField' => 'node.remark',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'category' => array(
		'name' => 'category',
		'showname' => '权限类',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'category',
		'sortnum' => '11',
		'issearch' => '1',
		'searchField' => 'node.category',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => 'text',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
	'action' => array(
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
				'0' => 'getMoveNode',
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
					'5' => 'dialog',
					'6' => '节点',
					'7' => '',
					'8' => '400',
				),
			),
			'1' => array(
				'0' => array(
					'0' => '#id#',
					'1' => '#status#',
				),
			),
			'2' => array(
				'0' => array(
					'0' => '#status#',
				),
			),
		),
		'sortnum' => '12',
		'issearch' => '0',
		'searchField' => '',
		'table' => '',
		'field' => '',
		'conditions' => '',
		'type' => '',
		'isallsearch' => '0',
		'searchsortnum' => '0',
	),
);

?>