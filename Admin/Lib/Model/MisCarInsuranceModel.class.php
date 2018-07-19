<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(车辆保险模型) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-17 下午3:19:04 
 * @version V1.0
 */
class MisCarInsuranceModel extends CommonModel {
	protected $trueTableName = 'mis_car_insurance';
	public $_validate=array(
			array('carid','require','车辆名必须'),
			array('compulsory','require','强制险必须'),
			array('buy_time','require','购买日期必须'),
			array('expire_time','require','到期日期必须'),
	);
	/*
	 * 自动填充
	*/
	public $_auto		=	array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array('buy_time','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('expire_time','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('business','numberToReplace',self::MODEL_BOTH,'callback'),
			array('compulsory','numberToReplace',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>