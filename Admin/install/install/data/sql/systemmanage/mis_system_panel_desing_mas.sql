
CREATE TABLE `mis_system_panel_desing_mas` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `createid` int(11) DEFAULT NULL COMMENT '创建人ID',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `updateid` int(11) DEFAULT NULL COMMENT '修改人ID',
  `isshow` int(1) DEFAULT '1' COMMENT '是否显示至首页 1 是 0 否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;
