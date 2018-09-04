CREATE TABLE `role_rolegroup` (
  `role_id` int(10) DEFAULT NULL COMMENT '基础权限组ID',
  `rolegroup_id` int(10) DEFAULT NULL COMMENT '高级权限组ID',
  `companyid` int(10) DEFAULT NULL COMMENT 'company_id',
  `sysdutyid` int(10) DEFAULT '0' COMMENT '职级ID',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `createid` int(10) DEFAULT NULL COMMENT 'create_id',
  `operateid` int(10) DEFAULT '0' COMMENT '操作人ID',
  `createtime` int(11) DEFAULT NULL COMMENT 'create_time',
  `updatetime` int(11) DEFAULT NULL COMMENT 'update_time',
  `updateid` int(10) DEFAULT NULL COMMENT 'update_id',
  `status` int(1) DEFAULT '1' COMMENT '状态',
  KEY `role_id` (`role_id`),
  KEY `rolegroup_id` (`rolegroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
