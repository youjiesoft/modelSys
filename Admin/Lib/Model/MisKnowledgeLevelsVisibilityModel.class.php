<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(文章等级管理配置) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-30 上午11:57:29 
 * @version V1.0
 */
class MisKnowledgeLevelsVisibilityModel extends CommonModel {
	protected $trueTableName = 'mis_knowledge_levels_visibility';
	public $_auto =array(
			array("createid","getMemberId",self::MODEL_INSERT,"callback"),
			array("createid","getMemberId",self::MODEL_UPDATE,"callback"),
			array("createtime","time",self::MODEL_INSERT,"function"),
			array("updatetime","time",self::MODEL_UPDATE,"function"),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
			);
}