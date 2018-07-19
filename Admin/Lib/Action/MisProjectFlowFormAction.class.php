<?php
class MisProjectFlowFormAction extends CommonAction {
	
	 public function _after_insert($list) {
		$MisProjectFlowLinkModel = D ( 'MisProjectFlowLink' );
		$tasktype=$_REQUEST['tasktype'];
		if($tasktype!=3){
			$linkid = $list;
			$linkInfo = $_REQUEST['rwid'];
			if($tasktype==1){
				$MisProjectFlowLinkModel->setLinkWork($linkid,$linkInfo,1,$_REQUEST['projectid']);
			}elseif($tasktype==2){
				$MisProjectFlowLinkModel->setLinkWork($linkid,$linkInfo,2,$_REQUEST['projectid']);
			}
		}
		if ($_POST['executorid']) {
			$data['executorid'] = implode(',', $_POST['executorid']);
		}
		if ($_POST['alloterid']) {
			$data['alloterid'] = implode(',',$_POST['alloterid']);
		}
		$data['id'] = $list;
		//执行人和分派人
		$MisProjectFlowResourceModel = D ( 'MisProjectFlowResource' );
		$MisProjectFlowResourceModel->add($data);
	} 
	
	function _before_lookupprojectadd() {
		//获取业务类型ID
		$supcategory = $_REQUEST['supcategory'];
		$MisProjectFlowTypeDao = M ( "mis_project_flow_type" );
		if($supcategory == 0){
			//表示为选中业务类型。直接点击的新增按钮
			$where ['status'] = 1;
			$where ['outlinelevel'] = 1;
			$supcategory = $MisProjectFlowTypeDao->order("sort asc")->where ( $where )->getField("id");
			$_GET['supcategory'] = $supcategory;
		}
		//获取当前业务类型的公司
		$companyid = $MisProjectFlowTypeDao->where("id = ".$supcategory)->getField("cmpid");
		$this->assign("companyid",$companyid);
		$projectid=$_REQUEST['projectid'];
		$this->assign ( 'projectid', $projectid );
		$this->assign ( 'nodename', $nodename );
		$this->lookupcategory ($projectid);
	}
	function lookupprojectadd(){
		$this->display();
	}
	/**
	 * @Title: lookupgetSupcategoryCompany
	 * @Description: todo(ajax请求，变更业务类型，将变更公司的部门)
	 * @author 黎明刚
	 * @date 2014年12月3日 下午6:22:48
	 * @throws
	 */
	function lookupgetSupcategoryCompany(){
		//获取业务类型ID
		$category = $_POST['category'];
		//获取当前业务类型的公司
		$MisProjectFlowTypeDao = M ( "mis_project_flow_type" );
		$companyid = $MisProjectFlowTypeDao->where("id = ".$category)->getField("cmpid");
		//获取部门信息
		$mis_system_departmentDao = M("mis_system_department");
		$where['companyid'] = $companyid;
		$where['iscompany'] = array('neq',1);
		$deptlist = $mis_system_departmentDao->where($where)->field("id,name")->select();
		echo json_encode($deptlist);
	}
	
	function _before_update(){
		if($_POST['readtaskrole']){
			$_POST['readtaskrole']=implode(',', $_POST['readtaskrole']);
		}else{
			$_POST['readtaskrole']='';
		}
		if($_POST['rules']){
			$_POST['rules'] = str_replace (array ('&quot;','&#39;','&lt;','&gt;'), array ('"', "'",'<','>'),html_entity_decode($_POST['rules']));
		}
		if($_POST['showrules']){
			$_POST['showrules'] = str_replace (array ('&quot;','&#39;','&lt;','&gt;'), array ('"', "'",'<','>'),html_entity_decode($_POST['showrules']));
		}
		if($_REQUEST['totalreport']==null){
			$_POST['totalreport']=0;
		}
		if($_REQUEST['smallreport']==null){
			$_POST['smallreport']=0;
		}
		if($_REQUEST['formtype'] == 2){//如果是单据
			//获取表单对象，判断是否为审批流
			$formobj = $_REQUEST['formobj'];
			//实例化节点表
			$nodeDao = M("node");
			$where=array();
			$where['name'] = array("eq",$formobj);
			$where['isprocess'] = 0;
			$count = $nodeDao->where($where)->count();
			if($count){
				//非审批流。进行确认提交按钮。
				$autoformObj = D('Autoform');
				$autoformObj->setPath('System/confirmcmit.inc.php');
				$path = $autoformObj->GetFile();
				$aryRule = require  $path;
				if(!is_array($aryRule)){
					$aryRule = array();
				}
				if(!in_array($formobj, $aryRule)){
					array_push($aryRule, $formobj);
				}
				$autoformObj->SetRules($aryRule,'需要确认提交按钮的控制器名称');
			}
			if($_POST['isfile']==null){
				$_POST['isfile']=0;
			}
		}else{
			$_POST['isfile']=0;
		}
	}
	
	public function _before_lookupprojectinsert(){
		$_POST['readtaskrole']=implode(',', $_POST['readtaskrole']);
		if($_POST['rules']){
			$_POST['rules'] = str_replace (array ('&quot;','&#39;','&lt;','&gt;'), array ('"', "'",'<','>'),html_entity_decode($_POST['rules']));
		}
		if($_POST['showrules']){
			$_POST['showrules'] = str_replace (array ('&quot;','&#39;','&lt;','&gt;'), array ('"', "'",'<','>'),html_entity_decode($_POST['showrules']));
		}
		if($_REQUEST['formtype'] == 2){//如果是单据
			//获取表单对象，判断是否为审批流
			$formobj = $_REQUEST['formobj'];
			//实例化节点表
			$nodeDao = M("node");
			$where=array();
			$where['name'] = array("eq",$formobj);
			$where['isprocess'] = 0;
			$count = $nodeDao->where($where)->count();
			if($count){
				//非审批流。进行确认提交按钮。
				$autoformObj = D('Autoform');
				$autoformObj->setPath('System/confirmcmit.inc.php');
				$path = $autoformObj->GetFile();
				$aryRule = require  $path;
				if(!is_array($aryRule)){
					$aryRule = array();
				}
				if(!in_array($formobj, $aryRule)){
					array_push($aryRule, $formobj);
				}
				$autoformObj->SetRules($aryRule,'需要确认提交按钮的控制器名称');
			}
		}
	}
	
	function lookupprojectinsert() {
		//B('FilterString');
		$name=$this->getActionName();
		$model = D ($name);
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		//保存当前数据对象
		$list=$model->add ();
		if ($list!==false) {
			//将执行人和分派人加入mis_project_flow_resource
			$misProjectFlowResourceModel=M('mis_project_flow_resource');
			$data['alloterid']=$_REQUEST['alloterid'];
			$data['executorid']=$_REQUEST['executorid'];
			$data['projectid']=$_REQUEST['projectid'];
			$data['suoshujuese']=$_REQUEST['xiangmujuese'];
			
			$data['id']=$list;
			$resourceList=$misProjectFlowResourceModel->add($data);
			if($resourceList!==false){

				//如果存在项目编号跟项目任务，而且审核状态为审核完毕
				if ($_POST['projectid'] && $_POST['projectworkid'] && $_POST['operateid']==1 ) {
					$MSFFModel = D ( 'MisProjectFlowForm' );
					$bool = $MSFFModel->setWorkComplete ( $_POST['projectworkid'] ,$_POST['projectid']);
					//if(!$bool){
					//这里不报错，如果报错的话会有很多影响，如果没更新状态成功，那需要他人为再去更新状态
					//$this->error ( "项目任务状态更新失败，请联系管理员" );
					//}
				}
				//$this->error ("测试项目完成" );
				//上传附件信息
				$this->swf_upload($list);
				// 地区信息处理@nbmxkj - 20141030 1603
				$this->area_info($list);
				
				$module2=A($name);
				if (method_exists($module2,"_after_lookupprojectinsert")) {
					call_user_func(array(&$module2,"_after_lookupprojectinsert"),$list);
				}
				if (method_exists($module2,"_over_insert")) {
					//模型对象名与插入的id值
					$paramate=array($name,$list);
					call_user_func_array(array(&$module2,"_over_insert"),$paramate);
				}
				$startprocess = $_POST ['startprocess'];
				if ($startprocess != 1) {
					$this->success ( "表单数据保存成功！" ,'',$list);
					exit;
				}else{
					$_POST ['id'] = $list;
				}
			}else{
				$this->error ( L('_ERROR_') );
			}
			
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	function _after_lookupprojectedit($vo){
		$name=$this->getActionName();
		$model = D ( $name );
		$LinkModel=D('MisProjectFlowLink');
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$voList = $LinkModel->where($map)->find();
		$this->assign('voList',$voList);
		//获取查看角色
		$readtaskrole = array_filter(explode(',',$vo['readtaskrole']));
		$this->assign('readtaskrole',$readtaskrole);
		//获取当前任务的业务类型所属公司
		$supcategory = $vo['supcategory'];
		//表示为选中业务类型。直接点击的新增按钮
		$MisProjectFlowTypeDao = M ( "mis_project_flow_type" );
		//获取当前业务类型的公司
		$companyid = $MisProjectFlowTypeDao->where("id = ".$supcategory)->getField("cmpid");
		$this->assign("companyid",$companyid);
		$this->lookupcategory ($vo['projectid']);
		//查询动态阶段信息
		if($vo['dycon']){
			//查询阶段名称
			$where['parentid'] = $vo['supcategory'];
			$where['orderno'] = array(' in ',$vo['dycon']);
			$where['outlinelevel'] = 2;
			$typename = $MisProjectFlowTypeDao->where($where)->getField("id,name");
			$typename = implode(",", $typename);
			$this->assign('typename',$typename);
		}
		
	}
	function lookupprojectedit($num=1) {
			//获取当前控制器名称
			$name=$this->getActionName();
			$model = D ( $name );
			//获取当前主键
			$id = $_REQUEST [$model->getPk ()];
			$map['id']=$id;
			$vo = $model->where($map)->find();
	// 		if(empty($vo)){
	// 			$this->display ("Public:404");
	// 			exit;
	// 		}
	
			//查询分派人执行人
			$misProjectFlowResourceModel=M('mis_project_flow_resource');
			$ResourceMap['id']=$id;
			$resourceList=$misProjectFlowResourceModel->where($ResourceMap)->find();
			$vo['alloterid']=$resourceList['alloterid'];
			$vo['executorid']=$resourceList['executorid'];
			
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
			//读取动态配制
			$this->getSystemConfigDetail($name);
			// 上一条数据ID
			$map['id'] = array("lt",$id);
			$updataid = $model->where($map)->order('id desc')->getField('id');
			$this->assign("updataid",$updataid);
			// 下一条数据ID
			$map['id'] = array("gt",$id);
			$downdataid = $model->where($map)->getField('id');
			$this->assign("downdataid",$downdataid);
	
			//获取附件信息
			$this->getAttachedRecordList($id,true,true,$name);
			// 获取现 可能有的地区信息
			$areaModel = M('MisAddressRecord');
			$areainfomap['tablename'] = $this->getActionName();
			$areainfomap['tableid'] = $id ;
			$areaArr = $areaModel->where($areainfomap)->select();
			foreach ($areaArr as $key=>$val){
				$areainfoarry[$val['fieldname']][]=$val;
			}
			$this->assign('areainfoarry' , $areainfoarry);
			//lookup带参数查询
			$module=A($name);
	//		$module->_after_edit();
			if (method_exists($module,"_after_lookupprojectedit")) {
				call_user_func(array(&$module,"_after_lookupprojectedit"),&$vo);
			}
			$this->assign( 'vo', $vo );
			if($num){
				$this->display ();
			}
			
		}
	/**
	 * @Title: lookuprolegroup
	 * @Description: todo(获取角色，部门，职级内容方法)
	 * @author liminggang
	 * @date 2013-11-26 上午9:34:13
	 * @throws
	 */
	public function lookuprolegroup(){
		//查询获取角色
		$obj=$_REQUEST['obj'];
		$stepType=$_REQUEST['stepType'];
		$this->assign('obj',$obj);
		$objname=$_REQUEST['objname'];
		$this->assign('objname',$objname);
		$this->assign('stepType',$stepType);
		$map = array();
		$searchby = $_POST["searchby"];
		$keyword= $_POST["keyword"];
		if($keyword){
			$map[$searchby] = array('like','%'.$keyword.'%');
			$this->assign('keyword',$keyword);
			$this->assign('searchby',$searchby);
		}
		$searchby=array(
				array("id" =>"name","val"=>"按角色名称"),
		);
		$this->assign("searchbylist",$searchby);
	
		$this->_list("rolegroup", $map);
		$this->display();
	}
	
	function _before_lookupprojectedit() {
		$name = $this->getActionName ();
		$MisProjectFlowWorkModel = D ( $name );
		// 获取当前主键
		$id = $_REQUEST [$MisProjectFlowWorkModel->getPk ()];
		
		$map = array ();
		$map ['pinfoid'] = $id;
		$map ['status'] = 1;
		$map ['tablename'] = "mis_project_flow_form";
		// 批次信息表
		$MisSystemUserBactchModel = D ( "MisSystemUserBactch" );
		$MisSystemUserObjModel = D ( "MisSystemUserObj" );
		//查询类型名称
		$userobjlist = $MisSystemUserObjModel->where("status = 1")->select();
		$pinfoid = 0;
		// 获取项目执行人和审核人信息
		$ProcessRelationModel = D ( 'ProcessRelation' );
		$info = $ProcessRelationModel->where ( $map )->select ();
		$list = array ();
		foreach ( $info as $key => $val ) {
			// 根据流程节点。查询批次信息
			$map = array ();
			$map ['tablename'] = 'process_relation';
			$map ['tableid'] = $val ['id'];
			$bactchlist = $MisSystemUserBactchModel->where ( $map )->select ();
			$rulesinfo = $ruleStr = $rulenameStr = $userobjidStr = $userobjidStrname = $userobjStr = $userobjStrname = $bactchStr = array ();
			foreach ( $bactchlist as $k => $v ) {
				// 用户对象ID
				array_push ( $userobjidStr, $v ['userobjid'] );
				// 对应表的name
				foreach($userobjlist as $k1=>$v1){
					if($v['userobjid'] == $v1['id']){
						array_push($userobjidStrname,$v1['name']);
					}
				}
				// 用户对象存储字段
				array_push ( $userobjStr, $v ['userobj'] );
				// 用户对象中文存储
				array_push ( $userobjStrname, $v ['userobjname'] );
				// 批次条件
				array_push ( $ruleStr, $v ['rule'] );
				// 批次条件中文展示
				array_push ( $rulenameStr, $v ['rulename'] );
				// 批次顺序
				array_push ( $bactchStr, $v ['sort'] );
				// 批次序列化
				array_push ( $rulesinfo, $v ['rulesinfo'] );
			}
			$userobjid = implode ( ";", $userobjidStr );
			$userobjidname = implode ( ";", $userobjidStrname );
			$userobj = implode ( ";", $userobjStr );
			$userobjname = implode ( ";", $userobjStrname );
			$rule = implode ( ";", $ruleStr );
			$rulename = implode ( ";", $rulenameStr );
			$bactch = implode ( ";", $bactchStr );
			$rulesinfo = implode ( ";", $rulesinfo );
			// 默认显示
			$str = "";
			$str .= '	<input type="hidden" name="tparallel[]" value="' . $val ['parallel'] . '"/>';
			$str .= '	<input type="hidden" name="tname[]" value="' . $val ['name'] . '"/>';
			$str .= '	<input type="hidden" name="userobjidStr[]" value="' . $userobjid . '"/>';
			$str .= '	<input type="hidden" name="userobjidStrname[]" value="' . $userobjidname . '"/>';
			$str .= '	<input type="hidden" name="userobjStr[]" value="' . $userobj . '"/>';
			$str .= '	<input type="hidden" name="userobjStrname[]" value="' . $userobjname . '"/>';
			$str .= '	<input type="hidden" name="ruleStr[]" value="' . $rule . '"/>';
			$str .= '	<input type="hidden" name="rulename[]" value="' . $rulename . '"/>';
			$str .= '	<input type="hidden" name="bactchStr[]" value="' . $bactch . '"/>';
			$str .= '	<input type="hidden" name="rulesinfoStr[]" value="' . $rulesinfo . '"/>';
			
			//赋值类容
			$list[$val['category']]['str'] = $str;
			$list[$val['category']]['name'] = $val ['name'];
		}
		$this->assign ( "list", $list );
		
		//$this->lookupcategory ();
	}
	public function lookupcategory($projectid) {
		// 获取类型联动
		$categoryComList = D ( 'MisProjectFlowType' )->getDeptCombox ($projectid);
		$this->assign ( "categoryComList", $categoryComList );
	}
	
	public function lookupDyCondition(){
		$this->assign("dycon",explode(",", $_POST['dycon']));
		//新增或修改未保存时，数据显示
		$data['rules'] = str_replace (array ('&quot;','&#39;','&lt;','&gt;'), array ('"', "'",'<','>'),html_entity_decode($_POST['rules']));
		$data['showrules'] = str_replace (array ('&quot;','&#39;','&lt;','&gt;'), array ('"', "'",'<','>'),html_entity_decode($_POST['showrules']));
		$data['rulesinfo'] = $_POST['rulesinfo'];
		// 获取节点的模型名称
		$this->assign ( "pInfoVo", $data );
		$this->assign ( "nodename", $_REQUEST ['modelname'] );
		$this->assign ( "type", $_REQUEST ['type'] );
		$this->display();
	}
	
	function lookupGeneralA() {
		$map = $this->_search ( "MisProjectFlowForm" );
		$type=$_REQUEST['type'];
		$conditions = $_POST ['conditions']; // 检索条件
		if ($conditions) {
			$this->assign ( "conditions", $conditions );
			$cArr = explode ( ';', $conditions ); // 分号分隔多个参数
			foreach ( $cArr as $k => $v ) {
				$wArr = explode ( ',', $v ); // 逗号分隔字段、参数、修饰符
				if ($wArr [0] == "_string") { // 判断是否传的为字符串条件
					$map ['_string'] = $wArr [1];
				} else {
					if ($wArr [2]) { // 存在修饰符的以修饰符形式进行检索
						$map [$wArr [0]] = array (
								$wArr [2],
								$wArr [1]
						);
					} else { // 普通检索
						$map [$wArr [0]] = $wArr [1];
					}
				}
			}
		}
		if($type == 4){
			//查询类型为单据
			$map ['formtype'] = 2;
			//单据数类型
			$map['datatype'] = 0;
		}
		$map ['status'] = 1;
		$this->assign ( "layoutH", 110 ); // 设置高度
		$scdmodel = D ( 'SystemConfigDetail' );
		$detailList = $scdmodel->getDetail ( "MisProjectFlowForm" );
		$this->assign ( 'detailList', $detailList );
		$this->assign('type',$type);
		$this->_list ( "MisProjectFlowForm", $map );
	
		$this->display ();
	}
	public function lookupAddProcessRelation() {
		// 获取节点的模型名称
		$this->assign ( "nodename", $_REQUEST ['modelname'] );
		// 选人类型表
		$MisSystemUserObjModel = D ( "MisSystemUserObj" );
		$userObj = $MisSystemUserObjModel->where ( " status = 1" )->select ();
		$this->assign ( "userObj", $userObj );
		$this->assign ( "ptype", $_REQUEST ['ptype'] );
		$this->display ();
	}
	public function _after_lookupprojectinsert($list) {
		//插入前置节点
		$linkid = $list;
		$linkInfo = $_REQUEST['predecessorid'];
		$MisProjectFlowLinkModel = D("MisProjectFlowLink");
		$MisProjectFlowLinkModel->setLinkWork($linkid,$linkInfo,1);
		if($_REQUEST['predecessorid']){
			//存在前置任务，则对数据字段进行修改
			$MisSystemFlowWorkModel = D ( 'MisProjectFlowForm' );
			$MisSystemFlowWorkModel->where("id = ".$_REQUEST['id'])->setField("issubtask",1);
		}else{
			//不存在存在前置任务，则对数据字段进行修改
			$MisSystemFlowWorkModel = D ( 'MisProjectFlowForm' );
			$MisSystemFlowWorkModel->where("id = ".$_REQUEST['id'])->setField("issubtask",0);			
		}
			
		$this->lookupinserttinfo ( $list );
	}
	public function _after_update($resutl) {
		//修改分派人执行人
		$misProjectFlowResourceModel=M('mis_project_flow_resource');
		$data['alloterid']=$_REQUEST['alloterid'];
		$data['executorid']=$_REQUEST['executorid'];
		$data['projectid']=$_REQUEST['projectid'];
		$data['suoshujuese']=$_REQUEST['xiangmujuese'];
			
		$ResourceMap['id']=$_REQUEST['id'];
		$resourceList=$misProjectFlowResourceModel->where($ResourceMap)->save($data);
		if($resourceList==false){
			$this->error ( L('_ERROR_') );
		}else{
			//插入前置节点
			$linkid = $_REQUEST['id'];
			$linkInfo = $_REQUEST['predecessorid'];
			$MisProjectFlowLinkModel = D("MisProjectFlowLink");
			$MisProjectFlowLinkModel->setLinkWork($linkid,$linkInfo,1);
			if($_REQUEST['predecessorid']){
				//存在前置任务，则对数据字段进行修改
				$MisSystemFlowWorkModel = D ( 'MisProjectFlowForm' );
				$MisSystemFlowWorkModel->where("id = ".$_REQUEST['id'])->setField("issubtask",1);
			}else{
				//不存在存在前置任务，则对数据字段进行修改
				$MisSystemFlowWorkModel = D ( 'MisProjectFlowForm' );
				$MisSystemFlowWorkModel->where("id = ".$_REQUEST['id'])->setField("issubtask",0);			
			}
			$this->lookupinserttinfo ( $_POST ['id'] );
		}
	}
	/**
	 * @Title: lookupinserttinfo
	 * @Description: 分派人和执行人的插入方法。全部以条件形式
	 * @param unknown $id
	 * @author 黎明刚
	 * @date 2014年11月11日 上午10:34:34
	 * @throws
	 */
	private function lookupinserttinfo($id) {
		$ProcessRelationModel = D ( 'ProcessRelation' );
		$MisProjectFlowWorkModel = D ( 'MisProjectFlowForm' );
		$workList = $MisProjectFlowWorkModel->where ( array ('id' => $id ) )->find ();
		// 批次信息表
		$MisSystemUserBactchModel = D ( "MisSystemUserBactch" );
		
		// 先删除原有的流程批次信息，在进行新增
		$map1 = array ();
		$map1 ['pinfoid'] = $id;
		$map1 ['tablename'] = "mis_Project_flow_form";
		$relaids = $ProcessRelationModel->where ( $map1 )->getField ( "id,pinfoid" );
		if ($relaids) {
			$map = array ();
			$map ['id'] = array (' in ',array_keys ( $relaids ) );
			$resultrela = $ProcessRelationModel->where ( $map )->delete ();
			$map = array ();
			$map ['tablename'] = "process_relation";
			$map ['tableid'] = array (' in ',array_keys ( $relaids ) );
			$resultbactch = $MisSystemUserBactchModel->where ( $map )->delete ();
			if (! $resultrela || ! $resultbactch) {
				$this->error ( "数据绑定失败，请联系管理员" );
			}
		}
		$fpr = $_POST ['fpr']; // 标记，1为执行人，2为分派人
		$tname = $_POST ['tname']; // 流程节点名称
		$tparallel = $_POST ['tparallel']; // 是否并行
		
		foreach ( $fpr as $key => $val ) {
			if($tname [$key]){
				$data = array ();
				$data ['pinfoid'] = $id;
				$data ['tablename'] = "mis_Project_flow_form";
				$data ['sort'] = $key;
				$data ['category'] = $val; //分派人和执行人标记
				$data ['name'] = $tname [$key];
				$data ['parallel'] = $tparallel [$key];
				$data ['createtime'] = time ();
				$data ['createid'] = $_SESSION [C ( 'USER_AUTH_KEY' )];
				$result = $ProcessRelationModel->add ( $data );
				if (! $result) {
					$this->error ( "数据提交错误！" );
				}
				// 获取当前流程节点的批次，规则
				$userobjidStr = explode ( ";", $_POST ['userobjidStr'] [$key] );
				$userobjStr = explode ( ";", $_POST ['userobjStr'] [$key] );
				$userobjname = explode ( ";", $_POST ['userobjStrname'] [$key] );
				$bactchStr = explode ( ";", $_POST ['bactchStr'] [$key] );
				
				// 替换html标签字符
				$fields = str_replace ( "&#39;", "'", html_entity_decode ( $_POST ['ruleStr'] [$key] ) );
				$ruleStr = explode ( ";", $fields );
				$rulenameStr = explode ( ";", str_replace ( "&#39;", "'", html_entity_decode ( $_POST ['rulename'] [$key] ) ) );
				$rulesinfoStr = explode ( ";", $_POST ['rulesinfoStr'] [$key] );
				
				$dataList = array ();
				foreach ( $userobjidStr as $bactchkey => $bactchval ) {
					$dataList [] = array (
							'tablename' => "process_relation",
							'tableid' => $result,
							'userobjid' => $bactchval,
							'userobj' => $userobjStr [$bactchkey],
							'userobjname' => $userobjname [$bactchkey],
							'rule' => $ruleStr [$bactchkey],
							'rulename' => $rulenameStr [$bactchkey],
							'rulesinfo' => $rulesinfoStr [$bactchkey],
							'sort' => $bactchStr [$bactchkey],
							'createtime' => time (),
							'createid' => $_SESSION [C ( 'USER_AUTH_KEY' )] 
					);
				}
				$bactchResult = $MisSystemUserBactchModel->addAll ( $dataList );
				if (! $bactchResult) {
					$this->error ( "流程节点批次报错失败,请联系管理员" );
				}
			}
		}
	}
	
	function _before_view(){
		$name=$this->getActionName();
		$model = D ( $name );
		$LinkModel=D('MisProjectFlowLink');
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$voList = $LinkModel->where($map)->find();
		$this->assign('voList',$voList);
	}
	
	function view($num=1){
		$name=$this->getActionName();
		$module=A($name);
		if (method_exists($module,"_before_lookupprojectedit")) {
			call_user_func(array(&$module,"_before_lookupprojectedit"));
		}
		$this->lookupprojectedit($num);
	}
	
	function lookupprojectdelete(){
	//删除指定记录
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$pk = $model->getPk ();
			$id = $_REQUEST [$pk];
			if (isset ( $id )) {
				$condition = array ($pk => array ('eq',$id) );
				$list=$model->where ( $condition )->delete();
// 				$list=true;
				if ($list!==false) {
					$misProjectFlowResourceModel=M('mis_project_flow_resource');
					$ResourceMap['id']=$id;
					$resourceList=$misProjectFlowResourceModel->where($ResourceMap)->delete();
					if($resourceList!==false){
						$this->success ( L('_SUCCESS_') );
					}else{
						$this->error ( L('_ERROR_') );
					}
					
				} else {
					$this->error ( L('_ERROR_') );
				}
			} else {
				$this->error ( C('_ERROR_ACTION_:只能单个删除！') );
			}
		}
		
	}
	
	public function lookupInsert(){
		if($_POST['dycon']){
			$rules = $_POST['rules']?$_POST['rules']:'';
			$showrules = $_POST['showrules'] ? $_POST['showrules']:'';
			$rulesinfo = $_POST['rulesinfo'] ? $_POST['rulesinfo']:'';
			$dycon = implode(",", $_POST['dycon']);
			$type = $_POST['type'];
			//查询阶段名称
			$mis_project_flow_type = M("mis_project_flow_type");
			$where['parentid'] = $type;
			$where['orderno'] = array(' in ',$dycon);
			$where['outlinelevel'] = 2;
			$typename = $mis_project_flow_type->where($where)->getField("id,name");
			$typename = implode(",", $typename);
			$date=array(
					'showname'=>$typename,
					'dycon'=>$dycon,
					'rules'=>$rules,
					'showrules'=>$showrules,
					'rulesinfo'=>$rulesinfo,
			);
			$this->success("添加成功",'',json_encode($date));
		}else{
			$this->error("请添加条件");
		}
	}
}