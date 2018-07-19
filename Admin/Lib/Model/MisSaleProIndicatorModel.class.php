<?php
class MisSaleProIndicatorModel extends commonModel{
	protected $trueTableName = 'mis_sale_chain_indicator';
	public $_auto =array(
			array("createid","getMemberId",self::MODEL_INSERT,"callback"),
			array("createid","getMemberId",self::MODEL_UPDATE,"callback"),
			array("createtime","time",self::MODEL_INSERT,"function"),
			array("updatetime","time",self::MODEL_UPDATE,"function"),
			array('endtime','strtotime',self::MODEL_BOTH,'function'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}