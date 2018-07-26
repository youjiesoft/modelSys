CREATE TABLE `mis_system_dataview_mas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) DEFAULT NULL COMMENT '视图名称',
  `modelname` varchar(50) DEFAULT NULL COMMENT '所属模型',
  `status` int(1) DEFAULT '1' COMMENT '状态1',
  `title` varchar(50) DEFAULT NULL COMMENT '模型名称（中文）',
  `spellsql` text COMMENT 'sql语句',
  `spellwheresql` text COMMENT 'sql语句(where替换)',
  `replacesql` text COMMENT '替换sql语句',
  `condition` text COMMENT '视图条件',
  `isdefault` int(1) DEFAULT '0' COMMENT '是否是node默认节点',
  `groupcondition` text COMMENT '分组',
  `ordernocondition` text COMMENT '排序',
  `orderDirection` varchar(50) DEFAULT NULL COMMENT '升序降序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
