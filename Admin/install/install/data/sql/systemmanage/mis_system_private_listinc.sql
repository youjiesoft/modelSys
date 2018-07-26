CREATE TABLE `mis_system_private_listinc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelname` varchar(100) DEFAULT NULL COMMENT '模型名',
  `fieldname` varchar(100) DEFAULT NULL COMMENT '字段名',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `shows` varchar(30) DEFAULT '1' COMMENT '显示',
  `widths` int(11) DEFAULT NULL COMMENT '列宽度',
  `sortnum` int(11) DEFAULT NULL COMMENT '排序',
  `sortsorder` tinyint(2) DEFAULT '0' COMMENT '数据排序顺序',
  `sortstype` varchar(10) DEFAULT NULL COMMENT '数据排序类型',
  `yangshi` varchar(255) DEFAULT 'left' COMMENT '对齐方式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9469 DEFAULT CHARSET=utf8;
