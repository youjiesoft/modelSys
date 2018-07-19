<?php
//Version 1.0
class MisFinanceRateModel extends CommonModel{
 protected $trueTableName = 'mis_finance_rate';
 public $_validate	=	array(
            array('crfrom,crto,convdate,status','','转换参数重复，请检查！',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),//多字段组合验证
    );
 public $_auto	=array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
 		array('convdate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>