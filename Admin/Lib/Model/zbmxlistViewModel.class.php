<?php
/**
 * @Title: zbmxlistViewModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-指标模型视图)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2017-06-03 13:49:30
 * @version V1.0
*/
class zbmxlistViewModel extends ViewModel {
	public $viewFields = array(
		'mis_auto_zaprt'=>array('_as'=>'mis_auto_zaprt','orderno','zhuti','xifenpinlei','xingye','daikuanyongtu','moxingleibie','shiyongxingmiaoshu','_type'=>'INNER'),
		'mis_auto_zaprt_sub_zhibiaonarong'=>array('_as'=>'mis_auto_zaprt_sub_zhibiaonarong','zhibiaomingchen','zhibiaomiaoshu','hengliangkoujing','hengliangzhouqi','_on'=>'mis_auto_zaprtmis_auto_zaprt_sub_zhibiaonarong.id=mis_auto_zaprt_sub_zhibiaonarongmis_auto_zaprt_sub_zhibiaonarong.masid'),
);
}
?>