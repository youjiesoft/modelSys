<?php
class MisComputerModel extends CommonModel {
	protected $trueTableName = 'mis_computer';
	public $_validate=array(
		array('name','require','计算机名称必须'),
		array('type','require','类型必须'),
		array('detail','require','配制信息必须'),
		array('department_id','require','使用部门必须'),
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
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>