<?php
/**
 * @Title: ProcessRoleModel 
 * @Package package_name 
 * @Description: todo(流程角色管理) 
 * @author laicaixia 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-4-2 下午3:17:34 
 * @version V1.0
 */
class ProcessRoleModel extends CommonModel {
    protected $trueTableName = 'process_role';
    
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