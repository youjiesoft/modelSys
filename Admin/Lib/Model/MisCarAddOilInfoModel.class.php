<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(加油管理) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-18 下午2:42:10 
 * @version V1.0
 */
class MisCarAddOilInfoModel extends CommonModel {
	
	protected $trueTableName = 'mis_car_add_oil_info';
	
	public $_validate=array(
			array('car_id','require','车辆信息必须'),
			array('oil_number','require','加油量必须'),
// 			array('address','require','加油地点必须'),
// 			array('persion','require','加油人必须'),
	);
	/*
	 * 自动填充
	*/
	public $_auto		=	array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array('totalKM','numberToReplace',self::MODEL_BOTH,'callback'),
			array('kilometre','numberToReplace',self::MODEL_BOTH,'callback'),
			array('oil_balance','numberToReplace',self::MODEL_BOTH,'callback'),
			array('amount','numberToReplace',self::MODEL_BOTH,'callback'),
			array('price','numberToReplace',self::MODEL_BOTH,'callback'),
			array('oil_number','numberToReplace',self::MODEL_BOTH,'callback'),
			array('add_time','dateToTimeString',self::MODEL_BOTH,'callback'), //dateTotTimeString 可以处理加了小时，分的时间转换问题
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),

	);
}
?>