<?php
class MisExpertQuestionVoteModel extends CommonModel {
    protected $trueTableName = 'mis_expert_question_vote';

    public $_auto	=array(
    		array('createid','getMemberId',self::MODEL_INSERT,'callback'),
    		array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
    		array('createtime','time',self::MODEL_INSERT,'function'),
    		array('updatetime','time',self::MODEL_UPDATE,'function'),
    	    array('companyid','getCompanyID',self::MODEL_INSERT,'callback'),
    		array('departmentid','getDeptID',self::MODEL_INSERT,'callback'),
    );
    
    public $_validate=array();
}
?>