<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-data)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2017-12-03 15:48:48
 * @version V1.0
*/
return array(
	'id' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'id',
		'type' => 'int(11)',
		'nullable' => 'NO',
		'default' => NULL,
		'primary' => 'PRI',
		'autoinc' => 'auto_increment',
		'comment' => 'ID',
	),
	'biaojueren' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'biaojueren',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '表决人',
	),
	'pingshenyijian' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'pingshenyijian',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '评审意见',
	),
	'jianyijine' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'jianyijine',
		'type' => 'decimal(18,6)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '建议借(贷)款金额',
	),
	'jianyiqixian' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'jianyiqixian',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '建议借(贷)款期限',
	),
	'jianyi' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'jianyi',
		'type' => 'text',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '评审表决理由及建议',
	),
	'xiangmubianma' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'xiangmubianma',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '项目编码',
	),
	'kehumingchen' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'kehumingchen',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '客户名称',
	),
	'xiangmumingchen' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'xiangmumingchen',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '项目名称',
	),
	'zijinyongtu' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'zijinyongtu',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '资金用途',
	),
	'yewuleixing' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'yewuleixing',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '业务类型',
	),
	'shenqingjine' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'shenqingjine',
		'type' => 'decimal(18,6)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '客户申请金额',
	),
	'shenqingqixian' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'shenqingqixian',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '客户申请期限',
	),
	'bindid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'bindid',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '绑定id',
	),
	'orderno' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'orderno',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '编号',
	),
	'status' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'status',
		'type' => 'tinyint(1)',
		'nullable' => 'YES',
		'default' => '1',
		'primary' => '',
		'autoinc' => '',
		'comment' => '状态',
	),
	'companyid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'companyid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '公司ID',
	),
	'createid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'createid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '创建人ID',
	),
	'createtime' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'createtime',
		'type' => 'int(11)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '创建时间',
	),
	'updateid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'updateid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '修改人ID',
	),
	'updatetime' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'updatetime',
		'type' => 'int(11)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '修改时间',
	),
	'operateid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'operateid',
		'type' => 'int(1)',
		'nullable' => 'NO',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '是否确认',
	),
	'departmentid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'departmentid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '部门ID',
	),
	'projectid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'projectid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '项目ID',
	),
	'projectworkid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'projectworkid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '任务ID',
	),
	'sysdutyid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'sysdutyid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '职级ID',
	),
	'relationmodelname' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'relationmodelname',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '关系型表单关联model',
	),
	'ptmptid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'ptmptid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '固定流程ID',
	),
	'flowid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'flowid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '自定义流程ID',
	),
	'ostatus' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'ostatus',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前审核节点',
	),
	'auditState' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'auditState',
		'type' => 'tinyint(1)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前审核状态',
	),
	'curAuditUser' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'curAuditUser',
		'type' => 'varchar(300)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前可审核人清单',
	),
	'curNodeUser' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'curNodeUser',
		'type' => 'varchar(300)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前待审核人清单',
	),
	'alreadyAuditUser' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'alreadyAuditUser',
		'type' => 'varchar(500)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前已审核人',
	),
	'alreadyauditnode' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'alreadyauditnode',
		'type' => 'varchar(200)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前并行时已审核节点',
	),
	'auditUser' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'auditUser',
		'type' => 'varchar(500)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '所有审核人清单',
	),
	'allnode' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'allnode',
		'type' => 'varchar(100)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '所有流程节点',
	),
	'informpersonid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'informpersonid',
		'type' => 'varchar(500)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '节点知道会人',
	),
	'parentid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'parentid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '父类ID',
	),
	'name' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'name',
		'type' => 'varchar(50)',
		'nullable' => 'YES',
		'default' => '0',
		'primary' => '',
		'autoinc' => '',
		'comment' => '名称',
	),
	'pingshenhuiid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'pingshenhuiid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '评审会id',
	),
	'zhaojidanid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'zhaojidanid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '召集单id',
	),
	'zhaojidansubid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'zhaojidansubid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '召集单subid',
	),
	'pingshenhuileixing' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'pingshenhuileixing',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '评审会类型',
	),
	'expertid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'expertid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '专家表决id',
	),
	'userid' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'userid',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '用户表决id',
	),
	'shifoujieshu' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'shifoujieshu',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '是否结束',
	),
	'jianyifengxiandengji' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'jianyifengxiandengji',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '建议风险等级',
	),
	'dangqianfengxiandeng' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'dangqianfengxiandeng',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '当前风险等级',
	),
	'biaojueriqi' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'biaojueriqi',
		'type' => 'int(11)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '表决日期',
	),
	'baohouleixing' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'baohouleixing',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '保后类型',
	),
	'shifuhege' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'shifuhege',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '是否合格',
	),
	'danbaojiekuanleixing' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'danbaojiekuanleixing',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '担保借款类型',
	),
	'shanghuishunxu' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'shanghuishunxu',
		'type' => 'int(10)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '上会顺序',
	),
	'baohouzhixingdanhao' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'baohouzhixingdanhao',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '保后执行单号',
	),
	'yixiangdanbaofeilv' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'yixiangdanbaofeilv',
		'type' => 'decimal(18,6)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '意向担保费率',
	),
	'baozhengjinjianmianl' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'baozhengjinjianmianl',
		'type' => 'decimal(18,6)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '保证金减免率',
	),
	'yewupinzhong' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'yewupinzhong',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '业务品种',
	),
	'fandanbaocuoshi' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'fandanbaocuoshi',
		'type' => 'text',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '反担保措施',
	),
	'caozuoyaodian' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'caozuoyaodian',
		'type' => 'text',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '操作要点',
	),
	'pingweiqianzi' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'pingweiqianzi',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '评委签字',
	),
	'fandanbaocuoshifenxi' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'fandanbaocuoshifenxi',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '反担保措施分析单号',
	),
	'biangenghuizongdanha' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'biangenghuizongdanha',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '被变更汇总单号',
	),
	'biangengshenqingdanh' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'biangengshenqingdanh',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '被变更申请单号',
	),
	'biangengshenqingdan' => array(
		'tablename' => 'mis_auto_sxlpg',
		'name' => 'biangengshenqingdan',
		'type' => 'varchar(30)',
		'nullable' => 'YES',
		'default' => NULL,
		'primary' => '',
		'autoinc' => '',
		'comment' => '变更申请单',
	),
);

?>