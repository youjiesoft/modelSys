<?php 
/**
 * @Title: MisSalesMyProjectModel 
 * @Package package_name
 * @Description: (我的项目管理模型) 
 * @author 黎明刚
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014年11月15日 下午2:19:56 
 * @version V1.0
 */
class MisSalesMyProjectModel extends CommonModel{
	protected  $trueTableName = 'mis_auto_kimpu';
	
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("updateid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
		array('projectstatus','setnull',self::MODEL_BOTH,'callback'),
		array('projectcode','setDefaultVal',self::MODEL_BOTH,'callback'),
		array('canzhaoprojectcode','setDefaultVal',self::MODEL_BOTH,'callback'),
		array('zd','setnull',self::MODEL_BOTH,'callback'),
		array('zddeptid','setnull',self::MODEL_BOTH,'callback'),
		array('fd','setnull',self::MODEL_BOTH,'callback'),
		array('shenqingqixian','unitExchange',self::MODEL_BOTH,'callback',array('month','month',1)),
		array('shenqingqixian','setnull',self::MODEL_BOTH,'callback'),
		array('shenqingjine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('shenqingjine','setnull',self::MODEL_BOTH,'callback'),
		array('prolineorderno','implodFeld',self::MODEL_BOTH,'callback'),
		array('shifuzidongfenpei','implodFeld',self::MODEL_BOTH,'callback'),
		array('deptjinli','implodFeld',self::MODEL_BOTH,'callback'),
		array('suoshujiaose','implodFeld',self::MODEL_BOTH,'callback'),
		array('jianyirenyuan','implodFeld',self::MODEL_BOTH,'callback'),
	);
	public $_validate=array(
		array('orderno,status','','单号已经存在',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
		array('orderno','require','单号必须'),
	);
}
?>