<?php
class MisFinanceMarkLogModel extends CommonModel {
	//真实表名
	protected $trueTableName = 'mis_finance_mark_log';
	
	/** @Title: $_auto
	 * @Description: (自动插入)
	 * @author eagle
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array('log_time','dateToTimeString',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	
	/** @Title: $_validate
	 * @Description: (自动校验)
	 * @author liminggang
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */	
	public $_validate=array(
		array('department_id','require','部门必须'),
		array('name','require','经手人必须'),
		array('content','require','摘要必须'),
		array('log_time','require','日期必须'),
	);
}
?>