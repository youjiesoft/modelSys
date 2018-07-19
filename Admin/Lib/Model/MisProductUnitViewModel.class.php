<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(员工基本信息视图表) 
 * @author lcx 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-3-27 上午11:43:49 
 * @version V1.0
 */
class MisProductUnitViewModel extends ViewModel{
	public $viewFields = array(
		"MisProductUnit"=>array('_as'=>'mis_product_unit','id','name','typeid','status','_type'=>'LEFT'),
		"MisProductUnittype"=>array('_as'=>'mis_product_unittype','id'=>'unittypeid','unittypeid','name'=>'typename','_on'=>'mis_product_unit.typeid=mis_product_unittype.id','_type'=>'LEFT'),
	);
}
?>