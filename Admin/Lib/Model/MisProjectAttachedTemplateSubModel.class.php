<?php
/**
 * @Title: MisAttachedTemplateModel 
 * @Package package_name 
 * @Description: todo(项目附件模板子项模型) 
 * @author wangzhaoxia 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-11-06 下午5:27:13 
 * @version V1.0
 */
class MisProjectAttachedTemplateSubModel extends CommonModel {
	protected $trueTableName = 'mis_project_attached_template_sub';
	
	public $_validate	=	array(
	);

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