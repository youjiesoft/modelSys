<?php
class MisFinanceAmountTitleModel extends CommonModel {
	protected $trueTableName = 'mis_finance_amount_title';

	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
		    array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
			array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),
	);
	
	public $_validate=array(
		array('code','require','科目代码必须'),
		array('name','require','科目名称必须'),
		array('atype','require','科目类型必须'),
	);
}
?>