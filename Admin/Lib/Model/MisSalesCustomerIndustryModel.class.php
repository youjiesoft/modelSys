<?php
/** 
 * @Title: MisSalesCustomerIndustryModel 
 * @Package package_name
 * @Description: todo(客户行业模型) 
 * @author 杨东 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-16 下午5:12:35 
 * @version V1.0 
*/ 
class MisSalesCustomerIndustryModel extends CommonModel{
   	protected $trueTableName = 'mis_sales_customer_industry';
	public $_auto	=array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	 public $_validate	=	array(
        array('code,status','','编码重复，请检查！',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),//多字段组合验证
     );
}
?>