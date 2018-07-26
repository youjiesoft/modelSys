CREATE TABLE `mis_system_data_control_mas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '数据控制名称',
  `modelname` varchar(100) DEFAULT NULL COMMENT '数据控制模型',
  `createid` int(10) DEFAULT NULL COMMENT '创建人',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updateid` int(10) DEFAULT NULL COMMENT '修改人',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `companyid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
