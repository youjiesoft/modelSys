<?php
/**
 * @Title: MisSalesBusinessModel
 * @Package package_name
 * @Description: todo(动态表单_自动生成-商机)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-25 11:38:14
 * @version V1.0
*/
class MisSaleMyBusinessModel extends CommonModel {
	protected $trueTableName = 'mis_sale_business';
	public $_auto =array(
		array("createid","getMemberId",self::MODEL_INSERT,"callback"),
		array("updateid","getMemberId",self::MODEL_UPDATE,"callback"),
		array("createtime","time",self::MODEL_INSERT,"function"),
		array("updatetime","time",self::MODEL_UPDATE,"function"),
		array('acquiretime','strtotime',self::MODEL_BOTH,'function'),
		array('endtime','strtotime',self::MODEL_BOTH,'function'),
		array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
		array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
		array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
		array('kehujichuxinyonglian','unitExchange',self::MODEL_BOTH,'callback',array('mm','mm',1)),
		array('kehujichuxinyonglian','setnull',self::MODEL_BOTH,'callback'),
		array('pifujine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('pifujine','setnull',self::MODEL_BOTH,'callback'),
		array('pifuqixian','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
		array('fangkuanjine','unitExchange',self::MODEL_BOTH,'callback',array('yuan','wan',1)),
		array('fangkuanjine','setnull',self::MODEL_BOTH,'callback'),
		array('fangkuanqixian','unitExchange',self::MODEL_BOTH,'callback',array('months','months',1)),
	);
}
?>