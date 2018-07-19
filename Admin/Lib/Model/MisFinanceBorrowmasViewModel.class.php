<?php
/**
 * @Title: MisFinanceBorrowmasViewModel
 * @Package package_name
 * @Description: todo(借款申请视图模型)
 * @author yangxi
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2012-1-21 上午11:06:05
 * @version V1.0
 */
class MisFinanceBorrowmasViewModel extends ViewModel{

	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
		    array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
			array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),
	);
	
	//物料视图
	public $viewFields = array(
		'mis_finance_borrowmas' => array('_as'=>'mis_finance_borrowmas','id','orderno','apdate','dmdate','typeid','projectid','apamount','avamount','residual','userid','deptid','paymethodid','status','auditState','_type'=>'LEFT'),
		'mis_finance_borrow_collection'=>array('_as'=>'mis_finance_borrow_collection','waitamountsum','apamountsum','avamountsum','residualsum','_on'=>'mis_finance_borrowmas.referid=mis_finance_borrow_collection.id'),
	);
}
?>