CREATE TABLE `mis_system_list_limit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tableid` int(11) DEFAULT NULL COMMENT 'å…è®¸ç”¨æˆ·id',
  `tablename` varchar(255) DEFAULT NULL COMMENT 'è¡¨å',
  `modelname` varchar(100) DEFAULT NULL COMMENT 'æ¨¡å—å',
  `allowfields` text COMMENT 'å…è®¸å­—æ®µ',
  `denyfields` text COMMENT 'ç¦æ­¢å­—æ®µ',
  `orderno` varchar(100) DEFAULT NULL COMMENT 'ç¼–å·',
  `status` tinyint(1) DEFAULT '1' COMMENT 'çŠ¶æ€',
  `companyid` int(11) DEFAULT '0' COMMENT 'å…¬å¸ID',
  `createid` int(11) DEFAULT NULL COMMENT 'åˆ›å»ºäººID',
  `createtime` int(11) DEFAULT NULL COMMENT 'åˆ›å»ºæ—¶é—´',
  `updateid` int(11) DEFAULT NULL COMMENT 'ä¿®æ”¹äººID',
  `updatetime` int(11) DEFAULT NULL COMMENT 'ä¿®æ”¹æ—¶é—´',
  `departmentid` int(11) DEFAULT NULL COMMENT 'éƒ¨é—¨ID',
  `sysdutyid` int(10) DEFAULT '0' COMMENT 'èŒçº§ID',
  `relationmodelname` varchar(100) DEFAULT '0' COMMENT '关系型表单关联model',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
