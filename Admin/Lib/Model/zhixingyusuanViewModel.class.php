<?php
/**
 * @Title: zhixingyusuanViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-执行预算视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-02-24 10:22:19
 * @version V1.0
*/
class zhixingyusuanViewModel extends ViewModel {
	public $viewFields = array(
		'yusxmuzhixing'=>array('_as'=>'yusxmuzhixing','id','parentid','information','name','departname','yusuanshumu','deptid','chayi','kemumingchen','kyys','nianfen','wanchenglv','shengpje','yongyoubumenbianma','yongyoubumenmingchen','diaozhenghouyusuanshu',),
);
}
?>