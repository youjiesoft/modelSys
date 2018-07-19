<?php
/**
 * @Title: file_name
 * @Package package_name
 * @Description: todo(还车记录模型)
 * @author liminggang
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-23 下午3:03:32
 * @version V1.0
 */
class MisCarReturnModel extends CommonModel {
	protected $trueTableName = 'mis_car_return';
	
	public $_validate=array(
			array('roid','require','申请单ID必须'),
			array('rtype','require','关联表类型必须'),
	);

	/*
	 * 自动填充
	*/
	public $_auto		=	array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			
			array('returnTime','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('totalKM','numberToReplace',self::MODEL_BOTH,'callback'),
			array('returnTime','numberToReplace',self::MODEL_BOTH,'callback'),
			array('runKM','numberToReplace',self::MODEL_BOTH,'callback'),
			array('addOilNo','numberToReplace',self::MODEL_BOTH,'callback'),
			array('oilBalance','numberToReplace',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
			
	);
}
?>