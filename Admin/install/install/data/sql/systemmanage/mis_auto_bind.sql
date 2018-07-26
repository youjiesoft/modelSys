CREATE TABLE `mis_auto_bind` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bindaname` varchar(50) DEFAULT NULL COMMENT '绑定actionname',
  `backval` varchar(500) DEFAULT NULL COMMENT '主表带值字段',
  `inbindaname` varchar(50) DEFAULT NULL COMMENT '被绑acitonname',
  `inbindtitle` varchar(500) DEFAULT NULL COMMENT '被绑标题',
  `inbindsort` int(11) DEFAULT NULL COMMENT '被绑顺序',
  `inbindval` varchar(200) DEFAULT NULL COMMENT '被绑对应字段',
  `inbackval` varchar(500) DEFAULT NULL COMMENT '子表带值字段',
  `bindfield` varchar(20) DEFAULT NULL COMMENT '绑定字段',
  `bindtype` int(1) DEFAULT '0' COMMENT '绑定类型。 0:表单 ，1:列表-内嵌，2：列表-表单，3：列表-弹窗',
  `status` int(1) DEFAULT '1' COMMENT '状态',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `bindresult` varchar(100) DEFAULT NULL COMMENT '绑定数据源字段',
  `bindval` varchar(100) DEFAULT NULL COMMENT '绑定数据源值',
  `typeid` int(1) DEFAULT '0' COMMENT '表单类型。0:组合表单，1：主从表单,2:套表。',
  `dataroamid` int(11) DEFAULT NULL COMMENT '数据漫游id',
  `bindformid` int(11) DEFAULT NULL COMMENT '绑定表单id',
  `inbindformid` int(11) DEFAULT NULL COMMENT '被绑表单id',
  `pid` int(10) DEFAULT NULL,
  `level` int(10) DEFAULT NULL,
  `bindconlistArr` text COMMENT '条件字段数组',
  `bindcondition` varchar(500) DEFAULT NULL COMMENT '绑定条件字段',
  `inbindcondition` varchar(500) DEFAULT NULL COMMENT '被绑条件字段',
  `showrules` text COMMENT '条件显示',
  `rulesinfo` text COMMENT '条件数组',
  `inbindmap` text COMMENT 'map条件',
  `iscopy` int(1) DEFAULT '0' COMMENT '是否复制数据 1是 0否',
  `formshowtype` int(1) DEFAULT '0' COMMENT '表单展示样式 0修改 1 查看',
  `isdelete` int(1) DEFAULT '0' COMMENT '是否同步删除 0否  1 是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9911 DEFAULT CHARSET=utf8;
