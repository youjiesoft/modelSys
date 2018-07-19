<?php
class MisLogisticsFixLogModel extends CommonModel {
	protected $trueTableName = 'mis_logistics_fix_log';
	public $_validate=array(
		array('name','require','设备名称必须'),
		array('fix_man','require','检修人必须'),
		array('fault_cause','require','故障描述必须'),
		array('fixed','require','结果必须'),
		array('falut_type','require','故障类型必须'),
	);
	/*
	 * 自动填充
	 */
	public $_auto		=	array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array('fix_time','dateToTimeString',self::MODEL_BOTH,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>