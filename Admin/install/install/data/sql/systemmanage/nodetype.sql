CREATE TABLE `nodetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) DEFAULT NULL COMMENT '节点类型名称',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态',
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
