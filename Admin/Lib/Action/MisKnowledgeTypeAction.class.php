<?php
/**
 * @Title: MisKnowledgeTypeAction 
 * @Package package_name
 * @Description: todo(知识管理的知识库的文章分类class) 
 * @author xiafengqin 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-5-31 下午5:14:55 
 * @version V1.0
 */
class MisKnowledgeTypeAction extends CommonAction {
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
		//获取条件
		if($_REQUEST['typeid']){
			$map['parentid'] = $_REQUEST['typeid'];
			$this->assign("typeid",$map['parentid']);
		}else{
			$map['parentid'] = array('neq',0);
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::index(重写index构造树等)
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
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
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
	 * @date 2014-4-23 下午10:24:10 
	 * @throws
	 */
	public function gettypetree(){
		//实例知识库
		$MisKnowledgeTypeModel = D("MisKnowledgeType");
		$MisKnowledgeTypeList = $MisKnowledgeTypeModel->where("status = 1")->select();
		$typecount = count($MisKnowledgeTypeList);
// 		dump($MisKnowledgeTypeList);
// 		exit;
		if($_REQUEST['typeid']){
			$map['id'] = $_REQUEST['typeid'];
		}
		//构造顶级节点
		$tree[] = array(
				'id' => 0,
				'parentid' =>  -1,
				'name' => '文章分类',
				'title' => '',
				'rel' => "misknowledgetype",
				'target' => 'ajax',
				'icon' => "",
				'url' => "__URL__/index/jump/2",
				'open' => true
		);
		foreach($MisKnowledgeTypeList as $vatype){
			if($vatype['parentid'] == 0){
				$tree[] = array(
						'id' => $vatype['id'],
						'pId' =>  $vatype['parentid'],
						'name' => $vatype['name'],
						'title' => $vatype['name'],
						'rel' => "misknowledgetype",
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
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author yuansl 
	 * @date 2014-4-23 下午11:06:57 
	 * @throws
	 */
	public function _before_add(){
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_knowledge_type');
		$this->assign("writable",$writable);
		$code = $scnmodel->GetRulesNO('mis_knowledge_type');
		$this->assign("code", $code);
		if($_REQUEST['top']){
			$this->assign("top",$_REQUEST['top']);
		}
		$MisKnowledgeTypeModel=D("MisKnowledgeType");
		$knowleagetypeList=$MisKnowledgeTypeModel->where("status = 1 and parentid = 0")->field("id,name,parentid")->select();
		$this->assign("knowleagetypelist",$knowleagetypeList);
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::insert()
	 */
	public function insert(){
		$pid = $_REQUEST['pid'];
		$pids = $_REQUEST['pids'];
		$MisKnowledgeTypeModel = D("MisKnowledgeType");
		//添加分类限制
		if($pid == 0){//代表添加父级
			$rex = $MisKnowledgeTypeModel->where("status = 1 and parentid = 0 and name = "."'".$_REQUEST['name']."'")->find();
			if($rex){
				$this->error("已经存在相同名称的分类!");
				exit;
			}
		}
		if($pid == 2){//代表子级
			$rex = $MisKnowledgeTypeModel->where("status = 1 and parentid = ".$pids." and name = "."'".$_REQUEST['name']."'")->find();
			if($rex){
				$this->error("已经存在相同名称的分类!");
				exit;
			}
		}
		if($pid == 0){//插入父级
			$data = $MisKnowledgeTypeModel->create($_REQUEST);
			$re = $MisKnowledgeTypeModel->add();
			if($re){
				$this->success('操作成功!');
			}else{
				$this->error('操作失败!');
			}
		}else{//插入子级
			$data['name'] = $_REQUEST['name'];
			$data['code'] = $_REQUEST['code'];
			$data['createtime'] = time();
			$data['createid'] = $_SESSION[C('USER_AUTH_KEY')];
			$data['parentid'] =  $_REQUEST['pids'];
			$re = $re = $MisKnowledgeTypeModel->add($data);
			if($re){
				$this->success('操作成功!');
			}else{
				$this->error('操作失败!');
			}
		}
	}
	/**
	 * @Title: _before_edit 
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author yuansl 
	 * @date 2014-4-23 下午11:24:07 
	 * @throws
	 */
	public function _before_edit(){
		$MisKnowledgeTypeModel = D("MisKnowledgeType");
// 		//判断该分类是子级还是父级
		if($_REQUEST['top']){
			$this->assign("top",$_REQUEST['top']);
		}
		$this->assign('vo',$typeinfo);
		//所有的父级
		$toptypelist = $MisKnowledgeTypeModel->where("status = 1 and parentid = 0")->select();
		$this->assign('toptypelist',$toptypelist);
	}
	public function common( $map=array() ){
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_knowledge_type');
		$this->assign("writable",$writable);
   		$code = $scnmodel->GetRulesNO('mis_knowledge_type');
		$this->assign("code", $code);
		
		$m=M("mis_knowledge_type");
		$map["status"]=1;
		$knowleagetype=$m->where($map)->getField("id,name");
		$this->assign("knowleagetype",$knowleagetype);
	}
	/**
	 * (non-PHPdoc)
	 * deal 处理删除时候 提示子节点不能删除
	 * @see CommonAction::delete()
	 */
	public function delete(){
		$name = "MisKnowledgeType";
		$Model = D($name);
		$id = $_REQUEST['id'];
		$data['status'] = -1;
		$typeinfo = $Model->where("id = ".$id)->find();
		if($typeinfo['parentid'] == 0){
			$conu = $Model->where("status = 1 and parentid = ".$id)->count();
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