<?php
/**
 * @Title: pffangksumViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-批复放款次数汇总)
 * @author 汤文志
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-07-16 18:52:44
 * @version V1.0
*/
class pffangksumViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_wrmve'=>array('_as'=>'mis_auto_wrmve','orderno','_type'=>'INNER'),
		'mis_auto_wrmve_sub_datatable18'=>array('_as'=>'mis_auto_wrmve_sub_datatable18','fangkuancishu','_on'=>'mis_auto_wrmve.id = mis_auto_wrmve_sub_datatable18.masid'),
		''=>array('_as'=>'',' SUM(mis_auto_wrmve_sub_datatable18.fangkuanjine) '=>'fangkuanjine',),
);
}
?>