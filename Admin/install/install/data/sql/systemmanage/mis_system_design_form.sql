CREATE TABLE `mis_system_design_form` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `actionname` varchar(50) DEFAULT NULL COMMENT '对象名称',
  `path` varchar(100) DEFAULT NULL COMMENT '显示文件路径',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态',
  `createid` int(10) DEFAULT NULL COMMENT '创建人ID',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updateid` int(10) DEFAULT NULL COMMENT '修改人ID',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `issystem` tinyint(1) DEFAULT NULL COMMENT '是否为系统默认数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='页面设计-表单记录\r\n';
