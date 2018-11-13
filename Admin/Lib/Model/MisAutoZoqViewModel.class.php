<?php
/**
 * @Title: MisAutoZoqModelView
 * @Package package_name
 * @Description: todo(动态表单_自动生成-外部评审表决单)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2016-08-24 11:08:06
 * @version V1.0
*/
class MisAutoZoqViewModel extends ViewModel {
			
	function __construct(){
		parent::__construct();
		$arr = getModelFilterByNodeSetting();
		if(is_array($arr)){
			$this->_filter = $arr;
		}
	}
	// 字段权限过滤
	protected $_filter = array();
		public $viewFields = array(
	'mis_auto_njzcw'=>array('id','pingshenweiyuanleixi','fandanbaocuoshishifu','shifushoufei','pinggufeiyong','pingshenyijian','jianyijine','jianyidanbaolv','jianyiqixian','jianyi','kehumingchen','xiangmumingchen','xiangmubianma','zijinyongtu','yewuleixing','fengxiandingjialiyou','fengxiandingjiayijia','shenqingjine','shenqingqixian','shouqubaozhengjinbil','pingshenhuiid','zhaojidanid','zhaojidansubid','shifunabu','pingshenhuileixing','expertid','userid','shifoujieshu','biaojueren','jiekuanzhuti','jiekuanzhuti','shifuzhuanjia','biaojueriqi','jianyiweidaifeilv','xiangmuxinxina','xiangmuxinxiwai','danbaojiekuanleixing','rugubili','peiyumubiao','zhitoujine','shanghuishunxu','jianyizongjine','zhitouqixian','zhudiao','fengkongrenyuan','baozhengjinjianmianl','yixiangdanbaofeilv','shifuduixiangmurenyu','touzirennianhuashouy','yewurenyuanyijian','yewurenyuanjianyijie','yewurenyuanjianyijier','yewurenyuanjianyizhi','yewurenyuanjianyizhiy','yewurenyuanjianyizon','fengkongrenyuanyijia','fengkongrenyuanjiany','fengkongrenyuanjianye','fengkongrenyuanjianyg','fengkongrenyuanjianyi','fengkongrenyuanjianyk','kehujichuxinyonglian','chanpinleixing','jijianfuwufeilv','shifusanchanronghexi','bindid','orderno','status','companyid','createid','createtime','updateid','updatetime','operateid','departmentid','projectid','projectworkid','sysdutyid','relationmodelname','auditUser','ptmptid','flowid','ostatus','auditState','curAuditUser','curNodeUser','alreadyAuditUser','alreadyauditnode','allnode','informpersonid','parentid','name','_type'=>'LEFT'),
);
}
?>