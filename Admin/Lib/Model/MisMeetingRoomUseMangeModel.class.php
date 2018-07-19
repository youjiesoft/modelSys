<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(会议室使用申请管理模块) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-12 下午3:26:48 
 * @version V1.0
 */
class MisMeetingRoomUseMangeModel extends CommonModel{
	protected $trueTableName = 'mis_meeting_user_mange';
	public $_auto =	array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			
			array('meetingtime','dateToTimeString',self::MODEL_BOTH,'callback'),
			
			array('estimatedStrtime','dateToTimeString',self::MODEL_BOTH,'callback'),
			
			array('estimatedEndtime','dateToTimeString',self::MODEL_BOTH,'callback'),
			
			array('applicationdate','dateToTimeString',self::MODEL_BOTH,'callback'),
			
			array('amount','numberToReplace',self::MODEL_BOTH,'callback'),
			
			array('prepaid','numberToReplace',self::MODEL_BOTH,'callback'),
			
			array('unpaid','numberToReplace',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
	);
}