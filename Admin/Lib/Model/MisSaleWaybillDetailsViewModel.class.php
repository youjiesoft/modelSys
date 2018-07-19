<?php
/**
 * @Title: MisSaleWaybillDetailsView
 * @Package package_name
 * @Description: 运单详情
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-25 14:30:58
 * @version V1.0
*/
class MisSaleWaybillDetailsViewModel extends ViewModel {
	public $viewFields = array(
			"mis_auto_jvvzx"=>array('_as'=>'mis_auto_jvvzx','id','yunshugongsi','jiashiyuan','cheliangbianhao','huoyuandanhao','huowumingcheng','huowushuliang','huowudanwei','yunshudanjia','shuilv','baoxianfeilv','yunshuzongjia','beizhu','baoxiandanhao','yunshuluxian','shifadian','mudedi','chufashijian','daodashijian','ordertype','userid','shouhuoren','lianxidianhua','appshifadian','appshifadian','appmudedi','chechang','zaizhong','chexing','orderno','dangqianweizhi','status'=>'status','_type'=>'LEFT'),
			"mis_auto_tibjx"=>array('_as'=>'mis_auto_tibjx','id'=>'tid','shifadian'=>'tshifadian','chufashijian'=>'tchufashijian','mudedi'=>'tmudedi','daodashijian'=>'tdaodashijian','huowumingcheng'=>'thuowumingcheng','huowushuliang'=>'thuowushuliang','huowudanwei'=>'thuowudanwei','chexing'=>'tchexing','huowuxiangqing'=>'thuowuxiangqing','yunshuluxian'=>'tyunshuluxian','chechang'=>'tchechang','zaizhong'=>'tzaizhong','zongshuliang'=>'tzongshuliang','appshifadian'=>'tappshifadian','appmudedi'=>'tappmudedi','hzid'=>'thzid','ordertype'=>'tordertype','shouhuoren'=>'tshouhuoren','lianxidianhua'=>'tlianxidianhua','orderno'=>'torderno','createid','_on'=>'mis_auto_tibjx.orderno=mis_auto_jvvzx.huoyuandanhao'),
			);
}
?>