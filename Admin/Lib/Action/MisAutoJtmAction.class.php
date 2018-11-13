<?php
/**
 * @Title: MisAutoJtmAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-评审会类型)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015-02-11 09:53:08
 * @version V1.0
*/
class MisAutoJtmAction extends MisAutoJtmExtendAction {
	public function _filter(&$map){
	$fieldtype=$_REQUEST['fieldtype'];
	if($fieldtype){
		$map[$fieldtype]=$_REQUEST[$fieldtype];
		$this->assign("fieldtype",$fieldtype);
		$this->assign("fieldtypeval",$_REQUEST[$fieldtype]);
	}
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",-1);
		}
		$this->_extend_filter(&$map);
	}
	/**
	 * @Title: edit
	 * @Description: todo(重写父类编辑函数)
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws 
	*/
	function edit($isdisplay=1){
		$mainTab = 'mis_auto_fwvvg';
		//获取当前控制器名称
		$name=$this->getActionName();
		$model = D("MisAutoJtmView");
		//获取当前主键
		$map[$mainTab.'.id']=$_REQUEST['id'];
		$vo = $model->where($map)->find();
		if(!$vo){
		$this->getFormIndexLoad();
		}
		if(method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//读取动态配制
		$this->getSystemConfigDetail($name);
		//扩展工具栏操作
		$scdmodel = D('SystemConfigDetail');
		// 上一条数据ID
		$map['id'] = array("lt",$id);
		$updataid = $model->where($map)->order('id desc')->getField('id');
		$this->assign("updataid",$updataid);
		// 下一条数据ID
		$map['id'] = array("gt",$id);
		$downdataid = $model->where($map)->getField('id');
		$this->assign("downdataid",$downdataid);
		//lookup带参数查询
		$module=A($name);
		if (method_exists($module,"_after_edit")) {
			call_user_func(array(&$module,"_after_edit"),&$vo);
		}
		$this->assign( 'vo', $vo );
		if($isdisplay)
		$this->display ();
	}
	/**
	 * @Title: _before_index
	 * @Description: todo(前置index函数)
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws 
	*/
	function _before_index() {
		$this->_extend_before_index();
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo(前置编辑函数)
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws 
	*/
	function _before_edit(){
		$this->_extend_before_edit();
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(前置添加函数)
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws 
	*/
	function _before_insert(){
		$this->checkifexistcodeororder('mis_auto_fwvvg','orderno',$this->getActionName());
		$this->_extend_before_insert();
	}
	/**
	 * @Title: _before_update
	 * @Description: todo(前置修改函数)  
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws
	*/
	function _before_update(){
		$this->checkifexistcodeororder('mis_auto_fwvvg','orderno',$this->getActionName(),1);
		$this->_extend_before_update();
	}
	/**
	 * @Title: _after_edit
	 * @Description: todo(后置编辑函数)
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws 
	*/
	function _after_edit($vo){
		$this->_extend_after_edit($vo);
	}
	/**
	 * @Title: _after_insert
	 * @Description: todo(后置insert函数)  
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws
	*/
	function _after_insert($id){
		$this->_extend_after_insert($id);
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(前置add函数)  
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws
	*/
	function _before_add(){
		$this->_extend_before_add();
	}
	/**
	 * @Title: _after_update
	 * @Description: todo(后置update函数)  
	 * @author 管理员
	 * @date 2015-02-11 09:53:08
	 * @throws
	*/
	function _after_update(){
		$this->_extend_after_update();
	}
}
?>