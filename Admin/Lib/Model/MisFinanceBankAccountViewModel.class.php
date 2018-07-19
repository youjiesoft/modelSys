<?php
/**
 * @Title: MisFinanceBankAccountViewModel 
 * @Package package_name
 * @Description: todo(客户信息开户银行账户视图) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-9-17 下午2:27:41 
 * @version V1.0
 */
class MisFinanceBankAccountViewModel extends ViewModel {

	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
		    array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
			array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),
	); 
	public $viewFields = array(
		"mis_finance_bank_account"=>array('_as'=>'mis_finance_bank_account','id'=>'accountid','code','name'=>'accountname','_type'=>'LEFT'),
		"mis_finance_bank"=>array('_as'=>'mis_finance_bank','id','sname','code'=>'bankcode','name','status','_on'=>'mis_finance_bank_account.bankid=mis_finance_bank.id','_type'=>'LEFT'),
	);
}
?>