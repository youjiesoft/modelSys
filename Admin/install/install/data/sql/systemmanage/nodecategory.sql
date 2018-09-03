DROP TABLE IF EXISTS `nodecategory`;
CREATE TABLE `nodecategory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `sort` varchar(4) DEFAULT NULL,
  `createid` int(10) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `updateid` int(10) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `companyid` int(10) DEFAULT NULL,
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `operateid` int(10) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `sysdutyid` int(10) DEFAULT '0' COMMENT 'èŒçº§ID',
  `relationmodelname` varchar(100) DEFAULT '0' COMMENT '关系型表单关联model',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
