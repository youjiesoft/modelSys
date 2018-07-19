<?php
/**
 * @Title: MisFinanceExpensesMasModel
 * @Package 财务模块-费用报销单：模型类
 * @Description: TODO(费用单的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceExpensesMasModel extends CommonModel {
	protected $trueTableName = 'mis_finance_expenses_mas';
	public $_validate=array(
		array('orderno,status','','费用单号已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_BOTH),
		array('orderno','require','费用单号必须'),
	);
	public $_auto	=array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array('handledate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('amount','numberToReplace',self::MODEL_INSERT,'callback'),
		array('grossamount','numberToReplace',self::MODEL_INSERT,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	/* protected function insertStrtotime($time){
		if(isset($time)){
			return strtotime($time);
		}else{
			return false;
		}
	} */
}
?>