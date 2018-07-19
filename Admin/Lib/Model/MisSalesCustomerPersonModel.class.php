<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(用一句话描述该文件做什么) 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-7-23 下午4:58:01 
 * @version V1.0
 */
class MisSalesCustomerPersonModel extends CommonModel {
	protected $trueTableName = 'mis_sales_customer_person';
	
	/*
	 * 自动填充
	*/
	public $_auto		=	array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
	
			array('firstcontacttime','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('serverinfo','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('lendtime','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('txdata','dateToTimeString',self::MODEL_BOTH,'callback'),
			
			//array('debt','numberToReplace',self::MODEL_BOTH,'callback'),
			//array('assets','numberToReplace',self::MODEL_BOTH,'callback'),
			array('income','numberToReplace',self::MODEL_BOTH,'callback'),
			array('needmoney','numberToReplace',self::MODEL_BOTH,'callback'),
			array('lendamount','numberToReplace',self::MODEL_BOTH,'callback'),
			
			array('enterpriseserve','implodFeld',self::MODEL_BOTH,'callback'),
			
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('orderdate','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>