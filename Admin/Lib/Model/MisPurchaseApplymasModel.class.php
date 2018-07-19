<?php
/**
 * @Title: MisPurchaseApplymasModel
 * @Package package_name
 * @Description: todo(采购申请模型)
 * @author liminggang
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2012-1-14 上午9:44:39
 * @version V1.0
 */
class MisPurchaseApplymasModel extends CommonModel{
	protected  $trueTableName = 'mis_purchase_applymas';
	public $_validate	=	array(
			array('orderno,status','','此订单编号已经存在！',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
	);

	//自动填充设置
	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array('apdate','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('dmsdate','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('dmedate','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('grossamount','numberToReplace',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}