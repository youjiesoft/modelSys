<?php
/**
 * @Title: HKJHHZViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-还款计划汇总)
 * @author 蒋智晶
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-04-29 17:14:15
 * @version V1.0
*/
class HKJHHZViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_nlpza'=>array('_as'=>'mis_auto_nlpza','projectid','orderno','id'=>'maxid','zhuhetonghao','xiangmubianma','yewuleixing','yinxingfangkuanriqi','hetongid','kehumingchen','xiangmumingchen','status'=>'STATUS','companyid','createtime','_type'=>'INNER'),
		'mis_auto_nlpza_sub_datatable8'=>array('_as'=>'mis_auto_nlpza_sub_datatable8','_on'=>'mis_auto_nlpza.ID=mis_auto_nlpza_sub_datatable8.masid','_type'=>'INNER'),
		''=>array('_as'=>'','fangkuandanhao)'=>'fangkuandanhao','fangkuanriqi)'=>'fangkuanriqi','yinghuaikuanrijidaoqiri)'=>'yinghuaikuanrijidaoqiri',),
		''=>array('_as'=>'','yinghuaikuanjine)'=>'yinghuaikuanjine',),
		''=>array('_as'=>'','yinghuaikuanrijidaoqiri)-(mis_auto_nlpza'=>'jiangetianshu',),
);
}
?>