<?php
//Version 1.0
/**
 * @Title: MisFinanceExpensesTypeModel
 * @Package 财务模块-费用分类：模型类
 * @Description: TODO(费用分类的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-16 19:18:54
 * @version V1.0
*/
class MisFinanceExpensesTypeModel extends CommonModel {
	protected $trueTableName = 'mis_finance_expenses_type';
	public $_validate	=	array(
		array('code,status','','编码已经存在',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
	);
	public $_auto	=array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>