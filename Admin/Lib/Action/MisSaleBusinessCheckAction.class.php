<?php
/**
 * @Title: MisSaleBusinessCheck
 * @Package 商机审核：功能类
 * @Description: TODO(商机审核的处理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2013-1-10 19:18:54
 * @version V1.0
*/
class MisSaleBusinessCheckAction extends CommonAuditAction {
	
	public function _filter(&$map){
		if( !isset($_SESSION['a']) ){
			$map['status']=1;
		}
	}

	public function index(){
		if ($_REQUEST['type']) {
			$type = $_REQUEST['type'];
			//获取当前控制器
			$name=$this->getActionName();
			//当请求进入到此处撒。保留用户点击留下的查询条件
			Cookie::delete($_SESSION[C('USER_AUTH_KEY')].$name.'defaultSelect');
			Cookie::set($_SESSION[C('USER_AUTH_KEY')].$name.'defaultSelect', $type);
			$this->assign("type",$type);
				
			//构造检索条件
			$map = $this->_search ($name);
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
			//验证浏览及权限
			$qx_name=$name;
			if(substr($name, -4)=="View"){
				$qx_name = substr($name,0, -4);
			}
			if( !isset($_SESSION['a']) ){
				$map=D('User')->getAccessfilter($qx_name,$map);
			}
			if($type == 2){
				//待启动单据
				$map['auditState'] = array('eq',0);
			}else if($type == 3){
				//审核中
				$map['_string'] = "auditState > 0 and auditState <3";
			}else if($type == 4){
				//审核完毕
				$map['auditState'] = array('eq',3);
			}else if($type == 5){
				//未批准
				$map['auditState'] = array('eq',-1);
			}
				
			$this->_list('MisSaleBusinessCheckView',$map);
				
			//存在滚动加载时，进行模板输出
			if( intval($_POST['dwzloadhtml']) ){
				$this->display("dwzloadindex");exit;
			}
			//此处的indextype参数，是在getAuditTree方法中传入过来的。起判断页面加载作用
			if(!$_POST['indextype']){
				$this->display('indexview');
			}
				
		} else {
			$this->getAuditTree();
			$this->display("CommonAudit:index");
		}
	}
	
	public function waitAudit(){
		//获取当前控制器名称
		$name = $this->getActionName();
		//配置检索条件，检索功能。
		$map = $this->_search ($name);
	
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
	
		$map['status'] =1;
		$map['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].',curAuditUser )';
		$this->_list('MisSaleBusinessCheckView',$map,'',true);
	
		//因为待审核和审核页面是公用页面。所有必须传入一个请求的方法。
		$this->assign('jumpUrl','waitAudit');
		//作用于 auditIndex页面的按钮控制，0为审核。1为查看
		$this->assign('audit','0');
		$type = $_REQUEST['type'];
		if($type){
			Cookie::delete($_SESSION[C('USER_AUTH_KEY')].$name.'defaultSelect');
			//存储当前用户选中的默认节点
			Cookie::set($_SESSION[C('USER_AUTH_KEY')].$name.'defaultSelect', $type);
		}
		$this->assign("type",$type);
		if(!$_POST['indextype']){
			$this->display('auditIndex');
		}
	}
	
	// 获取已审核数据
	public function alreadyAudit(){
		//获取当前控制器名称
		$name = $this->getActionName();
		//配置检索条件，检索功能。
		$map = $this->_search ($name);
	
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$map['status'] = array('eq',1);
		$map['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].', alreadyAuditUser )';
	
		$this->_list('MisSaleBusinessCheckView',$map);
	
		//因为待审核和审核页面是公用页面。所有必须传入一个请求的方法。
		$this->assign('jumpUrl','alreadyAudit');
		//作用于 auditIndex页面的按钮控制，0为审核。1为查看
		$this->assign('audit','1');
	
		$type = $_REQUEST['type'];
		if($type){
			Cookie::delete($_SESSION[C('USER_AUTH_KEY')].$name.'defaultSelect');
			//存储当前用户选中的默认节点
			Cookie::set($_SESSION[C('USER_AUTH_KEY')].$name.'defaultSelect', $type);
		}
		$this->assign("type",$type);
	
		if(!$_POST['indextype']){
			$this->display('auditIndex');
		}
	}
	
	public function _after_insert(){
		$name='MisSaleBusiness';
		$model = D ( $name );
		$map["id"] = $_POST['bid'];
		$businessdata['businessstatus']=6;
		$list = $model->where($map)->save($businessdata);
		
	}
	
	public function _before_add(){
		$name='MisSaleBusiness';
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$bid=$id;
		$this->assign('bid',$bid);
		//$userid=$_SESSION[C('USER_AUTH_KEY')];
	}
	public function _before_edit(){
		$this->assign('time',time());
	}
	
	function lookupreserveadd(){
		$name='MisSaleBusiness';
		$model = D ( $name );
		$rel=$_REQUEST['rel'];
		$this->assign('rel',$rel);
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$bid=$id;
		$this->assign('bid',$bid);
		$this->display();
	}
	
	/**
	 * @Title: overProcess 
	 * @Description: todo(审批后执行 修改商机状态)   
	 * @author libo 
	 * @date 2014-6-20 下午4:07:12 
	 * @throws
	 */
	public function overProcess($masid){
		//查询该单
		$BusinessModel=D("MisSaleBusiness");
		$CkeckModel=D("MisSaleBusinessCheck");
		$checkInfo=$CkeckModel->where("id=".$masid)->field("bid,useexplain")->find();
		$CkeckModel->commit();
		$busdata['businessstatus']=5;
		$busdata['remark']=$checkInfo['useexplain'];
		$list=$BusinessModel->where("id=".$checkInfo['bid'])->save($busdata);
		$BusinessModel->commit();
		
	}
}
?>