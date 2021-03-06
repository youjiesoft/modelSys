CREATE TABLE `mis_system_orderno` (
  `tablename` varchar(50) NOT NULL COMMENT '对象obj',
  `maxlevels` int(2) DEFAULT '5' COMMENT '最大级数',
  `maxlenght` int(2) DEFAULT '40' COMMENT '最大长度',
  `singlelenght` int(1) DEFAULT '9' COMMENT '单级最大长度',
  `one` int(9) DEFAULT NULL COMMENT '第1级',
  `two` int(9) DEFAULT NULL COMMENT '第2级',
  `three` int(9) DEFAULT NULL COMMENT '第3级',
  `four` int(9) DEFAULT NULL COMMENT '第4级',
  `five` int(9) DEFAULT NULL COMMENT '第5级',
  `six` int(9) DEFAULT NULL COMMENT '第6级',
  `seven` int(9) DEFAULT NULL COMMENT '第7级',
  `eight` int(9) DEFAULT NULL COMMENT '第8级',
  `nine` int(9) DEFAULT NULL COMMENT '第9级',
  `ten` int(9) DEFAULT NULL COMMENT '第10级',
  `eleven` int(9) DEFAULT NULL COMMENT '第11级',
  `twelve` int(9) DEFAULT NULL COMMENT '第12级',
  `thirteen` int(9) DEFAULT NULL COMMENT '第13级',
  `levelreadonly` int(2) DEFAULT '0' COMMENT '只读标记'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
