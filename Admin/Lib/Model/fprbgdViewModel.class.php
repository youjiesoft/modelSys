<?php
/**
 * @Title: fprbgdViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-分配人变更单视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-10-09 17:03:49
 * @version V1.0
*/
class fprbgdViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_hfkcv'=>array('_as'=>'mis_auto_hfkcv','xiangmubianma','_type'=>'LEFT'),
		'mis_auto_hfkcv_sub_biangengnarong'=>array('_as'=>'mis_auto_hfkcv_sub_biangengnarong','masid','id','fenpeidanhao','xiangmujiaose','fenpeiren','_on'=>'mis_auto_hfkcvmis_auto_hfkcv_sub_biangengnarong.id=mis_auto_hfkcv_sub_biangengnarongmis_auto_hfkcv_sub_biangengnarong.masid'),
);
}
?>