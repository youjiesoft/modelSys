<?php
/**
 * @Title: MisAutoJtmModelView
 * @Package package_name
 * @Description: todo(动态表单_自动生成-评审会类型)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-02-11 09:53:07
 * @version V1.0
*/
class MisAutoJtmViewModel extends ViewModel {
			
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
	'mis_auto_fwvvg'=>array('id','duiyingmoban','shenqingmoban','huizongmoban','ptmptid','flowid','ostatus','auditState','curAuditUser','curNodeUser','alreadyAuditUser','alreadyauditnode','auditUser','allnode','informpersonid','bindid','name','orderno','status','companyid','createid','createtime','updateid','updatetime','operateid','departmentid','projectid','projectworkid','sysdutyid','_type'=>'LEFT'),
);
}
?>