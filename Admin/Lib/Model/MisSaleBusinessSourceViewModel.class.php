<?php
/**
 * @Title: MisSaleBusinessSourceModelView
 * @Package package_name
 * @Description: todo(动态表单_自动生成-商机来源)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2015-08-15 13:01:16
 * @version V1.0
*/
class MisSaleBusinessSourceViewModel extends ViewModel {
			
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
	'mis_sale_business_source'=>array('id','remark','youxiaotianshu','bindid','orderno','status','companyid','createid','createtime','updateid','updatetime','operateid','departmentid','projectid','projectworkid','sysdutyid','relationmodelname','ptmptid','flowid','ostatus','auditState','curAuditUser','curNodeUser','alreadyAuditUser','alreadyauditnode','auditUser','allnode','informpersonid','parentid','name','_type'=>'LEFT'),
);
}
?>