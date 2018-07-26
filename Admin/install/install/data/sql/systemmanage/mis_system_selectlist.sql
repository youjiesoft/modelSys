CREATE TABLE `mis_system_selectlist` (
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `remark` varchar(300) DEFAULT NULL,
  `level` int(10) DEFAULT NULL,
  `enumkey` text,
  `val` text,
  `status` int(1) DEFAULT '1',
  `createid` int(10) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `updateid` int(10) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `conftype` tinyint(1) DEFAULT '0' COMMENT '配置类型 0用户自定义 1系统配置'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
