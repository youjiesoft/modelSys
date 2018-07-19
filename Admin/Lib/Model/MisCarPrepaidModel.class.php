<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(油卡充值管理模型) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-17 下午4:18:51 
 * @version V1.0
 */
class MisCarPrepaidModel extends CommonModel {
	protected $trueTableName = 'mis_car_add_oil_info';
	/*
	 * 自动填充
	*/
	public $_auto		=	array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			
			array('amount','numberToReplace',self::MODEL_BOTH,'callback'),
			array('oil_balance','numberToReplace',self::MODEL_BOTH,'callback'),
			array('add_time','dateToTimeString',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>