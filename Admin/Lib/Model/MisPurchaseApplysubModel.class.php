<?php
//Version 1.0
class MisPurchaseApplysubModel extends CommonModel{
	protected  $trueTableName = 'mis_purchase_applysub';
	//自动填充设置
   public $_auto	=array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
   		array('apdate','dateToTimeString',self::MODEL_BOTH,'callback'),
   		array('dmdate','dateToTimeString',self::MODEL_BOTH,'callback'),
   	    array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
   		array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),

	);
}