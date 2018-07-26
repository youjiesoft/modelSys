CREATE TABLE `mis_system_duty` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `code` varchar(20) DEFAULT NULL COMMENT '编码',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `companyid` int(10) DEFAULT NULL COMMENT 'company_id',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `createid` int(10) DEFAULT NULL COMMENT 'create_id',
  `operateid` int(10) DEFAULT '0' COMMENT '操作人ID',
  `createtime` int(11) DEFAULT NULL COMMENT 'create_time',
  `updatetime` int(11) DEFAULT NULL COMMENT 'update_time',
  `updateid` int(10) DEFAULT NULL COMMENT 'update_id',
  `sysdutyid` int(10) DEFAULT '0' COMMENT 'èŒçº§ID',
  `relationmodelname` varchar(100) DEFAULT '0' COMMENT '关系型表单关联model',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='审核职级';
