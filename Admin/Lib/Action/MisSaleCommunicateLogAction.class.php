<?php
/**
 * @Title: MisSaleCommunicateLogAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-沟通记录)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-29 15:14:07
 * @version V1.0
*/
class MisSaleCommunicateLogAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",-1);
			$map['userid'] =$_SESSION[C('USER_AUTH_KEY')];
		}
		
		
		
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo(前置编辑函数)
	 * @author 管理员
	 * @date 2014-09-29 15:14:07
	 * @throws 
	*/
	function _before_edit(){
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$this->assign('userid',$userid);
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(前置添加函数)
	 * @author 管理员
	 * @date 2014-09-29 15:14:07
	 * @throws 
	*/
	function _before_insert(){
	}
	/**
	 * @Title: _before_update
	 * @Description: todo(前置修改函数)  
	 * @author 管理员
	 * @date 2014-09-29 15:14:07
	 * @throws
	*/
	function _before_update(){
	}
	/**
	 * @Title: _after_edit
	 * @Description: todo(后置编辑函数)
	 * @author 管理员
	 * @date 2014-09-29 15:14:07
	 * @throws 
	*/
	function _after_edit($vo){
	}
	/**
	 * @Title: _after_insert
	 * @Description: todo(后置insert函数)  
	 * @author 管理员
	 * @date 2014-09-29 15:14:07
	 * @throws
	*/
	function _after_insert($id){
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(前置add函数)  
	 * @author 管理员
	 * @date 2014-09-29 15:14:07
	 * @throws
	*/
	function _before_add(){
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$this->assign('userid',$userid);
		
	}
	/**
	 * @Title: _after_update
	 * @Description: todo(后置update函数)  
	 * @author 管理员
	 * @date 2014-09-29 15:14:07
	 * @throws
	*/
	function _after_update(){
	}
	

	
	
	function lookupcommunicate(){
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$this->assign('userid',$userid);
		$name='MisBusiness';
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$this->assign('bid',$id);
		$this->assign('time',time());
		
		$this->display();
	}
	
}
?>