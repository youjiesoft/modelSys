<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(车辆违章信息模型) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-17 下午3:41:03 
 * @version V1.0
 */
class MisCarTrafficPenaltyModel extends CommonModel {
	protected $trueTableName = 'mis_car_traffic_penalty';
	public $_validate=array(
			array('carid','require','车辆名必须'),
	);
	/*
	 * 自动填充
	*/
	public $_auto		=	array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array('get_time','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('penalty','numberToReplace',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>