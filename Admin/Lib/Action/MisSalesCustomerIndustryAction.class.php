<?php
/** 
 * @Title: MisSalesCustomerIndustryAction 
 * @Package package_name
 * @Description: todo(客户行业处理器) 
 * @author 杨东 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-16 下午5:10:37 
 * @version V1.0 
*/ 
class MisSalesCustomerIndustryAction extends CommonAction{
	/**
	 * @Title: _filter 
	 * @Description: todo(构造检索条件) 
	 * @param unknown_type $map  
	 * @author xiafengqin 
	 * @date 2013-6-1 下午2:42:43 
	 * @throws
	 */
	public function _filter(&$map){
	    if(empty($_REQUEST['status'])) {
		 if ($_SESSION["a"] != 1)$map['status']=array("gt",-1);
		}
	}
}
?>