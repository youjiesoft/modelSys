<?php
/**
 * @Title: companyViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-公司树视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-11-25 16:07:47
 * @version V1.0
*/
class companyViewModel extends ViewModel {
	public $viewFields = array(
		'mis_system_company'=>array('_as'=>'mis_system_company','id','parentid','NAME','orderno','yongyouorderno',),
);
}
?>