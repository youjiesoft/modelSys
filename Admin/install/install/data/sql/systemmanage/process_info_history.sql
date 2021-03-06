CREATE TABLE `process_info_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(100) NOT NULL DEFAULT '' COMMENT '单据对应表名称',
  `tableid` int(10) NOT NULL DEFAULT '0' COMMENT '单据对应表ID',
  `orderno` varchar(50) DEFAULT NULL COMMENT '单据号',
  `ostatus` varchar(100) DEFAULT '0' COMMENT '流程状态',
  `ptmptid` int(10) DEFAULT '0' COMMENT '流程ID',
  `userid` int(10) DEFAULT NULL COMMENT '处理人',
  `ordercreateid` int(10) DEFAULT NULL COMMENT '单据创建人',
  `dotype` varchar(50) DEFAULT NULL COMMENT '处理状态',
  `dotime` int(11) DEFAULT NULL COMMENT '处理时间',
  `doinfo` varchar(200) DEFAULT NULL COMMENT '处理意见',
  `status` int(1) DEFAULT '1' COMMENT '状态',
  `companyid` int(10) DEFAULT NULL COMMENT 'company_id',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `auditstatus` int(1) DEFAULT NULL COMMENT '前当审核状态(停用)',
  `createid` int(10) DEFAULT NULL COMMENT 'create_id',
  `operateid` int(10) DEFAULT '0' COMMENT '操作人ID',
  `createtime` int(11) DEFAULT NULL COMMENT 'create_time',
  `updatetime` int(11) DEFAULT NULL COMMENT 'update_time',
  `updateid` int(10) DEFAULT NULL COMMENT 'update_id',
  `projectid` int(10) DEFAULT NULL COMMENT '项目ID',
  `projectworkid` int(10) DEFAULT NULL COMMENT '任务ID',
  `sysdutyid` int(10) DEFAULT '0' COMMENT '职级',
  `relationmodelname` varchar(100) DEFAULT '0' COMMENT '关系型表单关联model',
  `document` tinyint(1) DEFAULT '0' COMMENT '是否生成文档',
  PRIMARY KEY (`id`),
  KEY `IDX_process_info_history_tableid` (`tableid`),
  KEY `IDX_process_info_history_tablename` (`tablename`),
  KEY `IDX_process_info_history_id` (`dotime`)
) ENGINE=InnoDB AUTO_INCREMENT=5299 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
