<?php
/**
 * @Title: MisAutoSxlAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-保后表决单)
 * @author 管理员
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2016-03-03 14:28:34
 * @version V1.0
*/
class MisAutoSxlAction extends MisAutoSxlExtendAction {
	public function _filter(&$map){
		$fieldtype=$_REQUEST['fieldtype'];
		$relationmodelname=$_REQUEST['bindaname'];
		//获取表单类型
		$type=getFieldBy($relationmodelname, "bindaname", "typeid", "mis_auto_bind"); 		
		if($fieldtype){
			$map[$fieldtype]=$_REQUEST[$fieldtype];
			$this->assign("fieldtype",$fieldtype);
			$this->assign("fieldtypeval",$_REQUEST[$fieldtype]);
		}else{
			//组从表单需加此条件过滤 
			if($type==1){
				if($relationmodelname){
					$map['relationmodelname']=$relationmodelname;	
				}
			}
		}
		if($type==1){
			// 为了兼容普通模式下的表单使用
			$bindid = $_REQUEST['bindid'];
			if($bindid){
				$map['bindid']=$bindid;
				$this->assign("bindid",$bindid);
			}
		}
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",-1);
		}
		$this->_extend_filter($map);
	}
	/**
	 * @Title: _before_index
	 * @Description: todo(前置index函数)
	 * @author 管理员
	 * @date 2016-03-03 14:28:34
	 * @throws 
	*/
	function _before_index() {
		$this->_extend_before_index();
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo(前置编辑函数)
	 * @author 管理员
	 * @date 2016-03-03 14:28:34
	 * @throws 
	*/
	function _before_edit(){
		if($_REQUEST['main'])
			$this->assign("main",$_REQUEST['main']);
		$this->_extend_before_edit();
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(前置添加函数)
	 * @author 管理员
	 * @date 2016-03-03 14:28:34
	 * @throws 
	*/
	function _before_insert(){
		$this->checkifexistcodeororder('mis_auto_sxlpg','orderno',$this->getActionName());
		$this->_extend_before_insert();
	}
	/**
	 * @Title: _before_update
	 * @Description: todo(前置修改函数)  
	 * @author 管理员
	 * @date 2016-03-03 14:28:34
	 * @throws
	*/
	function _before_update(){
		$this->checkifexistcodeororder('mis_auto_sxlpg','orderno',$this->getActionName(),1);
		$this->_extend_before_update();
	}
	/**
	 * @Title: _after_edit
	 * @Description: todo(后置编辑函数)
	 * @author 管理员
	 * @date 2016-03-03 14:28:34
	 * @throws 
	*/
	function _after_edit($vo){
		$this->_extend_after_edit($vo);
	}
	/**
	 * @Title: _after_insert
	 * @Description: todo(后置insert函数)  
	 * @author 管理员
	 * @date 2016-03-03 14:28:34
	 * @throws
	*/
	function _after_insert($id){
		$this->_extend_after_insert($id);
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(前置add函数)  
	 * @author 管理员
	 * @date 2016-03-03 14:28:34
	 * @throws
	*/
	function _before_add(){
		$vo['biaojueriqi']=time();
		if($_REQUEST['main'])
			$this->assign("main",$_REQUEST['main']);
		$this->_extend_before_add($vo);
	}
	/**
	 * @Title: _after_update
	 * @Description: todo(后置update函数)  
	 * @author 管理员
	 * @date 2016-03-03 14:28:34
	 * @throws
	*/
	function _after_update(){
		$this->_extend_after_update();
	}
}
?>