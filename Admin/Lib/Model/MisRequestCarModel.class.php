<?php
class MisRequestCarModel extends CommonModel {
	protected $trueTableName = 'mis_request_car';
	public $_validate=array(
		array('applyUserID','require','申请人必须'),
		array('departmentID','require','申请部门必须'),
		array('departurePlace','require','出发地必须'),
		array('arrivePlace','require','目的地必须'),
	);
	
	/*
	 * 自动填充
	 */
	public $_auto		=	array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		
		array('departureTime','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('planReturnTime','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('expectRestitutionTime','dateToTimeString',self::MODEL_BOTH,'callback'),
		
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('orderdate','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
	

}
?>