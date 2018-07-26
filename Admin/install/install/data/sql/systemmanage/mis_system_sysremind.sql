CREATE TABLE `mis_system_sysremind` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `modelname` varchar(100) DEFAULT NULL COMMENT '模型名称',
  `pkey` int(11) DEFAULT NULL COMMENT '模型对应',
  `content` text COMMENT '标题',
  `remindcreateid` int(11) DEFAULT NULL COMMENT '创建人',
  `remindcreatetime` int(11) DEFAULT NULL COMMENT '创建时间',
  `isread` int(1) DEFAULT '0' COMMENT '是否阅读',
  `userid` int(11) DEFAULT NULL COMMENT '用户id',
  `createid` int(11) DEFAULT NULL COMMENT '创建人',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updateid` int(11) DEFAULT NULL COMMENT '修改人',
  `updatetime` int(11) DEFAULT NULL COMMENT '修改时间',
  `status` int(1) DEFAULT '1',
  `readcount` int(11) DEFAULT NULL COMMENT '阅读次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71145 DEFAULT CHARSET=utf8;
