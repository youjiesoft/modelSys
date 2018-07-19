<?php
/**
 * @Title: MisFinanceBorrowmasModel
 * @Package 商机审批：模型类
 * @Description: TODO(借款申请的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisSaleBusinessCheckViewModel extends ViewModel {
	public $viewFields = array(
			"mis_sale_business_check"=>array('_as'=>'mis_sale_business_check','id','bid','orderno','upload','useexplain','status','apdate','createid','createtime','auditState','_type'=>'LEFT'),
			"mis_sale_business"=>array('_as'=>'mis_sale_business','id'=>'bsid','clientname'=>'clientname','controller'=>'controller','mobile'=>'mobile','sourceid'=>'sourceid','intentiontypesid'=>'intentiontypesid','areaid'=>'areaid','customertypeid'=>'customertypeid','professionid'=>'professionid','industryid'=>'industryid','address'=>'address','linkman'=>'linkman','acquiretime'=>'acquiretime','endtime'=>'endtime','provider'=>'provider','name'=>'name','toolid'=>'toolid','orderno'=>'bsorderno','businessstatus'=>'businessstatus','_on'=>'mis_sale_business_check.bid=mis_sale_business.id'),
	);
	
}
?>