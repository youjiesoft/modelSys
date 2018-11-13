<?php
/**
 * @Title: MisAutoAiqModelView
 * @Package package_name
 * @Description: todo(动态表单_自动生成-评审模式)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-12-13 12:35:41
 * @version V1.0
*/
class MisAutoAiqViewModel extends ViewModel {
	public $viewFields = array(
	'mis_auto_svsxe'=>array('id','','','','ptmptid','flowid','ostatus','auditState','curAuditUser','curNodeUser','alreadyAuditUser','alreadyauditnode','auditUser','allnode','informpersonid','bindid','orderno','status','companyid','createid','createtime','updateid','updatetime','operateid','departmentid','projectid','projectworkid','sysdutyid','_type'=>'LEFT'),
);
}
?>