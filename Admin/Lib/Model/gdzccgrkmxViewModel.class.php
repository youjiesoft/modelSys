<?php
/**
 * @Title: gdzccgrkmxViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-固定资产采购入库单视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-08-22 11:51:26
 * @version V1.0
*/
class gdzccgrkmxViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_fzfxe'=>array('_as'=>'mis_auto_fzfxe','shenqingren','createtime','shenqingbumen','gongyingshang','companyid','createid','departmentid','shenqingzhuti','_type'=>'INNER'),
		'mis_auto_fzfxe_sub_caigoumingxi'=>array('_as'=>'mis_auto_fzfxe_sub_caigoumingxi','id','masid','danwei','guigexinghao','jine','kapianid','lingyongren','qinggoudanhao','qinggoudanzibiaoid','shuliang','wupinmingchen','yujidanjia','yujijine','zichanbianhao','zichanleibie','zichanxitongbianhao','_on'=>'mis_auto_fzfxemis_auto_fzfxe_sub_caigoumingxi.id=mis_auto_fzfxe_sub_caigoumingximis_auto_fzfxe_sub_caigoumingxi.masid'),
);
}
?>