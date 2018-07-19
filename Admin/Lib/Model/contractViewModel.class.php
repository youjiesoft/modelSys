<?php
/**
 * @Title: contractViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-合同参照)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2017-09-26 15:11:18
 * @version V1.0
*/
class contractViewModel extends ViewModel {
	public $viewFields = array(
		'contract'=>array('_as'=>'contract','orderno',),
);
}
?>