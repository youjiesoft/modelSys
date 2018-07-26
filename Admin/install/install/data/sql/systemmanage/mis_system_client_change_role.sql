CREATE TABLE `mis_system_client_change_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `modelname` varchar(50) DEFAULT NULL COMMENT '模型id',
  `tablename` varchar(100) DEFAULT NULL COMMENT '主表id',
  `fieldname` varchar(50) DEFAULT NULL COMMENT '表字段',
  `content` text COMMENT '分配内容',
  `isall` tinyint(1) DEFAULT '0' COMMENT '是否全选',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `companyid` int(10) DEFAULT '0' COMMENT '公司ID',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `createid` int(10) DEFAULT NULL COMMENT '创建人ID',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updateid` int(10) DEFAULT NULL COMMENT '修改人ID',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `sysdutyid` int(10) DEFAULT '0' COMMENT '职级id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;
