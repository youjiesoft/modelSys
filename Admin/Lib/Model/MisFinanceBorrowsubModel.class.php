<?php
//Version 1.0
/**
 * @Title: MisFinanceBorrowsubModel
 * @Package 财务模块-借款申请单明细：模型类
 * @Description: TODO(借款申请单明细的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceBorrowsubModel extends CommonModel{
	protected  $trueTableName = 'mis_finance_borrowsub';
	//自动填充设置
	public $_auto	=array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array('apamount','numberToReplace',self::MODEL_BOTH,'callback'),
		array('avamount','numberToReplace',self::MODEL_BOTH,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	
}
?>