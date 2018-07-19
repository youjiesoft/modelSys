<?php
/**
 * @Title: xmzhmcViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-项目综合视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2017-11-09 10:32:38
 * @version V1.0
*/
class xmzhmcViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_bklne'=>array('_as'=>'mis_auto_bklne','0)','_type'=>'LEFT'),
		'mis_auto_banmo'=>array('_as'=>'mis_auto_banmo','_on'=>'mis_auto_bklnemis_auto_banmo.kehumingchen=mis_auto_banmomis_auto_banmo.orderno'),
		'mis_auto_dfsei'=>array('_as'=>'mis_auto_dfsei','_on'=>'mis_auto_bklnemis_auto_dfsei.projectid=mis_auto_dfseimis_auto_dfsei.projectid'),
		'workinfo'=>array('_as'=>'workinfo','_on'=>'mis_auto_bklneworkinfo.projectid = workinfoworkinfo.projectid'),
		'mis_auto_fqtej'=>array('_as'=>'mis_auto_fqtej','_on'=>'mis_auto_bklnemis_auto_fqtej.projectid=mis_auto_fqtejmis_auto_fqtej.projectid'),
		'mis_auto_qbvxq'=>array('_as'=>'mis_auto_qbvxq','_on'=>'mis_auto_bklnemis_auto_qbvxq.yixiangyinxing=mis_auto_qbvxqmis_auto_qbvxq.orderno'),
);
}
?>