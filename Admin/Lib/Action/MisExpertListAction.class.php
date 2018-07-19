<?php
/** 
 * @Title: MisExpertListAction 
 * @Package package_name
 * @Description: todo(专家列表的class) 
 * @author 杨东 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-5-31 下午3:05:30 
 * @version V1.0 
*/ 
class MisExpertListAction extends CommonAction {
	/** 
	 * @Title: _filter 
	 * @Description: todo(构造检索条件) 
	 * @param unknown_type $map  
	 * @author 杨东 
	 * @date 2013-5-31 下午3:05:39 
	 * @throws 
	*/  
	public function _filter(&$map){
		$map['mis_expert_list.status'] = 1;
		if($_POST['keyword']){
			//名称(userid)|类型(typeid)|部门(deptname)
			$map['mis_expert_list.name'] = array('like','%'.$_POST['keyword'].'%');//名称(userid)
			//$where['mis_system_department.name'] = array('like','%'.$_POST['keyword'].'%');//部门(deptname)
			//$where['mis_expert_question_type.name'] = array('like','%'.$_POST['keyword'].'%');//类型(typeid)
			//$where['_logic'] = 'or';
			//$map['_complex'] = $where;
			$this->assign('keyword',$_POST['keyword']);
		}
	}
	/**
	 * @Title: index 
	 * @Description: todo(对应TPL模版的index页面)   
	 * @author  
	 * @date 2013-5-31 下午4:09:58 
	 * @throws
	 */
	public function index() {
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
// 		$misModel = D('MisExpertList');
// 		$misVO = $misModel->select();
// 		$this->assign('misVO',$misVO);
		$name = $this->getActionName();
		$qx_name=$name;
		if(substr($name, -4)=="View"){
			$qx_name = substr($name,0, -4);
		}
		//验证浏览及权限
		if( !isset($_SESSION['a']) ){
			if( $_SESSION[strtolower($qx_name.'_'.ACTION_NAME)]!=1 ){
				if( $_SESSION[strtolower($qx_name.'_'.ACTION_NAME)]==2 ){////判断部门及子部门权限
					$map["mis_expert_list.createid"]=array("in",$_SESSION['user_dep_all_child']);
				}else if($_SESSION[strtolower($qx_name.'_'.ACTION_NAME)]==3){//判断部门权限
					$map["mis_expert_list.createid"]=array("in",$_SESSION['user_dep_all_self']);
				}else if($_SESSION[strtolower($qx_name.'_'.ACTION_NAME)]==4){//判断个人权限
					$map["mis_expert_list.createid"]=$_SESSION[C('USER_AUTH_KEY')];
				}
			}
		}
		$this->_list ( 'MisExpertListView', $map );
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
		//首页收件箱调用方法，为ajax调用
		if ($_GET['type'] == "ajaxcall") {
			$this->display ("ajax_index");exit;
		}
		$this->display ();
		return;
	}
	/**@Title: _after_list 
	 * @Description: todo(执行了CommonAction类里面的_list方法的后置函数) 
	 * @param unknown_type $voList  
	 * @author 杨东 
	 * @date 2013-5-31 下午3:05:48 
	 * @throws 
	*/  
	function _after_list(&$voList){
		$uservModel = D('MisHrPersonnelPersonInfoView');//用户表（视图）
		$mklModel = D('MisKnowledgeList');//文章表
		foreach ($voList as $k => $v) {
			$voList[$k]['acount'] = $mklModel->where('createid = '.$v["userid"] . " and status = 1 and auditState = 3")->count('id');//文章
		}
	}
	public function _before_update(){
		$ypwd=$_REQUEST['ypassword'];
		$picpath=$_REQUEST['swf_upload_misexpertlist_add_name'];
		if(!empty($picpath)){
			$_POST['picpath']=$_REQUEST['swf_upload_misexpertlist_add_name'];
		}else{
			$_POST['picpath']=$_REQUEST['ypicpath'];
		}
		if(!empty($_REQUEST['password'])){
			$email=array($_POST['email']);
			//邮箱发送
			$title="[特米洛企业信息化管理平台]请查收您的用户信息";
			$content="亲爱的用户，您好！<br/> 您在[特米洛企业信息化管理平台]修改信息如下: <br/>陆名为:'".$_POST['account']."'";
			$content.="<br/>密码为: '".$_REQUEST['password']."' <br/>";
			$vo['name'] = C("EMAIL_SERVERNAME");
			$vo['address'] ="brianl_yang";
			$vo['server'] = "163.com";
			$vo['email'] = C("EMAIL_SERVERADDRESS");
			$vo['pop3'] = "pop.163.com";
			$vo['smtp'] = "smtp.163.com";
			$vo['password'] =C("EMAIL_PASSWORD");
			$vo['pop3port']=110;
			$vo['smtpport']=25;
			$result = $this->SendEmail($title, $content, $email, "", $vo, 1);
			$_POST['password']=md5($_REQUEST['password']);
		}else{
			$_POST['password']=$ypwd;
		}
	}

	/**@Title: _before_edit 
	 * @Description: todo(打开修改页面前置函数)   
	 * @author 杨东 
	 * @date 2013-5-31 下午3:05:54 
	 * @throws 
	*/  
	public function _before_edit(){
		$id = $_REQUEST['id'];
		//专家经验
		$MisExpertExperienceModel = D("MisExpertExperience");
		//专家类型
		$MisExpertTypeModel=D("MisExpertType");
		//专家
		$MisExpertListModel = D("MisExpertList");
//临时使用		
// // 		//默认父级
// 		$typelist=$MisExpertTypeModel->where("status = 1 and pid = 0")->field('id ,name')->select();
// 		$this->assign("typelist",$typelist);
// 		//默认子级
// 		$defaulpid = $typelist[0]['id'];
// 		$sontypelist=$MisExpertTypeModel->where("status = 1 and pid =".$defaulpid)->field('id ,name')->select();
// 		$this->assign('sontypelist',$sontypelist);
		
//临时使用
//备用		
// 		//得到子级
// 		$expertinfo = $MisExpertListModel->where("id = ".$id)->find();
// 		$sonid = $expertinfo['typeid'];
// 		$this->assign('sonid',$sonid);
// 		$fathid = getFieldBy($sonid, 'id', 'pid', 'mis_expert_type');
// 		$this->assign('fatherid',$fathid);
		//默认父级
		$typelist = $MisExpertTypeModel->where("status = 1 and pid = 0")->field('id,name')->select();
		$this->assign('typelist',$typelist);
		//默认子级
// 		$sontypelist = $MisExpertTypeModel->where("status = 1 and pid = ".$fathid)->field('id,name')->select();
// 		$this->assign('sontypelist',$sontypelist);
//备用		
		//专家列表
		//$MisExpertListModel = D("MisExpertList");
		$vo = $MisExpertListModel->where("id = ".$id)->find();
		$this->assign('vo',$vo);
		//默认分类
		
		$experlist = $MisExpertExperienceModel->where("expertid=".$id)->select();
// 		echo $MisExpertExperienceModel->getLastSql();
		$this->assign("experlist",$experlist);
		//当前时间
		$this->assign('currtimesotr',time());
		$this->assign('currtime',Date('Y-m-d'));
		//制单人
		$this->assign('currper',getFieldBy($_SESSION[C('USER_AUTH_KEY')], 'id', 'name', 'User'));
		$this->assign('currperid',$_SESSION[C('USER_AUTH_KEY')]);
	}

	public function lookupmanage(){
		$model= M('mis_system_department');
		$deptlist = $model->where("status=1")->order("id asc")->select();
		$param['rel']="positiveBox";
		$param['url']="__URL__/lookupmanage/jump/1/deptid/#id#/parentid/#parentid#";
		$typeTree = $this->getTree($deptlist,$param);
		$this->assign('tree',$typeTree);
		$map = array();
		$searchby = str_replace("-", ".", $_POST["searchby"]);
		$keyword=$this->escapeChar($_POST["keyword"]);
		$searchtype = $_POST['searchtype'];
		if($_POST["keyword"]){
			$map[$searchby] = ($searchtype==2)  ? array('like','%'.$keyword.'%'):$keyword;
			$this->assign('keyword',$keyword);
			$searchby = str_replace(".", "-", $_POST["searchby"]);
			$this->assign('searchby',$searchby);
			$this->assign('searchtype',$searchtype);
		}
		$searchby=array(
				array("id" =>"mis_hr_personnel_person_info-name","val"=>"按员工姓名"),
				array("id" =>"orderno","val"=>"按员工编号"),
		);
		$searchtype=array(array("id" =>"2","val"=>"模糊查找"),
				array("id" =>"1","val"=>"精确查找"));
		$this->assign("searchbylist",$searchby);
		$this->assign("searchtypelist",$searchtype);
		$map['working'] = 1; //在职
		$map['mis_hr_personnel_person_info.status'] = 1; //正常
		// 		$map['positivestatus']=1; //转正
		$deptid		= $_REQUEST['deptid'];
		$parentid	= $_REQUEST['parentid'];
		if ($deptid && $parentid) {
			$deptlist =array_unique(array_filter (explode(",",$this->downAllChildren($deptlist,$deptid))));
			$map['mis_hr_personnel_person_info.deptid'] = array(' in ',$deptlist);
		}
		$common=A("Common");
		$common->_list('MisHrPersonnelAppraisalInfoView',$map);
		$this->assign('deptid',$deptid);
		$this->assign('parentid',$parentid);
		if ($_REQUEST['jump']) {
			$this->display('lookupmanagelist');
		} else {
			$this->display("lookupmanage");
		}
	}
	/**
	 * @Title: savedata 
	 * @Description: todo(保存修改数据)   
	 * @author yuansl 
	 * @date 2014-4-9 下午1:05:17 
	 * @throws
	 */
// 	public function edit(){
	
// 	}
	/**@Title: _after_edit 
	 * @Description: todo(打开修改页面后置函数) 
	 * @param unknown_type $vo  
	 * @author 杨东 
	 * @date 2013-5-31 下午3:05:56 
	 * @throws 
	*/  
	public function _after_edit($vo){
		$model=M("mis_system_department");
		$map["status"]=1;
		$deplist = $model->where($map)->getField("id,name");
		$this->assign("deplist", $deplist);
		
		$model=M("user");
		$userinfo = $model->find($vo["userid"]);
		$melModel = D('MisExpertList');//专家表
		$mmap['status'] = 1;
		if($_GET['id']){
			$mmap['id'] = array('neq',$_GET['id']);
		}
		$melList = $melModel->where($mmap)->getField('userid',true);
		if($melList){
			$map['id'] = array('not in',$melList);
		}
		$map["dept_id"]=$userinfo["dept_id"];
		$list =$model->where($map)->getField("id,name");
		$this->assign("useridlist",$list);
		$this->assign("dep_id",$userinfo["dept_id"]);
	}
	public function lookuploadimg(){
		//添加成功后，临时文件夹里面的文件转移到目标文件夹
		$fileinfo=pathinfo($_POST['upload_name']);
		$from = UPLOAD_PATH_TEMP.$_POST['upload_name'];//临时存放文件
		if( file_exists($from) ){
			$p=UPLOAD_PATH.$fileinfo['dirname'];// 目标文件夹
			if( !file_exists($p) ) {
				$this->createFolders($p); //判断目标文件夹是否存在
			}
			$to= UPLOAD_PATH.$_POST['upload_name'];
			rename($from,$to);
			echo $_POST['upload_name'];
		}
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::delete(重写delete方法,删除专家信息)
	 */
	public function delete(){
		$MisExpertListModel = D("MisExpertList");
		$MisExpertExperienceModel = D("MisExpertExperience");
		$MisExpertQuestionListModel = D("MisExpertQuestionList");
		$data['status'] = -1;
		$ida = explode(',',$_REQUEST['id']);
		//删专家表
		$mapa['id'] = array('in',$ida);
		$rea = $MisExpertListModel->where($mapa)->save($data);
		$MisExpertListModel->commit();
// 		dump($rea);
		//删专家经验表
		$mapb['expertid'] = array('in',$ida);
		$reb = $MisExpertExperienceModel->where($mapb)->save($data);
// 		echo $MisExpertExperienceModel->getLastSql();
		$MisExpertExperienceModel->commit();
// 		dump($reb);
		//删专家问题表
		$userida = array();
		foreach($ida as $val){
			$val['userid'] = getFieldBy($val, 'id', 'userid', 'mis_expert_list');
			array_push($userida,$val['userid']);
		}
		$mapc['createid'] = array('in',$userida); 
		$rec = $MisExpertQuestionListModel->where($mapc)->save($data);
		$MisExpertQuestionListModel->commit();
// 		dump($rec);
		if($rea){
			$this->success("操作成功");
		}else{
			$this->error("操作失败");
		}
		
	}
	/**
	 * @Title: lookupsontype 
	 * @Description: todo(ajax 获取子级分类)   
	 * @author yuansl 
	 * @date 2014-4-22 下午9:19:44 
	 * @throws
	 */
	public function lookupsontype(){
		$pid = $_REQUEST['bepart'];
		$MisExpertTypeModel = D("MisExpertType");
		$sontypelist = $MisExpertTypeModel->where("status =1 and pid = ".$pid)->field("id,name")->select();
		$newsontypelist = array();
		$temp =array();
		$newsontypelist =array();
		foreach($sontypelist as $vcte){
			$temp[0] = $vcte['id'];
			$temp[1] = $vcte['name'];
			array_push($newsontypelist,$temp);
			//清空
			$temp = array();
		}
// 		dump($newsontypelist);
		echo json_encode($newsontypelist);
	}
	/**
	 * @Title: _before_add 
	 * @Description: todo(新增前置方法)   
	 * @author yuansl 
	 * @date 2014-4-8 下午5:36:40 
	 * @throws
	 */
	public function _before_add(){
		//获取类型
		$MisExpertTypeModel = D("MisExpertType");
		//默认父级
		$list = $MisExpertTypeModel->where("status = 1 and pid = 0")->field('id,name')->select();
		//默认子一级
		$defaultpid = $list[0][id];
		//查询子级
		$sonlist= $MisExpertTypeModel->where("status = 1 and pid = ".$defaultpid)->field("id,name")->select();
		$this->assign('sonlist',$sonlist);
		$this->assign("typeidlist",$list);
		//订单号可写
		$scnmodel = D('SystemConfigNumber');
		$writable= $scnmodel->GetWritable('mis_expert_list');
		$this->assign("writable",$writable);
   		//自动生成订单编号
   		$code = $scnmodel->GetRulesNO('mis_expert_list');
		$this->assign("code", $code);
		//获取部门
		$model=M("mis_system_department");
		$map1["status"]=1;
		$deplist = $model->where($map1)->getField("id,name");
		$this->assign("deplist", $deplist);
		$deptid = $model->where($map1)->getField('id');
		//当前时间
		$this->assign('currtimesotr',time());
		$this->assign('currtime',Date('Y-m-d'));
		//制单人
		$this->assign('currper',getFieldBy($_SESSION[C('USER_AUTH_KEY')], 'id', 'name', 'User'));
		$this->assign('currperid',$_SESSION[C('USER_AUTH_KEY')]);
	}
	
	function _before_insert(){
		$_POST['picpath']=$_REQUEST['swf_upload_misexpertlist_add_name'];
		$email=array($_POST['email']);
		//邮箱发送
		$title="[特米洛企业信息化管理平台]请查收您的用户信息";
		$content="亲爱的用户，您好！<br/> 您在[特米洛企业信息化管理平台]注册信息如下: <br/>陆名为:'".$_POST['account']."'";
		$content.="<br/>密码为: '".$_REQUEST['password']."' <br/>";
		$vo['name'] = C("EMAIL_SERVERNAME");
		$vo['address'] ="brianl_yang";
		$vo['server'] = "163.com";
		$vo['email'] = C("EMAIL_SERVERADDRESS");
		$vo['pop3'] = "pop.163.com";
		$vo['smtp'] = "smtp.163.com";
		$vo['password'] =C("EMAIL_PASSWORD");
		$vo['pop3port']=110;
		$vo['smtpport']=25;
		$result = $this->SendEmail($title, $content, $email, "", $vo, 1);
		
		$_POST['password']=md5($_REQUEST['password']);
		$_POST['createtime']=time();
	}
	/**
	 * @Title: insert
	 * @Description: todo(重写insert方法,同时往两张表中插数据)   
	 * @author yuansl 
	 * @date 2014-4-9 上午10:27:45 
	 * @throws
	 */

	/**
	 * @Title: view 
	 * @Description: todo(专家查看详细)   
	 * @author yuansl 
	 * @date 2014-4-16 下午2:42:10 
	 * @throws
	 */
	public function view(){
		//接收专家userid
		$userid = $_REQUEST['userid'];
		//获取专家id
		$id = getFieldBy($userid, 'userid', 'id', 'mis_expert_list');
		//实例专家
		$MisExpertListModel = D("MisExpertList");
		//实例专家经验
		$MisExpertExperienceModel = D("MisExpertExperience");
		$expertInfo = $MisExpertListModel->where("userid = ".$userid)->find();
		$expertExpInfo = $MisExpertExperienceModel->where("expertid = ".$id)->select();
		$this->assign('vo',$expertInfo);
		$this->assign('experlist',$expertExpInfo);
		$this->display();
	}
	/**
	 * @Title: lookupdelexp 
	 * @Description: todo(删除专家的经验)   
	 * @author yuansl 
	 * @date 2014-4-9 下午3:41:02 
	 * @throws
	 */
	public function lookupdelexp(){
		$id = $_REQUEST['id'];
		//实例专家经验
		$MisExpertExperienceModel = D("MisExpertExperience");
		$re = $MisExpertExperienceModel->where("id = ".$id)->delete();
		$MisExpertExperienceModel->commit();
// 		dump($re);
// 		echo $MisExpertExperienceModel->getLastSql();
		//dump($re);
		echo "$re";
	}
	public function comboxgetexpert( $t="" ){
		  $model=M("user");
		  if( $t=="" ){
			$dep_id = $this->escapeStr($_POST['dep_id']);
		  }else{
			$dep_id = $t;
		  }
		  $arr=array(array("","请选择专家"));
		  if ($dep_id!='') {
		  	//获取已有  专家
		  	$melModel = D('MisExpertList');//专家表
		  	$mmap['status'] = 1;
		  	if($_GET['id']){
		  		$mmap['id'] = array('neq',$_GET['id']);
		  	}
		  	$melList = $melModel->where($mmap)->getField('userid',true);
		  	if($melList){
		  		$map['id'] = array('not in',$melList);
		  	}
			$map["dept_id"]=$dep_id;
			$userlist = $model->where($map)->getField("id,name");
			foreach($userlist as $k=>$v){
				array_push($arr,array($k, $v));
			}
		  }
		  if( $t=="" ){
			  echo json_encode($arr);
		  }else{
			   return $arr;
		  }
	}
}
?>