CREATE TABLE `mis_meeting_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `orderno` varchar(20) DEFAULT NULL COMMENT '编号',
  `name` varchar(20) DEFAULT NULL COMMENT '名称',
  `galleryful` int(11) DEFAULT NULL COMMENT '容纳人数',
  `leisure` int(1) DEFAULT '0' COMMENT '空闲状态 1--空闲中 0--- 使用中',
  `status` int(1) DEFAULT '1' COMMENT '状态',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `departmentid` int(10) DEFAULT '0' COMMENT '部门ID',
  `createtime` int(11) DEFAULT NULL,
  `createid` int(11) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL COMMENT '备注 ',
  `updateid` int(11) DEFAULT NULL,
  `sysdutyid` int(10) DEFAULT '0' COMMENT 'èŒçº§ID',
  `relationmodelname` varchar(100) DEFAULT '0' COMMENT '关系型表单关联model',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
