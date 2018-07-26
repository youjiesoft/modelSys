CREATE TABLE `mis_system_data_update_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `modelname` varchar(100) DEFAULT NULL COMMENT '模型英文名',
  `tablename` varchar(100) DEFAULT NULL COMMENT '数据表英文名',
  `tabletype` tinyint(1) DEFAULT NULL COMMENT '数据表类型',
  `tabledataid` int(11) DEFAULT NULL COMMENT '修改数据id',
  `updateinfo` text COMMENT '修改信息',
  `orderno` varchar(100) DEFAULT NULL COMMENT '编号',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `companyid` int(10) DEFAULT NULL COMMENT '公司ID',
  `sysdutyid` int(10) DEFAULT '0' COMMENT '职级ID',
  `createid` int(10) DEFAULT NULL COMMENT '创建人ID',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updateid` int(10) DEFAULT NULL COMMENT '修改人ID',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `departmentid` int(10) DEFAULT NULL COMMENT '部门ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;
