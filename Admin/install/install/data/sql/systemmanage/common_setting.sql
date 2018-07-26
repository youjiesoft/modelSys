CREATE TABLE `#__common_setting` (
  `skey` varchar(255) NOT NULL DEFAULT '',
  `sname` varchar(100) NOT NULL,
  `svalue` text NOT NULL,
  `remark` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`skey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
