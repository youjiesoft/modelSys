<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(客户服务跟踪信息模型) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-7-24 下午5:12:10 
 * @version V1.0
 */
class MisSalesCustomerTrackModel extends CommonModel {
	protected $trueTableName = 'mis_sales_customer_track';
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("updateid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
			
		array("needmoney","numberToReplace",self::MODEL_BOTH,"callback"),
			
		array("firstcontacttime","dateToTimeString",self::MODEL_BOTH,"callback"),
		array("serverinfo","dateToTimeString",self::MODEL_BOTH,"callback"),
			
		array("txdata","dateToTimeString",self::MODEL_BOTH,"callback"),
		array("lendtime","dateToTimeString",self::MODEL_BOTH,"callback"),
		array('enterpriseserve','implodFeld',self::MODEL_BOTH,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>