
CREATE TABLE `mis_system_remind_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actionname` varchar(100) DEFAULT NULL,
  `field` varchar(100) DEFAULT NULL,
  `fieldlegth` int(4) DEFAULT NULL,
  `fieldsort` int(4) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `companyid` int(10) DEFAULT NULL COMMENT 'company_id',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `createid` int(10) DEFAULT NULL COMMENT 'create_id',
  `operateid` int(10) DEFAULT '0' COMMENT '操作人ID',
  `createtime` int(11) DEFAULT NULL COMMENT 'create_time',
  `updatetime` int(11) DEFAULT NULL COMMENT 'update_time',
  `updateid` int(10) DEFAULT NULL COMMENT 'update_id',
  `sysdutyid` int(10) DEFAULT '0' COMMENT 'èŒçº§ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;
