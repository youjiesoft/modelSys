<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(会议室管理物品信息管理) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-6-15 下午10:48:48 
 * @version V1.0
 */
class MisMeetingRoomUrgedAction extends CommonAction{
	
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",0);
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::index()
	 */
	public function index(){
		$name = $this->getActionName();
		//列表过滤器，生成查询Map对象
		$map = $this->_search ($name);
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//验证浏览及权限
		if( !isset($_SESSION['a']) ){
			$map=D('User')->getAccessfilter($qx_name,$map);
		}
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
		/* if($_REQUEST['jump']){
			$this->display('indexview');
			exit;
		} */
		$this->display('index');
	}
	/**
	 * @Title: _before_insert 
	 * @Description: todo(新增前置操作)   
	 * @author yuansl 
	 * @date 2014-7-4 上午9:30:47 
	 * @throws
	 */
	public function _before_insert(){
		$rex = $this->checkkey();
		if(!$rex){
			$this->error("已存在相同key");
		}
	}
	public function _before_update(){
		$rex = $this->checkkey();
		if(!$rex){
			$this->error("已存在相同key");
		}
	}
	/**
	 * @Title: checkkey 
	 * @Description: todo(用于检查用户输入的标示是否已存在)   
	 * @author yuansl 
	 * @date 2014-7-4 上午9:23:02 
	 * @throws
	 */
	private function checkkey(){
		$model = D("MisMeetingRoomUrged");
		$key = $_POST['key'];
		$map['status'] = array('eq',1);
		$map['key'] = array('eq',$key);
		if($_REQUEST['id']){
			$map['id'] = array('neq',$_REQUEST['id']);
		}
		$ifkeyinfo = $model->where($map)->find();
		if($ifkeyinfo){
			return false;
		}else{
			return true;
		}
	}

}
