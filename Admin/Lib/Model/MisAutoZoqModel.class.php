<?php
/**
 * @Title: MisAutoZoqModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-外部评审表决单)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2016-08-24 11:08:06
 * @version V1.0
*/
class MisAutoZoqModel extends MisAutoZoqExtendModel {
	protected $trueTableName = 'mis_auto_njzcw';		
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
		array('shenqingqixian','unitExchange',self::MODEL_BOTH,'callback',array('month','month',1)),
		array('yixiangdanbaofeilv','setnull',self::MODEL_BOTH,'callback'),
		array('kehujichuxinyonglian','unitExchange',self::MODEL_BOTH,'callback',array('mm','mm',1)),
		array('yewurenyuanjianyijie','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('yewurenyuanjianyijie','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyijier','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('yewurenyuanjianyijier','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyizhi','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('yewurenyuanjianyizhi','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyizhiy','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('yewurenyuanjianyizhiy','setnull',self::MODEL_BOTH,'callback'),
		array('yewurenyuanjianyizon','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('yewurenyuanjianyizon','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjiany','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('fengkongrenyuanjiany','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianye','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('fengkongrenyuanjianye','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyg','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('fengkongrenyuanjianyg','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyi','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('fengkongrenyuanjianyi','setnull',self::MODEL_BOTH,'callback'),
		array('fengkongrenyuanjianyk','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('fengkongrenyuanjianyk','setnull',self::MODEL_BOTH,'callback'),
		array('jianyijine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('jianyiqixian','unitExchange',self::MODEL_BOTH,'callback',array('month','month',1)),
		array('zhitoujine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('zhitouqixian','unitExchange',self::MODEL_BOTH,'callback',array('month','month',1)),
		array('rugubili','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('rugubili','setnull',self::MODEL_BOTH,'callback'),
		array('jianyizongjine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('jianyizongjine','setnull',self::MODEL_BOTH,'callback'),
		array('shouqubaozhengjinbil','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('jianyidanbaolv','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('jianyiweidaifeilv','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('jianyiweidaifeilv','setnull',self::MODEL_BOTH,'callback'),
		array('touzirennianhuashouy','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('touzirennianhuashouy','setnull',self::MODEL_BOTH,'callback'),
		array('jijianfuwufeilv','unitExchange',self::MODEL_BOTH,'callback',array('percent','percent',1)),
		array('jijianfuwufeilv','setnull',self::MODEL_BOTH,'callback'),
		array('pingshenhuiid','setnull',self::MODEL_BOTH,'callback'),
		array('zhaojidanid','setnull',self::MODEL_BOTH,'callback'),
		array('zhaojidansubid','setnull',self::MODEL_BOTH,'callback'),
		array('shifunabu','setnull',self::MODEL_BOTH,'callback'),
		array('pingshenhuileixing','setnull',self::MODEL_BOTH,'callback'),
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