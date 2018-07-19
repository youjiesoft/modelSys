<?php
/**
 * @Title: MisCarTrafficAccidentModel 
 * @Package package_name
 * @Description: todo(用一句话描述该类的作用) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-7 下午5:56:51 
 * @version V1.0
 */
class MisCarTrafficAccidentModel extends CommonModel {
	protected $trueTableName = 'mis_car_traffic_accident';
	/*
	 * 自动填充
	 */
	public $_auto		=	array(
		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		array('accidentdate','dateToTimeString',self::MODEL_BOTH,'callback'),
		array('directeconomic','numberToReplace',self::MODEL_BOTH,'callback'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}
?>