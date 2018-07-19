<?php
class MisKnowledgeListModel extends CommonModel {
	protected $trueTableName = 'mis_knowledge_list';
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("createid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),			
		);
	public $_validate=array(
		array('code','','标题已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_BOTH),
		array('code','require','标题必须'),
	    array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
		array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),
	);
}
?>