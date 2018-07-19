<?php 
/**
 * @Title: Config
 * @Package package_name
 * @Description: todo(动态表单_配置文件-系统视图list.inc 配置文件)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-03-13 20:08:07
 * @version V1.0
*/
return array(
	'orderno' => array(
		'name' => 'orderno',
		'showname' => '编号',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'orderno',
		'sortnum' => '5',
		'searchField' => 'mis_auto_wrmve.orderno',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '0',
		'helpvalue' => '',
	),
	'fangkuancishu' => array(
		'name' => 'fangkuancishu',
		'showname' => '放款次数',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'fangkuancishu',
		'sortnum' => '5',
		'searchField' => 'mis_auto_wrmve_sub_datatable18.fangkuancishu',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '1',
		'helpvalue' => '',
	),
	'bencije' => array(
		'name' => 'bencije',
		'showname' => '本次金额',
		'shows' => '1',
		'widths' => '',
		'sorts' => '0',
		'models' => '',
		'sortname' => 'bencije',
		'sortnum' => '5',
		'searchField' => 'SUM(mis_auto_wrmve_sub_datatable18.fangkuanjine) A',
		'conditions' => '',
		'type' => 'text',
		'issearch' => '1',
		'isallsearch' => '1',
		'searchsortnum' => '2',
		'helpvalue' => '',
		'func' => array(
			'0' => array(
				'0' => 'unitExchange',
			),
		),
		'funcdata' => array(
			'0' => array(
				'0' => array(
					'0' => '###',
					'1' => 'yuan',
					'2' => 'wan',
					'3' => '3',
				),
			),
		),
	),
);

?>