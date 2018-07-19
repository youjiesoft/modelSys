<?php
/**
 * @Title: SyshkjhViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-还款计划视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2016-12-05 19:09:48
 * @version V1.0
*/
class SyshkjhViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_nlpza'=>array('_as'=>'mis_auto_nlpza','projectid','orderno','id'=>'maxid','xiangmubianma','yewuleixing','zhuhetonghao','hezuoyinxing','hetongid','createid','yewujingli','fengkongjingli','baohoujingli','kehumingchen','xiangmumingchen','status'=>'STATUS','companyid','createtime','_type'=>'INNER'),
		'mis_auto_nlpza_sub_datatable8'=>array('_as'=>'mis_auto_nlpza_sub_datatable8','ID'=>'minid','beizhu','fangkuandanhao','fangkuanriqi','yinghuaikuanrijidaoqiri','yinghuaikuanjine','_on'=>'mis_auto_nlpza.ID=mis_auto_nlpza_sub_datatable8.masid'),
		'mis_auto_fqtej'=>array('_as'=>'mis_auto_fqtej','jiekuanhetonghao','jiekuanhetongmingche','baozhenghetonghao','_on'=>'mis_auto_nlpza.zhuhetonghao=mis_auto_fqtej.orderno'),
		'mis_auto_banmo'=>array('_as'=>'mis_auto_banmo','shijikongzhirenshenf','_on'=>'mis_auto_banmo.orderno=mis_auto_fqtej.kehumingchen'),
		'mis_auto_bklne'=>array('_as'=>'mis_auto_bklne','baodaihourenyuan','_on'=>'mis_auto_bklne.projectid=mis_auto_nlpza.projectid'),
);
}
?>