<?php
/**
 * @Title: MisFinanceCurrencyModel 
 * @Package package_name 
 * @Description: todo(币种代码模型) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2012-1-8 下午3:32:20 
 * @version V1.0
 */
class MisFinanceCurrencyModel extends CommonModel{
    //put your code here
    protected $trueTableName = 'mis_finance_currency';

    public $_validate	=	array(
            array('code,status','','编码重复，请检查！',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),//多字段组合验证
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