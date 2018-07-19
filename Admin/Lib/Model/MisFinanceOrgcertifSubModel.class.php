<?php
/**
 * @Title: MisFinanceOrgcertifMasModel
 * @Package 财务模块-支出证明（原始凭证明细）：模型类
 * @Description: TODO(支出证明（原始凭证明细）的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceOrgcertifSubModel extends CommonModel {
	protected $trueTableName = 'mis_finance_orgcertif_sub';
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("createid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
	    array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
		array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),);
}
?>