<?php
/**
 * @Title: companybudgetViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-集团费用项目del)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-02-29 11:21:16
 * @version V1.0
*/
class companybudgetViewModel extends ViewModel {
	public $viewFields = array(
		'company_budget'=>array('_as'=>'company_budget','id','parentid','name','nianfen','zhangtao','deptid',),
);
}
?>