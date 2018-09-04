CREATE TABLE `mis_system_template_saveword` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `modelname` varchar(100) DEFAULT NULL COMMENT '模型名',
  `bindid` int(10) DEFAULT NULL COMMENT '关联ID   表单ID或者项目ID',
  `fileurl` text COMMENT '保存路径',
  `filename` varchar(200) DEFAULT NULL COMMENT '文件名称',
  `createtime` char(10) DEFAULT NULL COMMENT '创建时间',
  `type` varchar(10) DEFAULT NULL COMMENT '1阶段0单据',
  `modelid` int(11) DEFAULT NULL COMMENT '模型id',
  `swfurl` text,
  `isexport` tinyint(1) DEFAULT '0' COMMENT '是否已导出',
  PRIMARY KEY (`id`),
  KEY `mst_id` (`id`),
  KEY `b_id` (`bindid`)
) ENGINE=InnoDB AUTO_INCREMENT=81015 DEFAULT CHARSET=utf8;
