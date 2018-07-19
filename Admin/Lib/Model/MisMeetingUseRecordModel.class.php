<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(会议使用记录) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-17 下午4:00:34 
 * @version V1.0
 */
class MisMeetingUseRecordModel extends CommonModel {
	protected $trueTableName = 'mis_meeting_use_record';
	/*
	 * 自动填充
	*/
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
?>