CREATE TABLE `mis_dynamic_form_datatable_sort` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `modelname` varchar(50) DEFAULT NULL COMMENT '模型名',
  `title` varchar(200) DEFAULT NULL COMMENT '内嵌表title',
  `field` varchar(50) DEFAULT NULL COMMENT '内嵌表字段名',
  `tablename` varchar(50) DEFAULT NULL COMMENT '内嵌表名',
  `sort` int(10) DEFAULT NULL COMMENT '序号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=865 DEFAULT CHARSET=utf8 COMMENT='内嵌表顺序表，处理word模板标签问题';
