<?php
/**
 * @Title: MisSaleClientBasicAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-客户基础资料)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-10-08 16:04:15
 * @version V1.0
*/
class MisSaleClientBasicAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)
			$map['status']=array("gt",-1);
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo(前置编辑函数)
	 * @author 管理员
	 * @date 2014-10-08 16:04:15
	 * @throws 
	*/
	function _before_edit(){
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(前置添加函数)
	 * @author 管理员
	 * @date 2014-10-08 16:04:15
	 * @throws 
	*/
	function _before_insert(){
	}
	/**
	 * @Title: _before_update
	 * @Description: todo(前置修改函数)  
	 * @author 管理员
	 * @date 2014-10-08 16:04:15
	 * @throws
	*/
	function _before_update(){
	}
	/**
	 * @Title: _after_edit
	 * @Description: todo(后置编辑函数)
	 * @author 管理员
	 * @date 2014-10-08 16:04:15
	 * @throws 
	*/
	function _after_edit($vo){
		$model=M("mis_sale_customer_type");
		$listcustomertypeid =$model->where('status=1')->field("name,id")->select();
		$this->assign("customertypeidlist",$listcustomertypeid);
	}
	/**
	 * @Title: _after_insert
	 * @Description: todo(后置insert函数)  
	 * @author 管理员
	 * @date 2014-10-08 16:04:15
	 * @throws
	*/
	function _after_insert($id){
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(前置add函数)  
	 * @author 管理员
	 * @date 2014-10-08 16:04:15
	 * @throws
	*/
	function _before_add(){
		$model=M("mis_sale_customer_type");
		$listcustomertypeid =$model->where('status=1')->field("name,id")->select();
		$this->assign("customertypeidlist",$listcustomertypeid);
	}
	/**
	 * @Title: _after_update
	 * @Description: todo(后置update函数)  
	 * @author 管理员
	 * @date 2014-10-08 16:04:15
	 * @throws
	*/
	function _after_update(){
	}
}
?>