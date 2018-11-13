<?php
/**
 * @Title: MisAutoJtmModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-评审会类型)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-02-11 09:53:07
 * @version V1.0
*/
class MisAutoJtmModel extends MisAutoJtmExtendModel {
	protected $trueTableName = 'mis_auto_fwvvg';		
	// 字段权限过滤
	protected $_filter = array();
	
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("updateid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	public $_validate=array(
		array('orderno,status','','单号已经存在',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
		array('orderno','require','单号必须'),
	);
}
?>