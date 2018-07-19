<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(专家分类管理) 
 * @author yuansl 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-4-20 下午8:21:27 
 * @version V1.0
 */
class MisExpertTypeAction extends CommonAction {
	/**
	 * @Title: _filter 
	 * @Description: todo(这里用一句话描述这个方法的作用) 
	 * @param unknown_type $map  
	 * @author yuansl 
	 * @date 2014-4-20 下午8:24:47 
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['status']=array("gt",0);
		}
		if( $_REQUEST['pid'] ){
			$map['pid'] = $_REQUEST['pid'];
			$this->assign("pid",$_REQUEST['pid']);
		}else{
			$map['pid'] = array('neq',0);
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::index()
	 */
	public function index(){
		$name = $this->getActionName();
		//获取树节点
		$this->gettypetree();
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
		if($_REQUEST['jump']){
			$this->display('indexview');
			exit;
		}
		$this->display('index');
	}
	/**
	 * @Title: gettypetree 
	 * @Description: todo(构造树节点)   
	 * @author yuansl 
	 * @date 2014-4-20 下午9:21:39 
	 * @throws
	 */
	public function gettypetree(){
		//实例专家分类
		$MisExpertTypeModel = D("MisExpertType");
		$MisExpertTypeList = $MisExpertTypeModel->where("status = 1")->select();
		$typecount = count($MisExpertTypeList);
		if($_REQUEST['pid']){
			$map['pid'] = $_REQUEST['pid'];
		}
		//构造顶级节点
		$tree[] = array(
				'id' => 0,
				'pId' =>  -1,
				'name' => '专家分类',
				'title' => '',
				'rel' => "misexperttype",
				'target' => 'ajax',
				'icon' => "",
				'url' => "__URL__/index/jump/2",
				'open' => true
		);
		foreach($MisExpertTypeList as $vatype){
			if($vatype['pid'] == 0){
				$tree[] = array(
						'id' => $vatype['id'],
						'pId' =>  $vatype['pid'],
						'name' => $vatype['name'],
						'title' => $vatype['name'],
						'rel' => "misexperttype",
						'target' => 'ajax',
						'icon' => "",
						'url' => "__URL__/index/jump/2/pid/".$vatype['id'],
						'open' => true
				);
			}
		}
		$this->assign("tree",json_encode($tree));
	}
	/**
	 * @Title: _before_edit 
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author yuansl 
	 * @date 2014-4-20 下午10:53:35 
	 * @throws
	 */
	public function _before_edit(){
		if($_REQUEST['top']){
			$this->assign("top",$_REQUEST['top']);
		}
		$id = $_REQUEST['id'];
		$MisExpertTypeModel = D("MisExpertType");
		$this->assign('vo',$typeinfo);
		//子级
		$toptypelist = $MisExpertTypeModel->where("status = 1 and pid = 0")->select();
		$this->assign('toptypelist',$toptypelist);
		if($_REQUEST['pid']){
			$this->assign("pid",$_REQUEST['pid']);
		}
	}
	//右侧的操作
	public function beforedittop(){
		$id = $_REQUEST['id'];
		$MisExpertTypeModel = D("MisExpertType");
		$typeinfo = $MisExpertTypeModel->where("id = ".$id)->find();
		//子级
		$typelist = $MisExpertTypeModel->where("status = 1 and pid =  0")->select();
		//除去本身
		$newtypelist = array();
		foreach($typelist as $vax){
			if($vax['id'] != $_REQUEST['id']){
				array_push($newtypelist, $vax);
			}
		}
		$this->assign('top',1);
		$this->assign('toptypelist',$newtypelist);
	}
	/**
	 * @Title: _before_add 
	 * @Description: todo(判断是否可写,生成code)   
	 * @author yuansl 
	 * @date 2014-4-20 下午9:14:03 
	 * @throws
	 */
	public function _before_add(){
		if($_REQUEST['top']){
			$this->assign("top",$_REQUEST['top']);
		}
		//订单是否可写
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_expert_type');
		$this->assign("writable",$writable);
		//自动生成编号
		$code = $scnmodel->GetRulesNO('mis_expert_type');
		$this->assign("code", $code);
		//
		$MisExpertTypeModel = D("MisExpertType");
		$topTypeList = $MisExpertTypeModel->where("status = 1 and pid = 0")->field("id,name")->select();
		$this->assign("questiontype",$topTypeList);
		if($_REQUEST['pid']){
			$this->assign("pid",$_REQUEST['pid']);
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::insert()
	 */
	public function insert(){
// 		dump($_REQUEST);exit;
		$pid = $_REQUEST['pid1'];
		//分类限制处理
		$pids = $_REQUEST['pids'];
		$MisExpertTypeModel = D("MisExpertType");
		if($pid == 2){
			$pids = $_REQUEST['pids'];
			$rex = $MisExpertTypeModel->where("status = 1 and pid = ".$pids." and name = "."'".$_REQUEST['name']."'")->find();
			if($rex){
				$this->error("已经存在相同名称的分类!");
				exit;
			}
		}
		if($pid == 0){
			$rex = $MisExpertTypeModel->where("status = 1 and pid = ".$pid." and name = "."'".$_REQUEST['name']."'")->find();
			if($rex){
				$this->error("已经存在相同名称的分类!");
				exit;
			}
		}
		
		if($pid == 0){//顶级
			//$data = $MisExpertTypeModel->create( $_REQUEST);
			$data['name'] = $_REQUEST['name'];
			$data['code'] = $_REQUEST['code'];
			$data['pid'] =  $pid;
			$data['createtime'] = time();
			$data['createid'] = $_SESSION[C('USER_AUTH_KEY')];
			$re = $MisExpertTypeModel->add($data);
			if($re){
				$this->success('操作成功!');
			}else{
				$this->error('操作失败!');
			}
		}else{//子级
			$pid = $_REQUEST['pids'];
			$data['name'] = $_REQUEST['name'];
			$data['code'] = $_REQUEST['code'];
			$data['pid'] =  $_REQUEST['pids'];
			$data['createtime'] = time();
			$data['createid'] = $_SESSION[C('USER_AUTH_KEY')];
			$re = $re = $MisExpertTypeModel->add($data);
			if($re){
				$this->success('操作成功!');
			}else{
				$this->error('操作失败!');
			}
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::delete()
	 */
	public function delete(){
		$name = $this->getActionName();
		$Model = D($name);
		$id = $_REQUEST['id'];
		$data['status'] = -1;
		$typeinfo = $Model->where("id = ".$id)->find();
		if($typeinfo['pid'] == 0){
			$conu = $Model->where("status = 1 and pid = ".$id)->count();
			if($conu > 0 ){
				$this->error("该节点下面还有子级节点,不能删除!");
			}else{
				$re = $Model->where("id = ".$_REQUEST['id'])->save($data);
				if($re){
					$this->success("删除成功!");
					exit;
				}
			}
		}else{
			// 超管对已经成为删除状态的数据进行测试无记录的删除
			if($_SESSION['a']){
				$condition["status"] = array ("eq",-1);
				$list=$Model->where ( $condition )->delete();
				$condition["status"] = array ("neq",-1);
			}
			$re = $Model->where("id = ".$_REQUEST['id'])->save($data);
			if($re){
				$this->success("删除成功!");
			}
		}
		
	}
}
?>