SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `mis_dynamic_database_sub`;
CREATE TABLE `mis_dynamic_database_sub` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '字段记录ID',
  `masid` int(10) DEFAULT NULL COMMENT '关联表记录ID',
  `rowid` varchar(255) DEFAULT NULL COMMENT '表单内部唯一标识',
  `field` varchar(255) DEFAULT NULL COMMENT '字段英文名',
  `title` varchar(100) DEFAULT NULL COMMENT '字段标题',
  `type` varchar(10) DEFAULT NULL COMMENT '字段类型',
  `length` varchar(50) DEFAULT NULL COMMENT '字段长度',
  `category` varchar(100) DEFAULT NULL COMMENT '组件类型',
  `weight` int(10) DEFAULT NULL COMMENT '权重',
  `sort` int(10) DEFAULT NULL COMMENT '布局页面中的初始排序',
  `isshow` int(1) DEFAULT NULL COMMENT '是否显示到布局页面中',
  `isdatasouce` int(1) DEFAULT NULL COMMENT '是否为数据源 0：否 1：是',
  `status` int(1) DEFAULT '1' COMMENT '使用状态 1：启用 0：禁用',
  `formid` int(10) DEFAULT NULL COMMENT '表单编号',
  `modelname` varchar(100) DEFAULT NULL,
  `ischoise` int(1) DEFAULT '0' COMMENT '是否复用字段',
  `souceid` int(10) DEFAULT NULL COMMENT '复用时的来源ID值',
  `tablename` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35036 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='动态表单：表单中使用的字段记录';
