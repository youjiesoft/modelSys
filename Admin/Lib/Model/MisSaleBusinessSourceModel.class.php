<?php
/**
 * @Title: MisSaleBusinessSourceModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-商机来源)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2015-08-15 13:01:16
 * @version V1.0
*/
class MisSaleBusinessSourceModel extends MisSaleBusinessSourceExtendModel {
	protected $trueTableName = 'mis_sale_business_source';		
	// 字段权限过滤
	protected $_filter = array();
	
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("updateid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
		array('allnode','getActionName',self::MODEL_INSERT,'callback'),
		array('youxiaotianshu','unitExchange',self::MODEL_BOTH,'callback',array('days','days',1)),
		array('youxiaotianshu','setnull',self::MODEL_BOTH,'callback'),
	);
	public $_validate=array(
		array('orderno,status','','单号已经存在',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
		array('orderno','require','单号必须'),
	);
}
?>