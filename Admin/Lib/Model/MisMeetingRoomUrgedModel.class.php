<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(会议信息管理----会议物品配置信息) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-15 下午10:50:17 
 * @version V1.0
 */
class MisMeetingRoomUrgedModel extends CommonModel{
	protected $trueTableName = 'mis_meeting_room_urged';
	public $_auto =	array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}