<?php
class MisComputerUserModel extends CommonModel {
	protected $trueTableName = 'mis_computer_user';

	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	
	public $_validate=array(
		array('code_number','','编号已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_BOTH),
		array('code_number','require','编号必须'),
		array('employe_id','require','用户名必须'),
		array('department_id','require','部门必须'),
	);
}
?>