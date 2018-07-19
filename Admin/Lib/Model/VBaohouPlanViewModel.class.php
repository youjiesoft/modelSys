<?php
/**
 * @Title: VBaohouPlanViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-保后计划视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-08-25 11:08:57
 * @version V1.0
*/
class VBaohouPlanViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_xzhhe'=>array('_as'=>'mis_auto_xzhhe','projectid','orderno','id'=>'maxid','xiangmubianma','createid','zhuhetongjine','kehumingchen','xiangmumingchen','zhuti','xingye','chanyelian','fengxiandengji','yewujingli','fengkongjingli','zibaojingli','beizhu','status'=>'STATUS','companyid','createtime','jihuayijuriqi','zhuhetonghao','fangkuandanhao','fangkuanjine','fangkuanriqi','quyu','_type'=>'INNER'),
		'mis_auto_xzhhe_sub_datatable9'=>array('_as'=>'mis_auto_xzhhe_sub_datatable9','ID'=>'minid','baohounaxing','yaoqiujimiaoshu','zhouqitian','jihuakaishiriqi','jihuawanchengriqi','_on'=>'mis_auto_xzhhemis_auto_xzhhe_sub_datatable9.ID=mis_auto_xzhhe_sub_datatable9mis_auto_xzhhe_sub_datatable9.masid'),
		'mis_auto_fqtej'=>array('_as'=>'mis_auto_fqtej','hezuoyinxing','_on'=>'mis_auto_xzhhemis_auto_fqtej.zhuhetonghao=mis_auto_fqtejmis_auto_fqtej.orderno'),
);
}
?>