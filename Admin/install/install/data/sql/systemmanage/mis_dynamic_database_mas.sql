SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `mis_dynamic_database_mas`;
CREATE TABLE `mis_dynamic_database_mas` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '表记录ID',
  `tablename` varchar(100) DEFAULT NULL COMMENT '表名',
  `tabletitle` varchar(100) DEFAULT NULL COMMENT '表标题',
  `isprimary` int(1) DEFAULT '0' COMMENT '是否是主表。0：不是主表，1：为主表',
  `ischoise` int(1) DEFAULT '0' COMMENT '是否为选择的复用表。0：否 1：是',
  `status` int(1) DEFAULT '1' COMMENT '启用状态。1：启用，0：禁用',
  `formid` int(10) DEFAULT NULL COMMENT '表单关联ID',
  `modelname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1106 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='动态表单：表记录';
