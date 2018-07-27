CREATE TABLE `mis_expert_question_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL COMMENT '类型编码',
  `name` varchar(50) NOT NULL,
  `createid` int(11) NOT NULL,
  `operateid` int(10) DEFAULT '0' COMMENT '操作人ID',
  `createtime` int(11) NOT NULL,
  `updateid` int(11) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `companyid` int(10) DEFAULT NULL COMMENT 'company_id',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `pid` int(11) DEFAULT '0' COMMENT '父级类型',
  `sysdutyid` int(10) DEFAULT '0' COMMENT 'èŒçº§ID',
  `relationmodelname` varchar(100) DEFAULT '0' COMMENT '关系型表单关联model',
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='问题分类表';
