<?php
/**
 * @Title: DZYinViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-抵质押入库视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-08-28 09:47:50
 * @version V1.0
*/
class DZYinViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_lhikt'=>array('_as'=>'mis_auto_lhikt','orderno','xiangmubianma','xiangmumingchen','kehumingchen','status','_type'=>'LEFT'),
		'mis_auto_lhikt_sub_datatable5'=>array('_as'=>'mis_auto_lhikt_sub_datatable5','fandanbaocuoshibianhao','taxiangquanzhengbianhao','rukuweizhi','zuojia','quanzhengbianhao','id','masid','qita','_on'=>'mis_auto_lhikt.id=mis_auto_lhikt_sub_datatable5.masid'),
		'mis_auto_rdjuz'=>array('_as'=>'mis_auto_rdjuz','name'=>'fandanbaocuoshileixing','_on'=>'mis_auto_lhikt_sub_datatable5.fandanbaocuoshileixing=mis_auto_rdjuz.orderno'),
);
}
?>