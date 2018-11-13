<?php
/**
 * @Title: MisAutoZpgModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-表决)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-12-23 15:20:57
 * @version V1.0
*/
class MisAutoZpgModel extends MisAutoZpgExtendModel {
	protected $trueTableName = 'mis_auto_aaaak';
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("updateid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
		array('shenqingjine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('shenqingjine','setnull',self::MODEL_BOTH,'callback'),
		array('shenqingqixian','unitExchange',self::MODEL_BOTH,'callback',array('month','month',1)),
		array('shenqingqixian','setnull',self::MODEL_BOTH,'callback'),
		array('jianyijine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('jianyijine','setnull',self::MODEL_BOTH,'callback'),
		array('jianyiqixian','unitExchange',self::MODEL_BOTH,'callback',array('month','month',1)),
		array('jianyiqixian','setnull',self::MODEL_BOTH,'callback'),
		array('jianyidanbaolv','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('jianyidanbaolv','setnull',self::MODEL_BOTH,'callback'),
		array('pingshenhuiid','setnull',self::MODEL_BOTH,'callback'),
		array('zhaojidanid','setnull',self::MODEL_BOTH,'callback'),
		array('zhaojidansubid','setnull',self::MODEL_BOTH,'callback'),
	);
	public $_validate=array(
		array('orderno,status','','单号已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_BOTH),
		array('orderno','require','单号必须'),
	);
}
?>