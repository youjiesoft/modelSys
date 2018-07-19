<?php
//Version 1.0
/**
 * @Title: MisFinanceCostCenterModel
 * @Package 财务模块-成本中心：功能类
 * @Description: TODO(成本中心分类的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceCostCenterModel extends CommonModel {
	protected $trueTableName = 'mis_finance_cost_center';
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