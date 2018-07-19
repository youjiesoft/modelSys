<?php
/**
 * @Title: MisSaleCommunicateLogModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-沟通记录)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-29 15:14:07
 * @version V1.0
*/
class MisSaleCommunicateLogModel extends CommonModel {
	protected $trueTableName = 'mis_sale_communicate_log';
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("createid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array('linktime','strtotime',self::MODEL_BOTH,'function'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>