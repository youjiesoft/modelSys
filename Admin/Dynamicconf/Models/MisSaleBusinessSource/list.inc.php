<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-list.inc 配置文件)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-08-15 13:01:16
 * @version V1.0
*/
$original = array(
	'id' => array(
		'name' => 'id',
		'showname' => 'ID',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'status' => '1',
		'sortname' => 'id',
		'sortnum' => '0',
		'searchField' => 'mis_sale_business_source.id',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'message' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '0',
	),
	'orderno' => array(
		'name' => 'orderno',
		'showname' => '编号',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '0',
		'shows' => '1',
		'status' => '1',
		'rules' => '1',
		'message' => '1',
		'isexport' => '1',
		'methods' => '',
		'relation' => '',
		'fieldtype' => '',
		'fieldcategory' => 'text',
		'searchField' => 'mis_sale_business_source.orderno',
		'conditions' => '',
		'type' => 'text',
		'validate' => '',
		'unique' => '1',
		'required' => '0',
		'transform' => '0',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '0',
	),
	'name' => array(
		'name' => 'name',
		'showname' => '名称',
		'shows' => '1',
		'widths' => '',
		'sorts' => '5',
		'models' => '',
		'sortname' => 'name',
		'sortnum' => '5',
		'searchField' => 'mis_sale_business_source.name',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '0',
		'transform' => '0',
		'unique' => '0',
		'validate' => '0',
		'required' => '0',
	),
	'youxiaotianshu' => array(
		'name' => 'youxiaotianshu',
		'showname' => '有效天数',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'youxiaotianshu',
		'sortnum' => '2',
		'shows' => '1',
		'status' => '1',
		'rules' => '1',
		'message' => '1',
		'isexport' => '1',
		'methods' => '',
		'relation' => '',
		'fieldtype' => 'int',
		'fieldcategory' => 'text',
		'searchField' => 'mis_sale_business_source.youxiaotianshu',
		'conditions' => '',
		'type' => 'text',
		'validate' => '',
		'unique' => '0',
		'required' => '0',
		'transform' => '1',
		'func' => array(
			'0' => array(
				'0' => 'unitExchange',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'days',
					'2' => 'days',
					'3' => '3',
				),
			),
		),
		'unfunc' => array(
			'0' => array(
				'0' => 'unitExchange',
			),
		),
		'unfuncdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'days',
					'2' => 'days',
					'3' => '1',
				),
			),
		),
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '2',
	),
	'remark' => array(
		'name' => 'remark',
		'showname' => '备注',
		'widths' => '350',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'remark',
		'sortnum' => '3',
		'shows' => '1',
		'status' => '1',
		'rules' => '1',
		'message' => '1',
		'isexport' => '1',
		'methods' => '',
		'relation' => '',
		'fieldtype' => 'text',
		'fieldcategory' => 'textarea',
		'searchField' => 'mis_sale_business_source.remark',
		'conditions' => '',
		'type' => 'textarea',
		'validate' => '',
		'unique' => '0',
		'required' => '0',
		'transform' => '0',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '3',
	),
	'action' => array(
		'name' => 'action',
		'showname' => '操作',
		'shows' => '0',
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
		'sortnum' => '6',
		'transform' => '0',
		'unique' => '0',
		'validate' => '0',
		'required' => '0',
	),
	'operateid' => array(
		'name' => 'operateid',
		'showname' => '是否确认',
		'rules' => '1',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'func' => array(
			'0' => array(
				'0' => 'getSelectByName',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => 'operateidVal',
					'1' => '###',
				),
			),
		),
		'sortname' => 'operateid',
		'sortnum' => '7',
		'searchField' => 'mis_sale_business_source.operateid',
		'transform' => '0',
		'unique' => '0',
		'validate' => '0',
		'required' => '0',
	),
	'companyid' => array(
		'name' => 'companyid',
		'showname' => '公司',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => 'MisSystemCompany',
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
					'3' => 'MisSystemCompany',
				),
			),
		),
		'sortname' => 'companyid',
		'sortnum' => '8',
		'issearch' => '1',
		'table' => 'mis_system_company',
		'searchField' => 'mis_sale_business_source.companyid',
		'transform' => '1',
		'unique' => '0',
		'validate' => '0',
		'required' => '0',
		'unfunc' => array(
			'0' => array(
				'0' => 'ungetFieldBy',
			),
		),
		'unfuncdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'id',
					'2' => 'name',
					'3' => 'MisSystemCompany',
				),
			),
		),
	),
	'projectid' => array(
		'name' => 'projectid',
		'showname' => '项目ID',
		'rules' => '0',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'projectid',
		'sortnum' => '9',
		'searchField' => 'mis_sale_business_source.projectid',
		'transform' => '0',
		'unique' => '0',
		'validate' => '0',
		'required' => '0',
	),
	'createid' => array(
		'name' => 'createid',
		'rules' => '1',
		'showname' => '创建人',
		'shows' => '0',
		'widths' => '',
		'sorts' => '0',
		'models' => 'User',
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
		'sortname' => 'createid',
		'issearch' => '1',
		'table' => 'user',
		'sortnum' => '10',
		'searchField' => 'mis_sale_business_source.createid',
		'transform' => '1',
		'unique' => '0',
		'validate' => '0',
		'required' => '0',
		'unfunc' => array(
			'0' => array(
				'0' => 'ungetFieldBy',
			),
		),
		'unfuncdata' => array(
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
	'createtime' => array(
		'name' => 'createtime',
		'showname' => '创建时间',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'createtime',
		'sortnum' => '11',
		'fieldtype' => 'date',
		'fieldcategory' => 'date',
		'searchField' => 'mis_sale_business_source.createtime',
		'conditions' => '',
		'type' => 'time',
		'issearch' => '0',
		'isallsearch' => '0',
		'searchsortnum' => '1',
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
		'transform' => '1',
		'unique' => '0',
		'validate' => '0',
		'required' => '0',
		'unfunc' => array(
			'0' => array(
				'0' => 'untranstime',
			),
		),
		'unfuncdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
				),
			),
		),
	),
);

$extedsList = require 'listExtend.inc.php';
return array_merge($original , $extedsList);
?>