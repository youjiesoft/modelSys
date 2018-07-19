<?php
/**
 * @Title: testViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-4443)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-04-18 17:40:35
 * @version V1.0
*/
class testViewModel extends ViewModel {
	public $viewFields = array(
		'user'=>array('_as'=>'user','id','account','name',),
);
}
?>