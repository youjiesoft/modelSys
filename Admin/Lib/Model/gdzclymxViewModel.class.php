<?php
/**
 * @Title: gdzclymxViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-固定资产领用单视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-09-28 17:46:49
 * @version V1.0
*/
class gdzclymxViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_agprm'=>array('_as'=>'mis_auto_agprm','lingyongren','lingyongbumen','lingyongriqi','cunfangdidian','createtime','companyid','createid','departmentid','id','_type'=>'INNER'),
		'mis_auto_agprm_sub_lingyongmingxi'=>array('_as'=>'mis_auto_agprm_sub_lingyongmingxi','masid','zichanbianhao','guigexinghao','danwei','shuliang','danjia','jine','leibie','_on'=>'mis_auto_agprmmis_auto_agprm_sub_lingyongmingxi.id=mis_auto_agprm_sub_lingyongmingximis_auto_agprm_sub_lingyongmingxi.masid'),
		'mis_auto_oljig'=>array('_as'=>'mis_auto_oljig','zichanmingchen','_on'=>'mis_auto_agprm_sub_lingyongmingximis_auto_oljig.zichanmingchen=mis_auto_oljigmis_auto_oljig.orderno'),
);
}
?>