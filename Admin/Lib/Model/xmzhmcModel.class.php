<?php
/**
 * @Title: xmzhmcModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-项目综合视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-01-29 17:06:42
 * @version V1.0
*/
class xmzhmcModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_bklne'=>array('_as'=>'mis_auto_bklne','projectid','orderno'=>'xmbm','xiangmumingchen'=>'xmmc','kehumingchen'=>'khbm','yixiangyinxing'=>'yxyhbm','pingshenqixian'=>'psrq','pingshenjine'=>'psje','_type'=>'LEFT'),
		'mis_auto_qbvxq'=>array('_as'=>'mis_auto_qbvxq','yingfuyinxingbaozhen','yinxingmingchen'=>'yxyhmc','yingshoukehubaozheng','baozhengjinzhanghumi','baozhengjinzhanghao','danbizuigaoe','teshuwenbenjiyaoqiu','shouxinedu','shouxinqixian','_on'=>'mis_auto_bklne.yixiangyinxing=mis_auto_qbvxq.orderno','_type'=>'LEFT'),
		'mis_auto_banmo'=>array('_as'=>'mis_auto_banmo','kehumingchen','zhucedizhi','youzhengbianma','dianhua','guimo','_on'=>'mis_auto_bklne.kehumingchen=mis_auto_banmo.orderno'),
);
}
?>