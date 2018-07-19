<?php
class MisFinanceVoucherMasModel extends CommonModel {
	protected $trueTableName = 'mis_finance_voucher_mas';
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("createid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array('fdate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	
	public $_validate=array(
		array('fdate','require','凭证日期必须'),
		array('fyear','require','会计年度必须'),
		array('fperiod','require','会计期间必须'),
		array('atype','require','科目类型必须'),
		array('ftype','require','凭证字必须'),
		array('faccountnum','require','科目代码必须'),
		array('faccountname','require','科目名称必须'),
		array('currencycode','require','币种代码必须'),
		array('currencyname','require','币种名称必须'),
	);
}
?>