<?php
/**
 * @Title: MisSalesBusinessModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-商机)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-25 14:30:58
 * @version V1.0
*/
class MisSaleMyBusinessViewModel extends ViewModel {
	public $viewFields = array(
			"mis_sale_business"=>array('_as'=>'mis_sale_business','id','clientname','controller','mobile','sourceid','intentiontypesid','areaid','customertypeid','professionid','industryid','address','linkman','acquiretime','days','endtime','userid','provider','name','toolid','orderno','bangongdianhua','zhucedizhi','chuanzhen','createid','status'=>'status','turncustomer','businessstatus','remark','xuqiushijian','xuanzeleixing','shixiao','jinronglianluozhan','shifunarudanbaofengx','kehujichuxinyonglian','kehujichuxinyongping','_type'=>'LEFT'),
			"mis_sale_business_allot"=>array('_as'=>'mis_sale_business_allot','bid','id'=>'allotid','userid'=>'allotuserid','endtime'=>'allotendtime','endstatus'=>'endstatus','turnstatus'=>'turnstatus','alloterid'=>'alloterid','zhuanpai','zhuanpairen','_on'=>'mis_sale_business_allot.bid=mis_sale_business.id'),
			);
}
?>