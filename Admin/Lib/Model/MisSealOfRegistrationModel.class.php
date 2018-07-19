<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(用一句话描述该文件做什么) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-4-29 下午6:20:47 
 * @version V1.0
 */
class MisSealOfRegistrationModel extends CommonModel {
	protected $trueTableName = 'mis_seal_of_registration';
	//自动填充
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
