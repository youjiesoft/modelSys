<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-data)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-08-15 13:01:16
 * @version V1.0
*/
return array(
	'id' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'id',
		'type' => 'int(11)',
		'nullable' => 'NO',
		'default' => NULL,
		'primary' => 'PRI',
		'autoinc' => 'auto_increment',
		'comment' => 'ID',
	),
	'name' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'name',
		'type' => 'varchar(50)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '来源名称',
	),
	'orderno' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'orderno',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '编号',
	),
	'parentid' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'parentid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => 'shangji',
	),
	'remark' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'remark',
		'type' => 'text',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '备注',
	),
	'status' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'status',
		'type' => 'tinyint(1)',
		'nullable' => 'YES',
		'default' => '1',
		'primary' => '',
		'autoinc' => '',
		'comment' => '状态',
	),
	'companyid' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'companyid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '公司ID',
	),
	'departmentid' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'departmentid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '部门ID',
	),
	'createid' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'createid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '创建人ID',
	),
	'operateid' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'operateid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '操作人ID',
	),
	'createtime' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'createtime',
		'type' => 'int(11)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '创建时间',
	),
	'updatetime' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'updatetime',
		'type' => 'int(11)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '修改时间',
	),
	'updateid' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'updateid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '修改人ID',
	),
	'sysdutyid' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'sysdutyid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => 'èŒçº§ID',
	),
	'relationmodelname' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'relationmodelname',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '关系型表单关联model',
	),
	'youxiaotianshu' => array(
		'tablename' => 'mis_sale_business_source',
		'name' => 'youxiaotianshu',
		'type' => 'int(11)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '有效天数',
	),
);

?>