<?php
/**
 * @Title: MisSalesCustomerViewModel 
 * @Package package_name
 * @Description: todo(客户信息银行账户视图) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-9-17 下午2:27:41 
 * @version V1.0
 */
class MisSalesCustomerViewModel extends ViewModel {
	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	); 
	public $viewFields = array(
			"mis_sales_customer"=>array('_as'=>'mis_sales_customer','id','intype','jperson','typeid','usecredit','linkman','linktel','userid','typeid','code','name','taxno','caddr','tel','bankname','bank','status','_type'=>'LEFT'),
			"user"=>array('_as'=>'user','id'=>'userid','name'=>'username','_on'=>'user.id=mis_sales_customer.userid','_type'=>'LEFT'),
	);
}
?>