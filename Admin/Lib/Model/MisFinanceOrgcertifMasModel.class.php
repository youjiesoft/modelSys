<?php
/**
 * @Title: MisFinanceOrgcertifMasModel
 * @Package 财务模块-支出证明（原始凭证）：模型类
 * @Description: TODO(支出证明（原始凭证）的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisFinanceOrgcertifMasModel extends CommonModel {
	protected $trueTableName = 'mis_finance_orgcertif_mas';
	
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("createid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array('handledate','dateToTimeString',self::MODEL_BOTH,'callback'),
			
		array('advance','numberToReplace',self::MODEL_BOTH,'callback'),
		array('balamount','numberToReplace',self::MODEL_BOTH,'callback'),
		array('attachmentsum','numberToReplace',self::MODEL_BOTH,'callback'),
		array('invoamount','numberToReplace',self::MODEL_BOTH,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>