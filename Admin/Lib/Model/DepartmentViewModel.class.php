<?php
/**
 * @Title: DepartmentViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-部门树视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-03-03 14:00:31
 * @version V1.0
*/
class DepartmentViewModel extends ViewModel {
	public $viewFields = array(
		'tree_department'=>array('_as'=>'tree_department','id','parentid','name','orderno','yongyouorderno','quyu','cmpname','cmpid',),
);
}
?>