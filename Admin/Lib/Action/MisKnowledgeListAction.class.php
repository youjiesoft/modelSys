<?php
/**
 * @Title: MisKnowledgeListAction
 * @Package package_name
 * @Description: todo(知识管理的知识库的知识列表class)
 * @author xiafengqin
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-5-31 下午5:04:48
 * @version V1.0
 */
class MisKnowledgeListAction extends CommonAction {
	/**
	 * @Title: _filter
	 * @Description: todo(构造检索条件)
	 * @param unknown_type $map
	 * @author xiafengqin
	 * @date 2013-5-31 下午5:07:04
	 * @throws
	 */
	public function _filter(&$map){
		$map['mis_knowledge_list.status'] = 1;
		$_REQUEST ['orderField']="totop` desc,`updatetime";
		$_REQUEST ['orderDirection']="desc";
		if(!$_SESSION["user_knowledgedisplay"]) $map['status']=array("egt",$_SESSION['user_knowledgedisplay']);
		$map['status']=1;//状态
		$map['auditState']=3;//已审核
		$map['type']="Q";
		//分类
		if($_REQUEST["categoryid"]){
			$map['categoryid']=$_REQUEST["categoryid"];
			$this->assign("categoryid", $_REQUEST["categoryid"]);
		}
		//作者
		if($_REQUEST["createid"]){
			$map['createid']=$_REQUEST["createid"];
			$this->assign("createid", $_REQUEST["createid"]);
		}
		//所有分类(树形菜单)
		$m=M("mis_knowledge_type");
		$typelist = $m->where("status=1")->order("id asc")->getField("id,parentid");
		$typeTree = $this->getTree($typelist);
		$this->assign('knowleagetype',$typeTree);
		//条件搜索
		if($_POST['keyword']){
			$where['mis_knowledge_list.title'] = array('like','%'.$_POST['keyword'].'%');//标题
			$where['user.name'] = array('like','%'.$_POST['keyword'].'%');//作者
			$where['mis_knowledge_type.name'] = array('like','%'.$_POST['keyword'].'%');//分类
			//$where['levels'] 等级
			if($_POST['keyword'] == 'A' || $_POST['keyword'] == 'A级'){
				$where['levels'] = 1;
			}
			if($_POST['keyword'] == 'B' || $_POST['keyword'] == 'B级'){   
				$where['levels'] = 2;
			}
			if($_POST['keyword'] == 'C' || $_POST['keyword'] == 'C级'){
				$where['levels'] = 3;
			}
			if($_POST['keyword'] == 'D' || $_POST['keyword'] == 'D级'){
				$where['levels'] = 4;
			}
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
			$this->assign('keyword',$_POST['keyword']);
		}
	}

	public function index(){
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name = $this->getActionName();
		$qx_name=$name;
		if(substr($name, -4)=="View"){
			$qx_name = substr($name,0, -4);
		}
		//验证浏览及权限
		if( !isset($_SESSION['a']) ){
			$map=D('User')->getAccessfilter($qx_name,$map);	
		}
		$this->_list ( 'MisKnowledgeListView', $map);
		$scdmodel = D('SystemConfigDetail');
		$detailList = $scdmodel->getDetail($name);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		//searchby搜索扩展
		$searchby = $scdmodel->getDetail($name,true,'searchby');
		if ($searchby && $detailList) {
			$searchbylist=array();
			foreach( $detailList as $k=>$v ){
				if(isset($searchby[$v['name']])){
					$arr['id']= $searchby[$v['name']]['field'];
					$arr['val']= $v['showname'];
					array_push($searchbylist,$arr);
				}
			}
			$this->assign("searchbylist",$searchbylist);
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
	  
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		if( $_REQUEST['frame']==1){
			$this->display("index_notcat");
		}else{
			$this->display();
		}
		return;
	}
	/**
	 * @Title: _after_list
	 * @Description: todo(执行了CommonAction类里面的_list方法的后置函数)
	 * @param unknown_type $voList
	 * @author xiafengqin
	 * @date 2013-5-31 下午5:07:45
	 * @throws
	 */
	public function _after_list(&$voList){
		$model = D ( 'MisKnowledgeListView' );//本表（文章表）视图
		foreach($voList as $k => $v){
			$voList[$k]['content'] = $model->where('status = 1')->select();//文章
			$str = htmlspecialchars_decode($v['content'], ENT_QUOTES);//转码
			$str = trim(strip_tags(str_replace("&nbsp;", ' ', $str)));//过滤html
			//过滤长度
			if(strlen($str) > 200){
				$str = cut_str($str,200)."........";
			}
			$voList[$k]['content'] = $str;
		}
		//评论条数
		$countlist = array();
		foreach ($voList as $key => $val) {
			$map = array();
			$map['mis_knowledge_list.type']="C";
			$map['mis_knowledge_list.parentid']=$val["id"];
			$countlist[] = $model->where($map)->count('*');
		}
		$this->assign('countlist',$countlist);
		
	}
	/**
	 * @Title: _before_edit
	 * @Description: todo(打开修改页面前置函数)
	 * @author xiafengqin
	 * @date 2013-5-31 下午5:08:09
	 * @throws
	 */
	public function _before_edit(){
		$model=M("mis_knowledge_type");
		$list =$model->field("id,name")->select();
		$this->assign("categoryidlist",$list);
	}
	/**
	 * @Title: _before_add
	 * @Description: todo(打开新增页面前置函数)
	 * @author xiafengqin
	 * @date 2013-5-31 下午5:08:29
	 * @throws
	 */
	public function _before_add(){
		$showtpl=$_REQUEST["showtpl"];
		$this->assign("showtpl",$showtpl);
		$model=M("mis_knowledge_type");
		$list =$model->field("id,name")->select();
		$this->assign("categoryidlist",$list);
	}


	/**
	 * @Title: conments
	 * @Description: todo(评论)
	 * @author xiafengqin
	 * @date 2013-5-31 下午5:08:52
	 * @throws
	 */
	public function conments(){
		if($_POST["save"]==1){
			if(!$_POST["content"]) $this->error ( "请输入评论内容" );
			$name=$this->getActionName();
			$model = D ($name);
			if(C('TOKEN_NAME')) $_POST[C('TOKEN_NAME')]= $_SESSION[C('TOKEN_NAME')];
			if (false === $model->create ()) {
				$this->error ( $model->getError () );
			}
			$list=$model->add ();
			if (false !== $list) {
				$this->success ( L('_SUCCESS_'));
			}else {
				$this->error ( L('_ERROR_') );
			}
		}else{
			$this->assign("parentid",$_GET["id"]);
			$this->display();
		}
	}


	/**
	 * @Title: knowledgedo
	 * @Description: todo(置顶 高亮等)
	 * @author xiafengqin
	 * @date 2013-5-31 下午5:10:15
	 * @throws
	 */
	public function knowledgedo(){
		$name=$this->getActionName();
		$model = D ($name);
		if($_POST["save"]==1){
			$name=$this->getActionName();
			$model = D ($name);
			if(C('TOKEN_NAME')) $_POST[C('TOKEN_NAME')]= $_SESSION[C('TOKEN_NAME')];
			if (false === $model->create ()) {
				$this->error ( $model->getError () );
			}
			$list=$model->save ();  if (false !== $list) {
				$this->success ( L('_SUCCESS_'));
			}else {
				$this->error ( L('_ERROR_') );
			} 
		}else{
			$vo = $model->find($_GET["id"]);
			$this->assign("vo",$vo);
			$this->display();
		}
	}
	/* 
	public function lookupview(){
		$this->assign("id",$_REQUEST ["id"]);
		$this->display();
	} */
	/**
	 * @Title: view
	 * @Description: todo(查看里的相关信息)
	 * @author xiafengqin
	 * @date 2013-5-31 下午5:11:37
	 * @throws
	 */
	function view(){
		$model = D ( 'MisKnowledgeListView' );//本表（文章表）视图
		$id = $_REQUEST ["id"];
		$map1['mis_knowledge_list.id']=$id;
		if ($_SESSION["a"] != 1) $map1['mis_knowledge_list.status']=1;
		$vo = $model->where($map1)->find();
		if(empty($vo)){
			$this->display ("Public:404");exit;
		}

		$map2["status"]  =1;
		$map2["orderid"] =$_REQUEST["id"];
		$map2["type"] =33;
		$m=M("mis_attached_record");
		$attarry=$m->where($map2)->select();
		$this->assign('attarry',$attarry);
		$this->assign("vo",$vo);
		//查询条件($map3)|评论信息($conments)|评论条数($count)
		$map3['mis_knowledge_list.type']="C";
		$map3['mis_knowledge_list.parentid']=$vo["id"];
		//检索评论者
		if($_POST['lookname']){
			$map3['user.name'] = array('like','%'.$_POST['lookname'].'%');
			$this->assign('lookname', $_POST['lookname']);
		}
		$conments = $model->where($map3)->order('id desc')->select();
		$count = $model->where($map3)->count('*');
		$this->assign("conments",$conments);
		$this->assign("count",$count);
		//所有分类
		$typeModel = M("mis_knowledge_type");//文章分类表
		$list =$typeModel->field("id,name")->select();
		$this->assign("typeidlist",$list);
		//级别
		$this->assign("levels", array(1=>"A级",2=>"B级",3=>"C级",4=>"B级"));
		$this->display();
	}
	/**
	 * @Title: getTree
	 * @Description: todo(获得树)
	 * @param unknown_type $alldata
	 * @param unknown_type $pid
	 * @param unknown_type $i
	 * @return string
	 * @author xiafengqin
	 * @date 2013-5-31 下午5:12:17
	 * @throws
	 */
	public function getTree($alldata,$pid=0,$i=0){
		$m = M('mis_knowledge_type');
		$map["parentid"] = $pid;
		$map['status'] = 1;
		$data = $m->where($map)->order('id asc')->select();
		$html = '';
		foreach($data as $k => $v)
		{
			if( isset($alldata[$v['id']]) ){
				$html .= "<li><a class=\"proRel\" target=\"ajax\" rel=\"knowleagelistBox\" href='__URL__/index/frame/1/categoryid/$v[id]'>".$v['name']."</a>";
				$html .= $this->getTree($alldata,$v['id'],$i+1);
			}else{
				$html .= "<li><a class=\"proRel\" target=\"ajax\" rel=\"knowleagelistBox\" href='__URL__/index/frame/1/categoryid/$v[id]'>".$v['name']."</a>";
			}
			$html = $html."</li>";
		}
		if($i==0){
			return $html;
		}else{
			return $html ? '<ul>'.$html.'</ul>' : $html ;
		}
	}
}
?>