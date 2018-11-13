<?php
/**
 * @Title: MisAutoMrtModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-专家评审会申请)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2016-09-23 14:11:25
 * @version V1.0
*/
class MisAutoMrtModel extends MisAutoMrtExtendModel {
	protected $trueTableName = 'mis_auto_sdkln';		
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
		array('shenqingqixian','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('shenqingqixian','setnull',self::MODEL_BOTH,'callback'),
		array('jianyidanbaofeilv','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyijin','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('yewurenyuanjianyijin','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyiqix','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('yewurenyuanjianyiqix','setnull',self::MODEL_BOTH,'callback'),
		array('yewubujianyijine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('yewubujianyijine','setnull',self::MODEL_BOTH,'callback'),
		array('yewubujianyiqixian','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('yewubujianyiqixian','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjiany','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('fengkongrenyuanjiany','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyf','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('fengkongrenyuanjianyf','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongbujianyijine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('fengkongbujianyijine','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongbujianyiqixi','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('fengkongbujianyiqixi','setnull',self::MODEL_BOTH,'callback'),
		array('pingshenjine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('pingshenjine','setnull',self::MODEL_BOTH,'callback'),
		array('pingshenqixian','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('baozhengjinlv','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('baozhengjinlv','setnull',self::MODEL_BOTH,'callback'),
		array('danbaofeilv','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('danbaofeilv','setnull',self::MODEL_BOTH,'callback'),
		array('weidaifeilv','unitExchange',self::MODEL_BOTH,'callback',array('bfz','bfz',1)),
		array('weidaifeilv','setnull',self::MODEL_BOTH,'callback'),
		array('jiekuanzhuti','setnull',self::MODEL_BOTH,'callback'),
		array('shanghuishijian','strtotime',self::MODEL_BOTH,'function'),
		array('shanghuishijian','setnull',self::MODEL_BOTH,'callback'),
		array('baozhengjinjianmianl','setnull',self::MODEL_BOTH,'callback'),
		array('yixiangdanbaofeilv','setnull',self::MODEL_BOTH,'callback'),
		array('touzirennianhuashouy','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('touzirennianhuashouy','setnull',self::MODEL_BOTH,'callback'),
		array('kehujichuxinyonglian','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyijie','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyijiet','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyq','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyn','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyizhi','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyizhib','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyfg','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyk','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyizon','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyr','setnull',self::MODEL_BOTH,'callback'),
		array('jijianfuwufeilv','setnull',self::MODEL_BOTH,'callback'),
	);
	public $_validate=array(
		array('orderno,status','','单号已经存在',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
		array('orderno','require','单号必须'),
	);
}
?>