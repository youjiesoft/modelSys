<?php
//Version 1.0
class MisSalesCustomerModel extends CommonModel{
	protected $trueTableName = 'mis_sales_customer';

	public $_auto	=array(
			array('createid','getMemberId',self::MODEL_INSERT,'callback'),
			array('updateid','getMemberId',self::MODEL_UPDATE,'callback'),
			array('createtime','time',self::MODEL_INSERT,'function'),
			array('updatetime','time',self::MODEL_UPDATE,'function'),
			array('registertime','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('firstcontacttime','dateToTimeString',self::MODEL_BOTH,'callback'),
			array('registermoney','numberToReplace',self::MODEL_BOTH,'callback'),
			array('needmoney','numberToReplace',self::MODEL_BOTH,'callback'),
			array("companyid","getCompanyID",self::MODEL_INSERT,"callback"),
			array("departmentid","getDeptID",self::MODEL_INSERT,"callback"),
			array('sysdutyid','getDutyID',self::MODEL_INSERT,'callback'),
			
	);
	
	public function getDepartTree(){
        $category = array();
        import("@.ORG.Tree"); //include('Tree.class.php');
        $Tree = new Tree();
        $category=$this->field(array('id','cup','name'))->select();
        foreach($category as $key=>$val){
            $Tree->setNode($val['id'], $val['cup'], $val['name']);
        }
        $category = $Tree->getChilds();
        //遍历输出
        foreach ($category as $key=>$id)
        {
            echo $id.$Tree->getLayer($id).$Tree->getValue($id)."<br>";
        }
        return json_encode($category);
        exit;
    }
    public $_validate=array(
       	array('code,status,typeid','','客户编号已存在！',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
        array('name,status,typeid','','客户名称已存在！',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
        array('code,name,status,typeid','','客户编码名称组合已存在！',self::MUST_VALIDATE,'unique',self::MODEL_BOTH),
    );
}
?>