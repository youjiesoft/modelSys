CREATE TABLE `mis_system_data_remind_mas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelname` varchar(50) DEFAULT NULL COMMENT '模型名称',
  `pkey` int(11) DEFAULT NULL COMMENT '关联数据id',
  `porderno` varchar(50) DEFAULT NULL COMMENT '单据编号',
  `msginfo` text COMMENT '提示信息',
  `type` int(1) DEFAULT '2' COMMENT '1 定时任务 2单据提醒',
  `status` int(1) DEFAULT '1',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `createid` int(11) DEFAULT NULL COMMENT '创建人',
  `linkstatus` tinyint(1) DEFAULT NULL COMMENT '是否链接 1是 0否',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=861553 DEFAULT CHARSET=utf8;
