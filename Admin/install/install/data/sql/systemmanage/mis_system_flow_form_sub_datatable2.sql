CREATE TABLE `mis_system_flow_form_sub_datatable2` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `masid` int(11) DEFAULT NULL COMMENT '关联动态表单数据ID',
  `ziliaomingchen` varchar(50) DEFAULT NULL COMMENT '资料名称',
  `guidangleixing` varchar(30) DEFAULT NULL COMMENT '归档类型',
  `shifuguidangdanjutou` varchar(30) DEFAULT NULL COMMENT '是否归档单据头',
  PRIMARY KEY (`id`),
  KEY `delete_Action_datatable8` (`masid`),
  CONSTRAINT `mis_system_flow_form_sub_datatable2` FOREIGN KEY (`masid`) REFERENCES `mis_system_flow_form` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动态表单:mis_auto_exetw 内嵌表  mis_system_flow_form_sub_datatable2';
