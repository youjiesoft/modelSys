SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `mis_dynamic_form_template`;
CREATE TABLE `mis_dynamic_form_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '模板记录ID',
  `tplname` varchar(50) DEFAULT NULL COMMENT '模板名称',
  `tpltitle` varchar(50) DEFAULT NULL COMMENT '模板标题',
  `tplfield` text COMMENT '字段集合 ，号分割',
  `formid` int(10) DEFAULT NULL COMMENT '表单编号',
  `status` int(1) DEFAULT '1' COMMENT '模板使用状态。1：启用 0：禁用',
  `tablename` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1076 DEFAULT CHARSET=utf8;
