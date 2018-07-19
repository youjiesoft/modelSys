<?php
/**
 * @Title: cwgwxyViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-财务顾问协议视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-06-19 09:38:50
 * @version V1.0
*/
class cwgwxyViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_fqtej'=>array('_as'=>'mis_auto_fqtej','projectid','xiangmubianma','xiangmumingchen','kehumingchen','orderno'=>'zhuhetongbianhao','_type'=>'LEFT'),
		'mis_auto_omxsh'=>array('_as'=>'mis_auto_omxsh','orderno','caiwuguwenxieyiqiand','caiwuguwenfei','_on'=>'mis_auto_fqtejmis_auto_omxsh.orderno = mis_auto_omxshmis_auto_omxsh.zhuhetongbianhao'),
);
}
?>