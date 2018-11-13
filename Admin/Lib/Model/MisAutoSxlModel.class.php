<?php
/**
 * @Title: MisAutoSxlModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-保后表决单)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2016-03-03 14:28:34
 * @version V1.0
*/
class MisAutoSxlModel extends MisAutoSxlExtendModel {
	protected $trueTableName = 'mis_auto_sxlpg';		
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
		array('shenqingjine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('shenqingjine','setnull',self::MODEL_BOTH,'callback'),
		array('shenqingqixian','unitExchange',self::MODEL_BOTH,'callback',array('month','month',1)),
		array('shenqingqixian','setnull',self::MODEL_BOTH,'callback'),
		array('jianyijine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('jianyijine','setnull',self::MODEL_BOTH,'callback'),
		array('yixiangdanbaofeilv','setnull',self::MODEL_BOTH,'callback'),
		array('baozhengjinjianmianl','setnull',self::MODEL_BOTH,'callback'),
		array('jianyiqixian','unitExchange',self::MODEL_BOTH,'callback',array('month','month',1)),
		array('jianyiqixian','setnull',self::MODEL_BOTH,'callback'),
		array('pingshenhuiid','setnull',self::MODEL_BOTH,'callback'),
		array('zhaojidanid','setnull',self::MODEL_BOTH,'callback'),
		array('pingshenhuileixing','setnull',self::MODEL_BOTH,'callback'),
		array('zhaojidansubid','setnull',self::MODEL_BOTH,'callback'),
		array('biaojueriqi','strtotime',self::MODEL_BOTH,'function'),
		array('biaojueriqi','setnull',self::MODEL_BOTH,'callback'),
		array('shanghuishunxu','setnull',self::MODEL_BOTH,'callback'),
	);
	public $_validate=array(
		array('orderno,status','','单号已经存在',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
		array('orderno','require','单号必须'),
	);
}
?>