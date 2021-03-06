<?php
/** 
 * @Title: MisMyWorkingAction 
 * @Package package_name
 * @Description: todo(我的工作) 
 * @author 杨东 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-2-21 上午10:15:21 
 * @version V1.0 
*/ 
class MisMyWorkingAction extends CommonAction{
	
	public function _after_list(&$voList){
		
	}
	
	public function index() {
		$this->assign("type",$_REQUEST['type']);
		if($_REQUEST['type'] == 1){
			$name = $this->getActionName();
			//列表过滤器，生成查询Map对象
			$map = $this->_search ();
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
			$map['dostatus'] = 0;
			if(!$_SESSION["a"]==1){
			$map['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].', curNodeUser )';
			}
			//验证浏览及权限
			$this->_list ( "MisWorkMonitoring", $map );
			$scdmodel = D('SystemConfigDetail');
			$detailList = $scdmodel->getDetail($name);
			if ($detailList) {
				$this->assign ( 'detailList', $detailList );
			}
			//扩展工具栏操作
			$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
			if ($toolbarextension) {
				$this->assign ( 'toolbarextension', $toolbarextension );
			}
			$this->display ("worklist");
			return;
		} else if($_REQUEST['type'] == 2){
			$name = "MisWorkMonitoring";
			//列表过滤器，生成查询Map对象
			$map = $this->_search ($name);
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
			$map['userid'] = $_SESSION[C('USER_AUTH_KEY')];
			//验证浏览及权限
			$this->_list ( $name, $map );
			$scdmodel = D('SystemConfigDetail');
			$detailList = $scdmodel->getDetail($name);
			if ($detailList) {
				$this->assign ( 'detailList', $detailList );
			}
			//扩展工具栏操作
			$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
			if ($toolbarextension) {
				$this->assign ( 'toolbarextension', $toolbarextension );
			}
			$this->display ("worklist");
			return;
		} else {
			$this->display ();
			return;
		}
	}
	
	
    public function _filter(&$map){
    	
	}
}
