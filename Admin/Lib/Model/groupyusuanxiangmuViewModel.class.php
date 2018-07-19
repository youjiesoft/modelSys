<?php
/**
 * @Title: groupyusuanxiangmuViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-集团预算项目)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-03-03 14:00:21
 * @version V1.0
*/
class groupyusuanxiangmuViewModel extends ViewModel {
	public $viewFields = array(
		'group_budget'=>array('_as'=>'group_budget','id','parentid','name','cmpname','cmpid','nianfen',),
);
}
?>