CREATE TABLE `mis_hr_typeinfo` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `typeid` int(2) DEFAULT '2' COMMENT '类型',
  `code` varchar(100) DEFAULT NULL COMMENT '编码',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `pid` int(10) DEFAULT '0' COMMENT '上级节点',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  `createtime` int(11) DEFAULT '1353945600' COMMENT '创建时间',
  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',
  `createid` int(10) DEFAULT '1' COMMENT '创建人',
  `operateid` int(10) DEFAULT '0' COMMENT '操作人ID',
  `updateid` int(10) DEFAULT NULL COMMENT '更新人',
  `status` int(3) DEFAULT '1' COMMENT '状态',
  `companyid` int(10) DEFAULT NULL COMMENT 'company_id',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `sysdutyid` int(10) DEFAULT '0' COMMENT 'èŒçº§ID',
  `relationmodelname` varchar(100) DEFAULT '0' COMMENT '关系型表单关联model',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
