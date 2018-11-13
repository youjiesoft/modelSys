<?php
/**
 * @Title: MisAutoSxlModelView
 * @Package package_name
 * @Description: todo(动态表单_自动生成-保后表决单)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2016-03-03 14:28:34
 * @version V1.0
*/
class MisAutoSxlViewModel extends ViewModel {
			
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
	'mis_auto_sxlpg'=>array('id','biaojueren','pingshenyijian','jianyijine','jianyiqixian','jianyi','xiangmubianma','kehumingchen','xiangmumingchen','zijinyongtu','yewuleixing','shenqingjine','shenqingqixian','pingshenhuiid','zhaojidanid','zhaojidansubid','pingshenhuileixing','expertid','userid','shifoujieshu','jianyifengxiandengji','dangqianfengxiandeng','biaojueriqi','baohouleixing','shifuhege','danbaojiekuanleixing','shanghuishunxu','baohouzhixingdanhao','yixiangdanbaofeilv','baozhengjinjianmianl','bindid','orderno','status','companyid','createid','createtime','updateid','updatetime','operateid','departmentid','projectid','projectworkid','sysdutyid','relationmodelname','auditUser','ptmptid','flowid','ostatus','auditState','curAuditUser','curNodeUser','alreadyAuditUser','alreadyauditnode','allnode','informpersonid','parentid','name','_type'=>'LEFT'),
);
}
?>