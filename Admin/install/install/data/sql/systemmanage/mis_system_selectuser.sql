CREATE TABLE `mis_system_selectuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `modelname` varchar(100) DEFAULT NULL COMMENT '模型名称',
  `tableid` int(11) DEFAULT NULL COMMENT '模型对应数据id',
  `fieldname` varchar(100) DEFAULT NULL COMMENT '字段名称',
  `typeid` int(1) DEFAULT '1' COMMENT '绑定数据类型 1人 2组',
  `typeval` text COMMENT '选择值逗号分隔',
  `typename` text COMMENT '选择人名称逗号分隔',
  `status` int(1) DEFAULT '1' COMMENT '状态',
  `createid` int(11) DEFAULT NULL COMMENT '创建人',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updateid` int(11) DEFAULT NULL COMMENT '修改人',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;
