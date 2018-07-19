<?php
class MisComputerFixLogModel extends CommonModel {
	protected $trueTableName = 'mis_computer_fix_log';

	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array('fix_time','dateToTimeString',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	
	public $_validate=array(
		array('department_id','require','部门必须'),
		//array('report_name','require','用户名必须'),
		array('computer_id','require','设备名称必须'),
		array('fault_cause','require','故障原因必须'),
		array('fixed','require','结果必须'),
		array('fix_time','require','日期必须'),
		array('falut_type','require','故障类型必须'),
	);
}
?>