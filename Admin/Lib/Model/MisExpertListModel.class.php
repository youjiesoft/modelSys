<?php
class MisExpertListModel extends CommonModel {
    protected $trueTableName = 'mis_expert_list';
    public $_auto =	array(
            array('createid','getMemberId',self::MODEL_INSERT,'callback'),
            array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
            array('createtime','time',self::MODEL_INSERT,'function'),
            array('updatetime','time',self::MODEL_UPDATE,'function'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
    );
    public $_validate=array(
                   array('orderno,account','','编号已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_BOTH),
    				array('account','','账号已经存在',self::EXISTS_VAILIDATE,'unique',self::MODEL_BOTH),
    			  // array('account','','账号已经存在',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
                   array('orderno','require','编号必须'),
                   array('name','require','专家名称必须'),
             );
}
?>