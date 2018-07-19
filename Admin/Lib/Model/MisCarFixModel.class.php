<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(车辆维修信息) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-15 下午4:45:03 
 * @version V1.0
 */
class MisCarFixModel extends CommonModel {
	protected $trueTableName = 'mis_car_fix';
	public $_validate=array(
		array('carid','require','车辆名必须'),
		array('content','require','维修内容必须'),
		array('number','require','数量必须'),
		array('unit','require','单位必须'),
		array('amount','require','金额必须'),
		array('price','require','单价必须'),
	);
	/*
	 * 自动填充
	 */
	public $_auto		=	array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array('recordsdate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('fixbegindate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('fixenddate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('fixamount','numberToReplace',self::MODEL_BOTH,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>