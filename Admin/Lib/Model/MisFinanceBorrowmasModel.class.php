<?php
/**
 * @Title: MisFinanceBorrowmasModel
 * @Package 财务模块-借款款申请：模型类
 * @Description: TODO(借款申请的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceBorrowmasModel extends CommonModel {
	protected $trueTableName = 'mis_finance_borrowmas';
	public $_validate=array(
		array('orderno,status','','借款申请单号已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_BOTH),
		array('orderno','require','借款申请单号必须'),
	);
	public $_auto	=array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		 array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
		array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),
	    array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array('apamount','numberToReplace',self::MODEL_BOTH,'callback'),
		array('avamount','numberToReplace',self::MODEL_BOTH,'callback'),
		array('residual','numberToReplace',self::MODEL_BOTH,'callback'),
		array('borrowmoney','numberToReplace',self::MODEL_BOTH,'callback'),
		array('apdate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('dmdate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('needtime','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('informpersonid','implodFeld',self::MODEL_BOTH,'callback'),
	);
	
}
?>