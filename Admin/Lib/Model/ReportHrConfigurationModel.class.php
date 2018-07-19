<?php
/**
 * 
 * @Title: ReportHrConfigurationModel 
 * @Package package_name
 * @Description: todo(报表中心 人事配置) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-1-9 下午3:57:45 
 * @version V1.0
 */
class ReportHrConfigurationModel extends CommonModel {
	protected $trueTableName = 'mis_hr_report_configuration';
	public $_validate	=	array(
			array('endage','dataCompare',"年龄结束值应大于年龄开始值",self::VALUE_VAILIDATE,'callback',self::MODEL_BOTH,
					array('$_POST[startage]')
			),
	);
	/*
	 * 自动填充
	*/
	public $_auto		=array(
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