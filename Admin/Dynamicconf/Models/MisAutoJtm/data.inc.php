<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-data)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-02-11 09:53:07
 * @version V1.0
*/
return array(
	'id' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'id',
		'type' => 'int(11)',
		'nullable' => 'NO',
		'default' => NULL,
		'primary' => 'PRI',
		'autoinc' => 'auto_increment',
		'comment' => 'ID',
	),
	'duiyingmoban' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'duiyingmoban',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '对应模板',
	),
	'bindid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'bindid',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '绑定id',
	),
	'orderno' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'orderno',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '编号',
	),
	'status' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'status',
		'type' => 'tinyint(1)',
		'nullable' => 'YES',
		'default' => '1',
		'primary' => '',
		'autoinc' => '',
		'comment' => '状态',
	),
	'companyid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'companyid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '公司ID',
	),
	'createid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'createid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '创建人ID',
	),
	'createtime' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'createtime',
		'type' => 'int(11)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '创建时间',
	),
	'updateid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'updateid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '修改人ID',
	),
	'updatetime' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'updatetime',
		'type' => 'int(11)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '修改时间',
	),
	'operateid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'operateid',
		'type' => 'int(1)',
		'nullable' => 'NO',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '是否确认',
	),
	'departmentid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'departmentid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '部门ID',
	),
	'projectid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'projectid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '项目ID',
	),
	'projectworkid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'projectworkid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '任务ID',
	),
	'sysdutyid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'sysdutyid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '职级ID',
	),
	'ptmptid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'ptmptid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '固定流程ID',
	),
	'flowid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'flowid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '自定义流程ID',
	),
	'ostatus' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'ostatus',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前审核节点',
	),
	'auditState' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'auditState',
		'type' => 'tinyint(1)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前审核状态',
	),
	'curAuditUser' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'curAuditUser',
		'type' => 'varchar(300)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前可审核人清单',
	),
	'curNodeUser' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'curNodeUser',
		'type' => 'varchar(300)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前待审核人清单',
	),
	'alreadyAuditUser' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'alreadyAuditUser',
		'type' => 'varchar(500)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前已审核人',
	),
	'alreadyauditnode' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'alreadyauditnode',
		'type' => 'varchar(200)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前并行时已审核节点',
	),
	'auditUser' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'auditUser',
		'type' => 'varchar(500)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '所有审核人清单',
	),
	'allnode' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'allnode',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '所有流程节点',
	),
	'informpersonid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'informpersonid',
		'type' => 'varchar(500)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '节点知道会人',
	),
	'parentid' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'parentid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '父类ID',
	),
	'name' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'name',
		'type' => 'varchar(50)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '名称',
	),
	'duiyinmoban' => array(
		'tablename' => 'mis_auto_fwvvg',
		'name' => 'duiyinmoban',
		'type' => 'varchar(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '对应模板',
	),
);

?>