<?php
class MisCarTiresModel extends CommonModel {
	protected $trueTableName = 'mis_car_tires';
	public $_validate=array(
		array('carid','require','车辆名必须'),
		array('position','require','轮胎位置必须'),
		array('brand','require','品牌型号必须'),
		array('unit','require','单价必须'),
	);
	/*
	 * 自动填充
	 */
	public $_auto		=	array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array('change_time','time',self::MODEL_BOTH,'function'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),

	);
}
?>