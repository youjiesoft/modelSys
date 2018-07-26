CREATE TABLE `mis_auto_primary_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `tablename` varchar(50) DEFAULT NULL COMMENT '表名称',
  `primaryname` varchar(50) DEFAULT NULL COMMENT '主表名称',
  `filedlist` text COMMENT '表信息(序列化)',
  `createid` int(11) DEFAULT NULL COMMENT '创建人',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updateid` int(11) DEFAULT NULL COMMENT '修改人',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
