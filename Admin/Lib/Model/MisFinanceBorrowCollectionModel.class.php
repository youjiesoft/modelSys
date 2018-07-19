<?php
/**
 * @Title: MisFinanceBorrowCollectionModel
 * @Package 财务模块-借款汇总信息表：模型类
 * @Description: TODO(借款汇总信息统计的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-20 19:18:54
 * @version V1.0
*/
class MisFinanceBorrowCollectionModel extends CommonModel {
	protected $trueTableName = 'mis_finance_borrow_collection';

	public $_auto	=array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array('waitamountsum','numberToReplace',self::MODEL_INSERT,'callback'),
		array('apamountsum','numberToReplace',self::MODEL_INSERT,'callback'),
		array('avamountsum','numberToReplace',self::MODEL_INSERT,'callback'),
		array('residualsum','numberToReplace',self::MODEL_INSERT,'callback'),
	    array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
		array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),
	);
}
?>