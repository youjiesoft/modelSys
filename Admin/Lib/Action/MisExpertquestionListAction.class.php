<?php
/**
 * @Title: MisExpertquestionListAction 
 * @Package package_name
 * @Description: todo(知识管理-专家库-问题列表) 
 * @author xiafengqin 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-5-31 下午4:21:31 
 * @version V1.0
 */
class MisExpertquestionListAction extends CommonAction {
	/**
	 * @Description: _filter(构造检索条件) 
	 * @param unknown_type $map  
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:23:20 
	 */
	public function _filter(&$map){
		//首页显示条件
		$map["status"] = 1;
		$map["type"] = "Q";
		$map["views"]= 1;
		$map['isynchronous'] = 0;
		if( $_SESSION['a']!=1) {
			$map["closedbyid"]=0;
		}
		
		//分类
		if( $_REQUEST['categoryid'] ){
			$map["categoryid"]=$_REQUEST['categoryid'];
			$this->assign("categoryid", $_REQUEST["categoryid"]);
		}
		
		//作者
		if($_REQUEST["createid"]){
			$map['createid']=$_REQUEST["createid"];
			$this->assign("createid", $_REQUEST["createid"]);
		}
		
		//我来解答
		if($_REQUEST["my"] == 1){
			$melmodel = D("MisExpertList");//专家表
			$melmap['userid']= $_SESSION[C('USER_AUTH_KEY')];
			$expertid = $melmodel->where($melmap)->getField('id',true);
			$map['expertid'] = array('in',$expertid);
		}
		
		//我的提问
		if($_REQUEST["my"] == 2){
			$map['createid']= $_SESSION[C('USER_AUTH_KEY')];
		}
		
		//我的回答
		$eqlmodel = D("MisExpertquestionList");//问题表（本表）
		if($_REQUEST["my"] == 3){
			$eqlmap['createid']= $_SESSION[C('USER_AUTH_KEY')];
			$parentid = $eqlmodel->where($eqlmap)->getField('parentid',true);
			$map['id']= array('in',$parentid);
		}
		
		//关闭问题 
		if($_REQUEST["my"] == 4){
			$mapE['createid']= $_SESSION[C('USER_AUTH_KEY')];
			$mapE['type']= 'NOTE';
			$closereason = $eqlmodel->where($mapE)->getField('closereason',true);
			$map['id']= array('in',$closereason);
		}
		
		//所有分类
		$modeltype=M("mis_expert_question_type");
		$list =$modeltype->where("status=1")->getField("id,name");
		$this->assign("typeidlist",$list);
		
		//搜索
		if($_POST['keywordindex']){
			$where['mis_expert_question_list.title'] = array('like','%'.$_POST['keywordindex'].'%');//标题
			$where['user.name'] = array('like','%'.$_POST['keywordindex'].'%');//作者
			$where['mis_expert_question_type.name'] = array('like','%'.$_POST['keywordindex'].'%');//分类
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
			$this->assign('keywordindex',$_POST['keywordindex']);
		}
	}
	/** 
	 * @Description: add(对应TPL的Add方法)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:01:45 
	*/  
	public function add() {
		//添加问题来源类型--应用于任务管理--提问功能--2013-07-23 jiangx
		if (!$_REQUEST['sourcetype']) {
			$_REQUEST['sourcetype'] = 0;
		}
		$this->assign('sourceid', $_REQUEST['sourceid']);
		$this->assign('sourcetype', $_REQUEST['sourcetype']);
		
		$modeltype=M("mis_expert_question_type");
		$list =$modeltype->field("id,name")->select();
		$this->assign("typeidlist",$list);
		if($_GET['parentid']) $this->assign("parentid",$_GET['parentid']);
		$this->assign("type","Q");
		$scdmodel = D('SystemConfigDetail');
		$modelname = $this->getActionName();
		$detailList = $scdmodel->getDetail($modelname,false);
		if ($detailList) {
			$fieldsarr = array();
			foreach ($detailList as $k => $v) {
				$showname = '';
				if($v['status'] != -1){
					$showMethods = "";
					if($v['methods']){
						$methods = explode(';', $v['methods']);// 分解所有方法
						$normArray = $sclmodel->getNormArray();// 中文解析
						$showMethods .= "<span class='xyminitooltip'><span class='xyminitooltip_con'>";
						//$showname .= "<span class='xyminitooltip'><span class='xyminitooltip_con'>";
						$isfalse = false;
						foreach ($methods as $key => $vol) {
							if ($isfalse) {
								//$showname .= " | ";
								$showMethods .= " | ";
							}
							$volarr = explode(',', $vol);// 分解target和方法
							$target = $volarr[0];// 弹出方式
							$method = $volarr[1];// 方法名称
							$modelarr = explode('/', $method);// 分解方法0：model；1：方法
							if ($_SESSION[strtolower($modelarr[0].'_'.$modelarr[1])] || $_SESSION["a"]) {
								$showMethods .= "<a rel='".$modelarr[0].$modelarr[1]."' target='".$target."' href='__APP__/".$method."' mask='true'>".$normArray[$modelarr[1]]."</a>";
								$isfalse = true;
							}
							//$showname .= "<a rel='".$modelarr[0].$modelarr[1]."' target='".$target."' href='__APP__/".$method."' mask='true'>".$normArray[$modelarr[1]]."</a>";
							$isfalse = true;
						}
						if($showMethods){
							$showMethods .= "<span class='xyminitooltip_arrow_outer'></span><span class='xyminitooltip_arrow'></span></span></span>";
						}
					}
					if($showMethods){
						$showname .= $showMethods;
					}
					if ($v['models']) {
						if ($_SESSION[strtolower($v['models'].'_index')] || $_SESSION["a"]) {
							$showname .= "<a rel='".$v['models']."' target='navTab' href='__APP__/".$v['models']."/index'>".$v['showname']."</a>";
						} else {
							$showname .= $v['showname'];
						}
					} else{
						$showname .= $v['showname'];
					}
				}
				$fieldsarr[$v['name']] = $showname;
			}
			$this->assign ( 'fields', $fieldsarr );
		}
		$mrdmodel = D('MisRuntimeData');
		$data = $mrdmodel->getRuntimeCache($modelname,'add');
		$this->assign("data",$data);
		//查询分类
		$misEQtypeModel=D("MisExpertQuestionType");
		$typelist=$misEQtypeModel->where("pid=0 and status=1")->select();
		//执行过滤 没有子级将会被过滤掉
		$newtypelist = array();
		foreach($typelist as $val){
			$erex = $misEQtypeModel->where("pid=".$val['id']." and status=1")->getField("id");//只要有一条就算有
			if($erex){
				array_push($newtypelist,$val);
			}
		}
		$typelist = $newtypelist;
		$ptypelist=$misEQtypeModel->where("pid=".$typelist[0]['id']." and status=1")->select();
		$this->assign("typelist",$typelist);
		$this->assign("ptypelist",$ptypelist);
		// 从专家页面过来
		if($_GET['id']){
			$this->assign("expertid",$_GET['id']);
			$this->display ('consultingAdd');
		} else {
			$this->display ();
		}
	}
	/**
	 * @Description: index(通过视图进入首页)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:25:25 
	 */
	public function index() {
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$this->common();
		$name = $this->getActionName();
		/* $model = D($name);
		$mislist = $model->getField('expertid');
		
		$meModel = D('MisExpertList');//专家列表
		$userlist = $meModel->where('id = '.$mislist['expertid'])->getField();
		echo $meModel->getLastSql();
		$this->assign('userlist',$userlist); */
		$qx_name=$name;
		if(substr($name, -4)=="View"){
			$qx_name = substr($name,0, -4);
		}
		//验证浏览及权限
		if( !isset($_SESSION['a']) ){
			$map=D('User')->getAccessfilter($map,'mis_expert_list');	
		}
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
		$this->_list ( 'MisExpertquestionListView', $map );
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		//首页收件箱调用方法，为ajax调用
		if ($_GET['type'] == "ajaxcall") {
			$this->display ("ajax_index");exit;
		}
		
		if( intval($_POST['dwzloadhtml']) ){$this->display("dwzloadindex");exit;}
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
	 * @date 2013-5-31 下午4:25:44 
	 * @throws
	 */
	function _after_list(&$voList){
		$uservModel = D('MisHrPersonnelPersonInfoView');//用户表（视图）
		$mklModel = D('MisExpertquestionListView');//问题表  视图
		$eqlmodel = D('MisExpertquestionList');//问题表 
		foreach ($voList as $k => $v) {
			$voList[$k]['acount'] = $mklModel->where('createid = '.$v["userid"])->count('id');//文章
			$str = htmlspecialchars_decode($v['content'], ENT_QUOTES);//转码
			$str = trim(strip_tags(str_replace("&nbsp;", ' ', $str)));//过滤html
			//过滤长度
			if(strlen($str) > 100){
				$str = cut_str($str,100)."........";
			}
			$voList[$k]['content'] = $str;
			
			//解答专家
			$meModel = D('MisExpertList');//专家列表
			$userid = $meModel->where('id = '.$v['expertid'])->getField('userid');
			$voList[$k]['expert'] = getUserName($userid);
			
			//全部回答条数
			$map = array();
			$map['mis_expert_question_list.type']="A";
			$map['mis_expert_question_list.parentid']=$v["id"];
			$voList[$k]['count'] = $mklModel->where($map)->count('*');
			
			//关闭说明
			if($v['closedbyid']){
				$map5['type']= 'NOTE';
				$map5['id'] = $v['closedbyid'];
				$colsContent= $eqlmodel->where($map5)->getField('content');
				$voList[$k]['closedbycontent'] = $colsContent;
			}
		}
		
	}
	/**
	 * @Title: _after_edit 
	 * @Description: todo(打开修改页面后置函数) 
	 * @param unknown_type $vo  
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:26:10 
	 * @throws
	 */
	public function _after_edit($vo){
		if($vo["type"]=="Q"){
			$modeltype=M("mis_expert_question_type");
			$list =$modeltype->getField("id,name");
			$this->assign("typeidlist",$list);
			$vo["content"]=htmlentities(stripslashes($vo["content"]),ENT_COMPAT,"UTF-8");
		}else if($vo["type"]=="A" || $vo["type"]=="C"){
			$model = D ("MisExpertquestionList");
			$vo =$model->find($_GET["id"]);
			$this->assign("vo",$vo);
			$this->assign("type",$vo['type']);
			$this->assign("parentid",$vo["parentid"]);
			$this->display("reply");
			exit;
		}
	}
	
	/**
	 * @Description: _before_edit(进入修改)   
	 * @author laicaixia 
	 * @date 2013-8-13 下午1:42:01 
	*/  
	public function _before_edit(){
		//取出 咨询专家
		$elModel = D('MisExpertquestionList');//问题列表
		$elMap['id'] = $_REQUEST['id'];
		$elList = $elModel->where($elMap)->find();
		$meModel = D('MisExpertList');//专家列表
		$meMap['id'] = $elList['expertid'];
		$expert = $meModel->where($meMap)->field('id,userid')->find();
		$this->assign("expert",$expert);
		//查询分类
		$misEQtypeModel=D("MisExpertQuestionType");
		$typelist=$misEQtypeModel->where("pid=0 and status=1")->select();
		$ptypelist=$misEQtypeModel->where("id=".$elList['categoryid'])->select();
		$this->assign("typelist",$typelist);
		$this->assign("ptypelist",$ptypelist);
		$this->assign("dafaultypeid",$ptypelist[0]['pid']);
		//获取附件信息
		$this->getAttachedRecordList($_REQUEST["id"]);
	}	
	/**
	 * @Title: closequestion 
	 * @Description: todo(关闭问题)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:27:40 
	 * @throws
	 */
	public function closequestion(){
		if($_POST["save"]==1){
			$model = D ("MisExpertquestionList");
			if(C('TOKEN_NAME')) $_POST[C('TOKEN_NAME')]= $_SESSION[C('TOKEN_NAME')];
			if (false === $model->create ()) {
				$this->error ( $model->getError () );
			}
			$list=$model->add ();
			if (false !== $list) {
				$model->where("id=".$_POST["closereason"])->setField("closedbyid",$list);
				$this->success ( L('_SUCCESS_'));
			}else {
				$this->error ( L('_ERROR_') );
			}
		}else{
			$this->assign("closereason",$_GET["id"]);
			$this->display();
		}
	}
	
	/**
	 * @Title: conments 
	 * @Description: todo(评论)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:53:15 
	 * @throws
	 */
	public function conments(){
		if($_POST["save"]==1){
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
	 * @Title: showquestion 
	 * @Description: todo(显示问题)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:54:16 
	 * @throws
	 */
	public function showquestion(){
		$name=$this->getActionName();
		$model = D ( $name );
		$vo = $model->find($_POST["id"]);
		$rel1 = $model->where("id=".$vo["closedbyid"])->delete();
		$rel2 = $model->where("id=".$_POST["id"])->setField("closedbyid",0);
		if ($rel1 && $rel2 ) {
			$this->success ( L('_SUCCESS_'));
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	/**
	 * 
	 * @Title: _after_insert 
	 * @Description: todo(插入前置函数) 
	 * @param unknown_type $insertid  
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:55:24 
	 * @throws
	 */
	public function _after_insert( $insertid){
		$this->swf_upload($insertid,33);//上传附件
		if($_POST["type"]=="A"){
			$model = D ("MisExpertquestionList");
			$re = $model->where('id='.$_POST["parentid"])->setInc('acount');
			if( !$re ) $this->error( L("_ERROR_"));
		}
	}
	/**
	 * @Description: reply(回答)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:56:21 
	 */
	public function reply(){
		if(!$_GET["id"]) $this->error("请刷新页面重试!");
		$this->assign("type","A");
		$this->assign("parentid",$_GET["id"]);
		$this->display();
	}
	/**
	 * @Description: reply(完善回答)   
	 * @author laicaixia 
	 * @date 2013-9-7 下午4:56:21 
	 */
	public function replyedit(){
		$modelC = D ( 'MisExpertquestionList' );//本表（问题表）
		$map['id'] = $_REQUEST ["id"];
		$data = array(
			'content' => $_POST['content'],
		);
		$list = $modelC->where($map)->save($data);
		if ($list) {
			$this->success ( L('_SUCCESS_'));
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	/**
	 * @Title: update 
	 * @Description: todo(修改保存函数)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午4:58:46 
	 * @throws
	 */	
	public function update(){
		$name=$this->getActionName();
		$model = D ( $name );
		//最佳答案
		if(C('TOKEN_NAME')) $_POST[C('TOKEN_NAME')]= $_SESSION[C('TOKEN_NAME')];
		$map['type'] = 'A';
		$map['parentid'] = $_POST['id'];
		$model->where($map)->setField('selchildid',0);
		$map['id'] = $_POST['selchildid'];
		$list = $model->where($map)->setField('selchildid',$_POST['id']);
		$this->swf_upload($_POST['id'],33);
		if (false !== $list) {
			$this->success ( L('_SUCCESS_'));
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	/**
	 * @Title: lookupview 
	 * @Description: todo(查看里的相关信息)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:00:31 
	 * @throws
	 */
	function view(){
		$modelM = D ( 'MisExpertquestionListView' );//本表（所有问题表）视图
		$modelC = D ( 'MisExpertquestionList' );//本表（所有问题表）
		$id = $_REQUEST ["id"];
		$this->assign("id",$_REQUEST ["id"]);
        $map['mis_expert_question_list.id']=$id;
        if ($_SESSION["a"] != 1) $map['mis_expert_question_list.status']=1;
		$vo = $modelM->where($map)->find();
		if(empty($vo)){$this->display ("Public:404");exit;}
		$vo["content"]=stripslashes($vo["content"]);
		if($vo["closedbyid"]) $vo['closereason'] = $modelM->where("id=".$vo["closedbyid"])->getField("content,askto");
		$this->assign("vo",$vo);
		//回答内容
		$map2['mis_expert_question_list.type']="A";
        $map2['mis_expert_question_list.parentid']=$vo["id"];
		if( !$_SESSION['a'] ) $map2["mis_expert_question_list.closedbyid"]=0;
		//回答的详细信息($anserlist)
		$anserlist= $modelM->where($map2)->order("selchildid desc,id desc")->select();
		//检索回答作者
		if($_POST['lookname']){
			$map2['user.name'] = array('like','%'.$_POST['lookname'].'%');
			$this->assign('lookname', $_POST['lookname']);
		}
		 //关闭说明
		$map5['type']="NOTE";
		$map5['closereason']=$vo["id"];
		if( !$_SESSION['a'] ) $map5["id"]=$vo["closedbyid"];
		$colsVO= $modelC->where($map5)->find();
		$this->assign("colsVO",$colsVO); 
		//评论、追问的相关信息
		foreach($anserlist as $k=>$v){
			//评论信息
			$map3=array();
			$map3["mis_expert_question_list.parentid"]=$v["id"];
			$map3["mis_expert_question_list.type"]="C";
			if( !$_SESSION['a'] ) $map3["mis_expert_question_list.closedbyid"]=0;
			$childrenlist= $modelM->where($map3)->order('id desc')->select();
			$anserlist[$k]["content"]=stripslashes($v["content"]);
			$anserlist[$k]["user"]=getFieldby($v["createid"],"id","name","user");
			if($childrenlist){
				foreach($childrenlist as $k1=>$v1){
					$childrenlist[$k1]["content"]=stripslashes($v1["content"]);
					$childrenlist[$k1]["user"]=getFieldby($v1["createid"],"id","name","user");
				}
			}
			//评论详细信息
			$anserlist[$k]["children"] = $childrenlist;
			//评论条数
			$anserlist[$k]["conmentsconut"] = count($childrenlist);
			//追问信息
			$map4=array();
			$map4["id"]=$v["askid"];
			$map4["type"]="ASK";
			$map4["closedbyid"]=0;
			$asktolist= $modelC->where($map4)->select();
			$anserlist[$k]["askto"]=stripslashes($v["askto"]);
			//$anserlist[$k]["user"]=getFieldby($v["createid"],"id","name","user");
			if($asktolist){
				foreach($asktolist as $k2=>$v2){
					$asktolist[$k2]["askto"]=stripslashes($v2["askto"]);
					//$asktolist[$k1]["user"]=getFieldby($v1["createid"],"id","name","user");
				}
				$anserlist[$k]["askfo"]=$asktolist;	
			}
		}
		$this->assign("anserlist",$anserlist);
		//共{$acount}个回答
		$acount = $modelM->where($map2)->count('*');
		$this->assign("acount",$acount);
		//所有分类
		$model1=M("mis_expert_question_type");
		$list =$model1->field("id,name")->select();
		$this->assign("typeidlist",$list);
		if ($vo['sourcetype'] == 1) {
			//查看关注
			$attentModel = D("MisTaskAttention");
			$map = array();
			$map['tableid'] = $id;
			$map['modelname'] = "MisExpertquestionList";
			$map['type'] = 5;
			$attent = $attentModel->where($map)->find();
			$this->assign('attent', $attent);
		}
		
		$this->display("lookupview");
	}
	/**
	 * @Description: askto(继续追问)
	 * @author liacaixia
	 * @date 2013-9-3 下午2:56:21
	 */
	public function askto(){
		if($_POST["save"]==1){
			$name=$this->getActionName();
			$model = D ($name);
			if(C('TOKEN_NAME')) $_POST[C('TOKEN_NAME')]= $_SESSION[C('TOKEN_NAME')];
			if (false === $model->create ()) {
				$this->error ( $model->getError () );
			}
			$list=$model->add ();
			if (false !== $list) {
				$model->where("id=".$_POST["parentid"])->setField("askid",$list);//追问 id等于1,表示些条回答有追问，否则反之；
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
	 * @Description: askedit(修改追问)
	 * @author liacaixia
	 * @date 2013-9-3 下午2:56:21
	 */
	public function askedit(){
		$model = D ('MisExpertquestionList');
		$map['id'] = $_REQUEST['parentid'];
		//修改追问内容
		$data = array(
			'askto' => $_POST['askto'],
		);
		$list = $model->where($map)->save($data);
		if (false !== $list) {
			$this->success ( L('_SUCCESS_'));
		}else {
			$this->error ( L('_ERROR_') );
		}
	}
	/**
     * @Title: lookupSetAttention
     * @Description: todo(加关注)
     * @author jiangx
     * @date 2013-7-24 下午4:15:10
     * @throws
     */
    public function lookupSetAttention(){
    	if (!$_POST['modelname']) {
    		exit('-1');
    	}
    	$map['tableid'] = $_POST['tableid'];
    	$map['modelname'] = $_POST['modelname'];
		$map['type'] = $_POST['type'];
    	$AttentModel = D("MisTaskAttention");
    	$result = $AttentModel->where($map)->find();
    	if (!$result) {
    		//添加关注
    		$_POST['status'] = 1;
    		C ( "TOKEN_ON", false );
    		if (false === $AttentModel->create ()) {
    			$this->error ( $AttentModel->getError () );
    		}
    		//保存表头信息
    		$list = $AttentModel->add ();
    		$this->transaction_model->commit();//事务提交
    		C ( "TOKEN_ON", true );
    		if ($list === false) {
    			exit('-1');
    		}
    		exit('1');
    	} else {
    		//修改关注
    		$status = $result['status'] == 1 ? 0 : 1;
    		$AttentModel->where($map)->setField('status', $status);
    		$this->transaction_model->commit();//事务提交
    		echo $status;
    		eixt;
    	}
    }
	
	/**
	 * @Title: lookup 
	 * @Description: todo(带回查找)   
	 * @author xiafengqin 
	 * @date 2013-5-31 下午5:00:49 
	 * @throws
	 */
	function lookup(){
		//检索专家
		$searchbylist=array(array("id" =>"code","val"=>"编号"),array("id" =>"typename","val"=>"分类"),array("id" =>"name","val"=>"专家名称"));
		$searchtypelist=array(array("id" =>"2","val"=>"模糊查找"),array("id" =>"1","val"=>"精确查找"));
		$this->assign("searchbylist",$searchbylist);
		$this->assign("searchtypelist",$searchtypelist);
		$searchby= $_POST['searchby'];
		$searchtype= $_POST['searchtype'];
		$keyword= $_POST['keyword'];
		if( $searchby )$this->assign('searchby', $searchby);
		if( $searchtype )$this->assign('searchtype', $searchtype);
		if( $keyword )$this->assign('keyword', $keyword);
		if ($keyword){
			$map1[$searchby] = ($searchtype==2) ? array('like',"%".$keyword."%"):$keyword;
		}
		//显示对专家提问列表
		$modelD=D("MisExpertListView");
		$map1["mis_expert_list.status"]=1;
		$list =$modelD->where($map1)->select();
		$this->assign("list",$list);
		$this->display ();
	}
	
	public function common(){
		$eqlmodel = D("MisExpertquestionList");//问题表（本表）
		//我的提问条数
		$mapQ['createid']= $_SESSION[C('USER_AUTH_KEY')];
		$mapQ['type']= "Q";
		$MyQuestions = $eqlmodel->where($mapQ)->count('*');
		$this->assign("MyQuestions",$MyQuestions);
		//我的回答条数
		$mapP['createid']= $_SESSION[C('USER_AUTH_KEY')];
		$parentid = $eqlmodel->where($mapP)->getField('parentid',true);
		$mapA['id']= array('in',$parentid);
		$mapA['type']= "Q";
		$MyAnwer = $eqlmodel->where($mapA)->count('*');
		$this->assign("MyAnwer",$MyAnwer);
		//关闭问题 条数
		$mapC['createid']= $_SESSION[C('USER_AUTH_KEY')];
		$mapC['type']= "NOTE";
		$ClosedQuestions = $eqlmodel->where($mapC)->count('*');
		$this->assign("ClosedQuestions",$ClosedQuestions);
		//关闭说明
		if ($_SESSION["a"] != 1) $map['status']=1;
		$eqlVO = $eqlmodel->where($map)->find();
		$map5['type']="NOTE";
		$map5['parentid']=$eqlVO["id"];
		if( !$_SESSION['a'] ) $map5["id"]=$eqlVO["closedbyid"];
		$colsVO= $eqlmodel->where($map5)->find();
		$this->assign("colsVO",$colsVO);
	}
	/**
	 * @Title: lookupgetexpertquestiontype 
	 * @Description: todo(ajax获取类型)   
	 * @author libo 
	 * @date 2014-4-15 下午4:10:17 
	 * @throws
	 */
	public function lookupgetexpertquestiontype(){
		$bepart=$_POST['bepart'];
		$Model = D('MisExpertQuestionType');
		$userlist=$Model->where("pid=".$bepart.' and status=1')->field("id,name")->select();
		$arr2=array();
		foreach($userlist as $k=>$v){
			$arr2[$k][]=$v['id'];
			$arr2[$k][]=$v['name'];
		}
		if($arr2){
			echo json_encode($arr2);
		} else {
			echo -1;
		}
	}
}
?>