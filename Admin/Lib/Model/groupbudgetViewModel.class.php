<?php
/**
 * @Title: groupbudgetViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-集团预算视图新)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-03-04 14:01:15
 * @version V1.0
*/
class groupbudgetViewModel extends ViewModel {
	public $viewFields = array(
		'groupbudget'=>array('_as'=>'groupbudget','id','parentid','name','iyear','cmpid','zhangtao','yOrNoiYear','deptid','depOrderno','depName','yydepCode','yusuanshu','diaozhenghouyusuanshu','zhixingshu','chayi','checkiMoney','kyys','info','bnyss','information','alliyear','newkyys',),
);
}
?>