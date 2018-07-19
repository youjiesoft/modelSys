<?php
/**
 * @Title: MisOfficialdocumentOutModel 
 * @Package package_name
 * @Description: todo(公文-发文核稿) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-11-14 下午2:32:48 
 * @version V1.0
 */
class MisOfficialdocumentOutAuditModel extends CommonModel {
	protected $trueTableName = 'mis_officialdocument_out';
	/*
	 * 自动填充
	*/
	public $_auto		=	array(
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