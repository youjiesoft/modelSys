<?php
/**
 * @Title: MisSalesBusinessModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-商机)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-25 14:30:58
 * @version V1.0
*/
class MisSaleBusinessAllotModel extends CommonModel {
	protected $trueTableName = 'mis_sale_business_allot';
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("updateid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array('endtime','strtotime',self::MODEL_BOTH,'function'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>