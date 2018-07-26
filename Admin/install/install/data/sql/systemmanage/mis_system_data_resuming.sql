CREATE TABLE `mis_system_data_resuming` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tablename` varchar(50) DEFAULT NULL COMMENT '表名',
  `tableid` int(10) DEFAULT NULL COMMENT '表id',
  `sqlresume` text COMMENT '还原的sql语句',
  `category` tinyint(1) DEFAULT NULL COMMENT '类型1.变更还原',
  `dataresume` text COMMENT '原数据',
  `createtime` int(11) DEFAULT NULL COMMENT '新增时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3444 DEFAULT CHARSET=utf8 COMMENT='数据库贯穿表';
