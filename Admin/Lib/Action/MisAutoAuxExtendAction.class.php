<?php
/**
 * @Title: MisAutoAuxAction
 * @Package package_name
 * @Description: todo(动态表单_扩展类。本类为用户代码注入入口，系统一旦生成将不再重复生成。 * 						但当用户选为组合表单方案后会更新该文件，请做好备份)
 * @author 杨君
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-03-19 15:17:14
 * @version V1.0
*/
class MisAutoAuxExtendAction extends CommonAction {
	public function _extend_filter(&$map){
		$map['allnode']=$this->getActionName();
	}
	/**
	 * @Title: _extend_before_index
	 * @Description: todo(扩展前置index函数)
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws 
	*/
	function _extend_before_index() {
	}
	/**
	 * @Title: _extend_before_edit
	 * @Description: todo(扩展的前置编辑函数)
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws 
	*/
	function _extend_before_edit(){
	}
	/**
	 * @Title: _extend_before_insert
	 * @Description: todo(扩展的前置添加函数)
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws 
	*/
	function _extend_before_insert(){
	}
	/**
	 * @Title: _extend_before_update
	 * @Description: todo(扩展前置修改函数)  
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws
	*/
	function _extend_before_update(){
	}
	/**
	 * @Title: _extend_after_edit
	 * @Description: todo(扩展后置编辑函数)
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws 
	*/
	function _extend_after_edit($vo){
	}
	/**
	 * @Title: _extend_after_list
	 * @Description: todo(扩展前置List)
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws 
	*/
	function _extend_after_list(){
	}
	/**
	 * @Title: _extend_after_insert
	 * @Description: todo(扩展后置insert函数)  
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws
	*/
	function _extend_after_insert($id){
	}
	/**
	 * @Title: _extend_before_add
	 * @Description: todo(扩展前置add函数)  
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws
	*/
	function _extend_before_add(&$vo){
		$this->getFormIndexLoad($vo);
	}
	/**
	 * @Title: _extend_after_update
	 * @Description: todo(扩展后置update函数)  
	 * @author 杨君
	 * @date 2015-03-19 15:17:14
	 * @throws
	*/
	function _extend_after_update(){
	}
}
?>