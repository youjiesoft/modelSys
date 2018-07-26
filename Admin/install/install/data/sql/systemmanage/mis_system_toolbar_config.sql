
CREATE TABLE `mis_system_toolbar_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `modelname` varchar(100) DEFAULT NULL COMMENT '模型名称',
  `jskey` varchar(100) DEFAULT NULL COMMENT '按钮标识',
  `ifcheck` varchar(100) DEFAULT NULL COMMENT '权限检查',
  `permisname` text COMMENT '权限控制',
  `extendurl` text COMMENT 'url扩展',
  `html` text COMMENT '按钮html',
  `shows` varchar(255) DEFAULT NULL COMMENT '是否显示',
  `sortnum` varchar(255) DEFAULT NULL COMMENT '排序',
  `rules` varchar(255) DEFAULT NULL COMMENT '规则',
  `ismore` varchar(255) DEFAULT NULL COMMENT '是否放在更多按钮里',
  `rightnotshow` varchar(500) DEFAULT NULL COMMENT '右侧不显示',
  `showrules` text COMMENT '条件显示',
  `rulesinfo` text COMMENT '条件数组',
  `disabledrules` text COMMENT '不可点击条件',
  `disabledmap` text COMMENT '不可点击条件(标准)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
