CREATE TABLE `mis_system_config_orderno` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(100) DEFAULT NULL COMMENT '表名',
  `rulename` varchar(100) DEFAULT NULL COMMENT '对象规则名',
  `rule` varchar(100) DEFAULT NULL COMMENT '单据编号',
  `prefix1` varchar(100) DEFAULT NULL COMMENT '前缀1类型',
  `prefix1_value` varchar(255) DEFAULT NULL COMMENT '前缀1设定值',
  `prefix1_long` varchar(255) DEFAULT NULL COMMENT '前缀1长度',
  `prefix2` varchar(255) DEFAULT NULL COMMENT '前缀2',
  `prefix2_value` varchar(255) DEFAULT NULL COMMENT '前缀2设定值',
  `prefix2_long` varchar(255) DEFAULT NULL COMMENT '前缀2长度',
  `prefix3` varchar(100) DEFAULT NULL COMMENT '前缀3',
  `prefix3_value` varchar(255) DEFAULT NULL COMMENT '前缀3设定值',
  `prefix3_long` varchar(255) DEFAULT NULL COMMENT '前缀3长度',
  `prefix4` varchar(100) DEFAULT NULL COMMENT '前缀4',
  `prefix4_value` varchar(255) DEFAULT NULL COMMENT '前缀4设定值',
  `prefix4_long` varchar(255) DEFAULT NULL COMMENT '前缀4长度',
  `prefix5` varchar(100) DEFAULT NULL,
  `prefix5_value` varchar(100) DEFAULT NULL,
  `prefix5_long` varchar(100) DEFAULT NULL,
  `prefix6` varchar(100) DEFAULT NULL,
  `prefix6_value` varchar(100) DEFAULT NULL,
  `prefix6_long` varchar(100) DEFAULT NULL,
  `suffix` varchar(100) DEFAULT NULL COMMENT '后缀',
  `suffix1_value` varchar(100) DEFAULT NULL,
  `suffix1_long` varchar(100) DEFAULT NULL,
  `suffix2` varchar(100) DEFAULT NULL,
  `suffix2_value` varchar(100) DEFAULT NULL,
  `suffix2_long` varchar(100) DEFAULT NULL,
  `suffix3` varchar(100) DEFAULT NULL,
  `suffix3_value` varchar(100) DEFAULT NULL,
  `suffix3_long` varchar(100) DEFAULT NULL,
  `suffix4` varchar(100) DEFAULT NULL,
  `suffix4_value` varchar(100) DEFAULT NULL,
  `suffix4_long` varchar(100) DEFAULT NULL,
  `num` int(10) DEFAULT NULL COMMENT '流水号位数',
  `numshow` int(10) DEFAULT NULL COMMENT '最新编码显示',
  `numnew` int(10) DEFAULT NULL COMMENT '最新编码设置',
  `writable` int(1) DEFAULT NULL COMMENT '是否可修改',
  `status` int(1) DEFAULT NULL COMMENT '是否自动生成编码(0：否，1：是)',
  `preview` varchar(100) DEFAULT NULL COMMENT '规则预览',
  `modelname` varchar(100) DEFAULT NULL COMMENT '模型名',
  `classify` int(1) DEFAULT '0' COMMENT '是否分类',
  `typefield` varchar(100) DEFAULT NULL COMMENT '分类字段',
  `fieldtable` varchar(100) DEFAULT NULL COMMENT '分类来源表',
  `correlationfield` varchar(100) DEFAULT NULL COMMENT '关联字段',
  `oldrule` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46064 DEFAULT CHARSET=utf8;
