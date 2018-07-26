CREATE TABLE `mis_auto_primary_mas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tablename` varchar(200) DEFAULT NULL COMMENT '主表名称',
  `tabletitle` varchar(200) DEFAULT NULL COMMENT '中文表名',
  `filedlist` text COMMENT '字段列表',
  `createid` int(11) DEFAULT NULL COMMENT '创建人',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updateid` int(11) DEFAULT NULL COMMENT '修改人',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `companyid` int(11) DEFAULT NULL,
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `status` int(1) DEFAULT '1' COMMENT '状态',
  `sysdutyid` int(10) DEFAULT '0' COMMENT 'èŒçº§ID',
  `relationmodelname` varchar(100) DEFAULT '0' COMMENT '关系型表单关联model',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=452 DEFAULT CHARSET=utf8;
