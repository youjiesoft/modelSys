CREATE TABLE `mis_system_flow_link` (
  `id` int(10) NOT NULL COMMENT '任务id',
  `predecessorid` int(10) DEFAULT '0' COMMENT '该链接前置任务的ID',
  `successorid` int(10) DEFAULT '0' COMMENT '该链接后置任务的ID',
  `type` int(10) DEFAULT '0' COMMENT '0-3的整数，分别代表 ''FF'',''FS'',''SF'',''SS'' '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
