<?php
/**
 * @Title: MisExpertQuestionTypeAction 
 * @Package package_name
 * @Description: todo(专家问题分类) 
 * @author lcx 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-8-10 上午 10:14:55 
 * @version V1.0
 */
class MisExpertQuestionTypeAction extends CommonAction {
	/**
	 * @Title: _filter 
	 * @Description: todo(构造检索条件) 
	 * @param unknown_type $map  
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:15:33 
	 * @throws
	 */
	public function _filter(&$map){
		if ($_SESSION["a"] != 1)$map['status']=array("gt",0);
		$MisExpertQuestionTypeModel = D("MisExpertQuestionType");
		//获取条件
		if($_REQUEST['typeid']){
			$map['pid'] = $_REQUEST['typeid'];
			$this->assign("typeid",$_REQUEST['typeid']);
		}else{
			$map['pid'] = array('neq',0);
		}
	}
	/**
	 * (non-PHPdoc) yuansl 2014. 04 . 20
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
// 		//扩展工具栏操作
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
	//构造树类型节点
	public function gettypetree(){
		//实例专家分类
		$MisExpertQuestionTypeModel = D("MisExpertQuestionType");
		$MisExpertQuestionTypeList = $MisExpertQuestionTypeModel->where("status = 1")->select();
		$typecount = count($MisExpertQuestionTypeList);
		if($_REQUEST['typeid']){
			$map['id'] = $_REQUEST['typeid'];
		}
		//构造顶级节点
		$tree[] = array(
				'id' => 0,
				'pId' =>  -1,
				'name' => '问题分类',
				'title' => '',
				'rel' => "misexpertquestiontype",
				'target' => 'ajax',
				'icon' => "",
				'url' => "__URL__/index/jump/2",
				'open' => true
		);
		foreach($MisExpertQuestionTypeList as $vatype){
			if($vatype['pid'] == 0){
				$tree[] = array(
						'id' => $vatype['id'],
						'pId' =>  $vatype['pid'],
						'name' => $vatype['name'],
						'title' => $vatype['name'],
						'rel' => "misexpertquestiontype",
						'target' => 'ajax',
						'icon' => "",
						'url' => "__URL__/index/jump/2/typeid/".$vatype['id'],
						'open' => true
				);
			}
		}
		$this->assign("tree",json_encode($tree));
	}
	/**
	 * @Title: _before_add 
	 * @Description: todo(新增问题分类)   
	 * @author yuansl 
	 * @date 2014-4-20 下午2:40:16 
	 * @throws
	 */
	public function _before_add(){
		if($_REQUEST['top']){
			$this->assign('top',$_REQUEST['top']);
		}
		//订单是否可写
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_expert_question_type');
		$this->assign("writable",$writable);
		//自动生成编号
		$code = $scnmodel->GetRulesNO('mis_expert_question_type');
		$this->assign("code", $code);
		$MisExpertQuestionTypeModel = D("MisExpertQuestionType");
		$topTypeList = $MisExpertQuestionTypeModel->where("status = 1 and pid = 0")->field("id,pid,name")->select();
		$this->assign("questiontype",$topTypeList);
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::insert()
	 */
	public function insert(){
// 		dump($_REQUEST);exit;
		$pid = $_REQUEST['pid'];
		$pids = $_REQUEST['pids'];
		$MisExpertQuestionTypeModel = D("MisExpertQuestionType");
		//添加分类限制
		if($pid == 0){//代表添加父级
			$rex = $MisExpertQuestionTypeModel->where("status = 1 and pid = 0 and name = "."'".$_REQUEST['name']."'")->find();
			if($rex){
				$this->error("已经存在相同名称的分类!");
				exit;
			}
		}
		if($pid == 2){//代表子级
			$rex = $MisExpertQuestionTypeModel->where("status = 1 and pid = ".$pids." and name = "."'".$_REQUEST['name']."'")->find();
			if($rex){
				$this->error("已经存在相同名称的分类!");
				exit;
			}
		}
		if($pid == 0){
			$data = $MisExpertQuestionTypeModel->create($_REQUEST);
			$re = $MisExpertQuestionTypeModel->add();
// 			echo $MisExpertQuestionTypeModel->getLastSql();
			if($re){
				$this->success('操作成功!');
			}else{
				$this->error('操作失败!');
			}
		}else{
			//$pid = $_REQUEST['pids'];
			$data['name'] = $_REQUEST['name'];
			$data['code'] = $_REQUEST['code'];
			$data['createtime'] = time();
			$data['createid'] = $_SESSION[C('USER_AUTH_KEY')];
			$data['pid'] =  $_REQUEST['pids'];
			$re = $re = $MisExpertQuestionTypeModel->add($data);
// 			echo $MisExpertQuestionTypeModel->getLastSql();
			if($re){
				$this->success('操作成功!');
			}else{
				$this->error('操作失败!');
			}
		}
	}
	/**
	 * @Title: _before_edit 
	 * @Description: todo(修改页面的前置函数)   
	 * @author lcx 
	 * @date 2013-8-10 上午 10:14:55 
	 * @throws
	 */
	public function _before_edit(){
		$MisExpertQuestionTypeModel = D("MisExpertQuestionType");
		if($_REQUEST['top']){
			$this->assign('top',$_REQUEST['top']);
		}
		$this->assign('vo',$typeinfo);
		//所有的父级
		$toptypelist = $MisExpertQuestionTypeModel->where("status = 1 and pid = 0")->select();
		$this->assign('toptypelist',$toptypelist);
	}
	//右侧的操作 
    public function beforedittop(){
    	$id = $_REQUEST['id'];
    	$MisExpertQuestionTypeModel = D("MisExpertQuestionType");
    	$typeinfo = $MisExpertQuestionTypeModel->where("id = ".$id)->find();
    	//子级
    	$typelist = $MisExpertQuestionTypeModel->where("status = 1 and pid =  0")->select();
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