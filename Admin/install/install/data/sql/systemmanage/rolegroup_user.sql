CREATE TABLE `rolegroup_user` (
  `rolegroup_id` int(10) DEFAULT NULL COMMENT '权限组ID',
  `user_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `companyid` int(10) DEFAULT NULL COMMENT 'company_id',
  `sysdutyid` int(10) DEFAULT '0' COMMENT '职级ID',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `createid` int(10) DEFAULT NULL COMMENT 'create_id',
  `operateid` int(10) DEFAULT '0' COMMENT '操作人ID',
  `createtime` int(11) DEFAULT NULL COMMENT 'create_time',
  `updatetime` int(11) DEFAULT NULL COMMENT 'update_time',
  `updateid` int(10) DEFAULT NULL COMMENT 'update_id',
  KEY `user_id` (`user_id`),
  KEY `rolegroup_id` (`rolegroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
