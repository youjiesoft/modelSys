
DROP TABLE IF EXISTS `process_relation_parallel`;
CREATE TABLE `process_relation_parallel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(100) DEFAULT NULL,
  `tableid` int(10) DEFAULT NULL,
  `bactch` int(10) DEFAULT NULL COMMENT '批次ID',
  `bactchname` varchar(100) DEFAULT NULL COMMENT '批次名称',
  `curAuditUser` varchar(400) DEFAULT NULL COMMENT '审核人',
  `relation_formid` int(10) DEFAULT NULL COMMENT '流程节点ID',
  `parentid` int(10) DEFAULT NULL COMMENT '上级ID',
  `auditState` tinyint(1) DEFAULT '0' COMMENT '0未推送1已推送2已完成',
  `sort` int(5) DEFAULT NULL,
  `createid` int(10) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
