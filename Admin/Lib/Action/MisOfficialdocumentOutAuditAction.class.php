<?php
/**
 * @Title: MisOfficialdocumentOutAction
 * @Package package_name
 * @Description: todo(公文管理-发文核稿)
 * @author renling
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-11-14 下午2:28:16
 * @version V1.0
 */
class MisOfficialdocumentOutAuditAction extends CommonAuditAction {
	public function _filter(&$map) {
		if ($_SESSION["a"] != 1){
			$map['status'] = 1;
		}
	}
	public function index(){
		//获取当前模型
		$name = $this->getActionName();
		//获取检索条件
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		//获取结构树
		$this->getAuditTree();
		//获取选中的ID
		$defid=$_GET['defid']?$_GET['defid']:1;
		$this->assign('defid',$defid);
		//获取查询类型
		$typeid=$_GET['typeid'];
		if($typeid){
			$map['typeid'] = $typeid;
			$this->assign('typeid',$typeid);
		}
		$map['status'] =1;
		//判断当前登录人是否在审核人组中
		$jump=$_REQUEST['jump']?$_REQUEST['jump']:1;
		$this->assign('jump',$jump);
		IF($jump == 2){
			//已核稿查询条件
			$map['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].', alreadyAuditUser )';
		}else{
			//待核稿查询条件
			$map['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].',curAuditUser )';
		}
		$this->_list($name,$map,'',true);

		if($_REQUEST['jump']){
			$this->display('indexview');
		}else{
			$this->display();
		}
	}
	
	public function _before_auditEdit(){
		//查询附件信息
		$this->getAttachedRecordList($_GET['id'],true,true,'MisOfficialdocumentOut');
	}
	public function _before_auditView(){
		//查询附件信息
	$this->getAttachedRecordList($_GET['id'],true,true,'MisOfficialdocumentOut');
	}
	
	public function _after_update($result){
		if($result){
			$this->swf_upload($_POST['id']);
		}
	}
	public function _after_edit($vo){
		if($vo){
			//获取审核流程意见
			$MisDocumentHistoryDao = M("mis_officialdocument_process_info_history");
			$map['tablename'] = 'MisOfficialdocumentOutAudit';
			$map['tableid'] = $vo['id'];
			$historylist=$MisDocumentHistoryDao->where($map)->order('id desc')->select();
			//查询流程节点名称
			$MisOfficialdocumentAuditorDao = M("mis_officialdocument_auditor");

			$userid=$_SESSION[C('USER_AUTH_KEY')];

			$auditor['status'] = 1;

			//判断是否为查看
			$jump=$_GET['jump'];
			if($jump!=2){  //当前不为查看的时候，判断是否为最后一个人审核，进行价签功能
				//获取当前审核人
				$userid=$_SESSION[C('USER_AUTH_KEY')];
				//获取全部审核人
				$auditArr = explode(";", $vo['auditUser']);
				//获取当前审核组人员
				$userArr=explode(",", $vo['curAuditUser']);
				$newUserArr=array_diff($userArr, array($userid));
				if(!$newUserArr){
					if(count($auditArr) == $vo['auditCount']){
						//当前审核人组已经到最后一组,给一个加签标志
						$this->assign('jq',1);
					}
				}
			}

			$arr = array();
			$z = 0;
			//构造一个html的审核内容
			for($i=0; $i<$vo['auditCount']; $i++){
				//1,2,3 对应流程节点ID
				$ptmptidArr=explode(",", $vo['ptmptidArr']);

				if($ptmptidArr){
					$auditor['id'] = $ptmptidArr[$i];
				}else{
					$auditor['id'] = 0;
				}
				$auditorlist=$MisOfficialdocumentAuditorDao->where($auditor)->find();
				//是否存在审核记录
				if($historylist){
					if($z != $i){
						$a = array();
						$z++;
					}
					//进行匹配
					foreach($historylist as $key=>$val){
						if($i+1 == $val['ostatus']){
							//当前的流程节点ID在数组中
							$a[] = $val;
							$size=count($a);
							$b=intval(100/$size);
							$arr[$z+1] = array(
									'id'=>$z+1,
									'bl'=>$b,
									'name'=>$val['pname'],
									'nextarr'=>$a,
							);
						}
					}
				}
			}
			array_multisort($arr,SORT_DESC); // 进行数组排序
			$this->assign('arr',$arr);
		}
	}

	/**
	 * @Title: getAuditTree
	 * @Description: todo(构造树结构)
	 * @author liminggang
	 * @date 2013-12-16 下午5:16:19
	 * @throws
	 */
	public function getAuditTree(){
		//获取公文类型
		$MisOfficialdocumentTypeDao = M('mis_officialdocument_type');
		$typelist=$MisOfficialdocumentTypeDao->where('status = 1')->select();
		//定义rel
		$rel = "MisOfficialdocumentOutAuditindex";
		//当前控制器
		$name = $this->getActionName();
		$masmodel = D($name);
		//第一部分、核稿中
		$maps = array();
		$maps['status'] =1;
		//判断当前登录人是否在当前审核组中
		$maps['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].',curAuditUser )';
		$count = $masmodel->where($maps)->count('id');
		$pid = 1;
		$tree[] = array(
				'id' => $pid,
				'pId' => 0,
				'name' => '待核稿单据('.$count.')',
				'title' => '待核稿单据('.$count.')',
				'rel' => $rel,
				'icon' => "__PUBLIC__/Images/icon/order_missionwait.png",
				'target' => 'ajax',
				'url' => '__URL__/index/jump/1/defid/'.$pid,
				'open' => true
		);//待审任务根节点
		foreach ($typelist as $k1 => $v1) {
			//查询公文类型条数
			$maps['typeid'] = $v1['id'];
			$count = $masmodel->where($maps)->count('id');
			$thisid = $pid.''.$v1['id'];
			$tree[] =  array(
					'id' => $thisid,
					'pId' => $pid,
					'name' => $v1['name'].'('.$count.')',
					'title' => $v1['name'].'('.$count.')',
					'rel' => $rel,
					'target' => 'ajax',
					'url' => '__URL__/index/jump/1/typeid/'.$v1['id'].'/defid/'.$thisid,
					'open' => true
			);
		}
		//第二部分、核稿完成
		$maps = array();
		$maps['status'] =1;
		$maps['_string'] = 'FIND_IN_SET(  '.$_SESSION[C('USER_AUTH_KEY')].',alreadyAuditUser )';
		$count = $masmodel->where($maps)->count('id');
		$pid = 2;
		$tree[] = array(
				'id' => $pid,
				'pId' => 0,
				'name' => '已核稿单据('.$count.')',
				'title' => '已核稿单据('.$count.')',
				'rel' => $rel,
				'target' => 'ajax',
				'icon' => "__PUBLIC__/Images/icon/order_missionaudit.png",
				'url' => '__URL__/index/jump/2/defid/'.$pid,
				'open' => true
		);//已审任务根节点
		foreach ($typelist as $k1 => $v1) {
			$thisid = $pid.''.$v1['id'];
			//查询公文类型条数
			$maps['typeid'] = $v1['id'];
			$count = $masmodel->where($maps)->count('id');
			$tree[] =  array(
					'id' => $thisid,
					'pId' => $pid,
					'name' => $v1['name'].'('.$count.')',
					'title' => $v1['name'].'('.$count.')',
					'rel' => $rel,
					'target' => 'ajax',
					'url' => '__URL__/index/jump/2/typeid/'.$v1['id'].'/defid/'.$thisid,
					'open' => true
			);
		}
		//生成树json
		$this->assign("auditTree",json_encode($tree));
	}
	/**
	 * (non-PHPdoc)
	 * @see CommonAuditAction::auditProcess()
	 */
	function auditProcess(){
		$name=$this->getActionName();
		//获取当前数据信息
		$masid = $_POST['id'];
		$model2 = D ( $name );
		$vo = $model2->find($masid);
		//上传附件信息
		$this->swf_upload($masid,95);

		//获取当前审核人
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		//获取全部审核人
		$auditArr = explode(";", $vo['auditUser']);
		//获取当前审核组人员
		$userArr=explode(",", $vo['curAuditUser']);
		$newUserArr=array_diff($userArr, array($userid));
		//审核状态
		$_POST['auditState'] = 2;
		//判断当前是否审核组中的最后一个人员
		if(!$newUserArr){
			if(count($auditArr) == $vo['auditCount']){
				//当前审核人组已经到最后一组，判断是否进行会签，追加审核人
				//判断是否加签
				$jq=$_POST['jq'];
				$newuserD = $_POST['useridArr'];
				$user=explode(",", $newuserD);
				if($jq && $newuserD){
					//把新加入的人员保存到审核人组
					$auditArr[$vo['auditCount']] = $newuserD;

					$_POST['auditUser'] = implode(";", $auditArr);
					$_POST['auditCount'] = $vo['auditCount']+1;
					//当前审核人
					$_POST['curAuditUser'] = $newuserD;
					
					//加签用户系统消息推送
					$content="发文号：".$_POST['orderno']." 标题：".$_POST['title']."  承办人：".$_POST['employename']." 发文具体内容，<a rel='MisOfficialdocumentOutAuditauditEdit' target='navTab' href='__APP__/MisOfficialdocumentOutAudit/auditEdit/id/".$_POST['id']."'>请点此链接</a>";
					//推送系统消息给审核人
					$this->pushMessage($user,"系统消息，推送发文核稿消息  发文号：".$_POST['orderno'],$content);
					
				}else{
					$_POST['curAuditUser'] = '';
					$_POST['auditState'] = 3;
					if (method_exists($this,"overProcess")) {
						$this->overProcess($masid);
					}
				}
			}else{
				//当前组审核完成，进行累加组
				$_POST['auditCount'] = $vo['auditCount']+1;
				//获取下一组审核人
				$_POST['curAuditUser'] = $auditArr[$vo['auditCount']];
			}
		}else{
			$_POST['curAuditUser'] = implode(",", $newUserArr);
		}
		//添加已审核人员
		if( $vo['alreadyAuditUser'] ){
			$alreadyAuditUser = explode(",",$vo['alreadyAuditUser'].",".$_SESSION[C('USER_AUTH_KEY')]);
			$alreadyAuditUser = array_unique($alreadyAuditUser);
			$_POST['alreadyAuditUser']=implode(",",$alreadyAuditUser);
		}else{
			$_POST['alreadyAuditUser'] = $_SESSION[C('USER_AUTH_KEY')];
		}
		//流程ID数组
		$ptmptidArr=explode(",",$vo['ptmptidArr']);
		$MisOfficialdocumentAuditorDao = M("mis_officialdocument_auditor");
		//如果是加签则不存在流程节点中
// 		$auditorlist = array();
// 		if($ptmptidArr[$vo['auditCount']-1]){
// 			$auditor['id'] = $ptmptidArr[$vo['auditCount']-1];
// 			$auditorlist=$MisOfficialdocumentAuditorDao->where($auditor)->field('doinfo')->find();
// 		}else{
			//$auditorlist['doinfo'] = "加签用户组批阅";
// 		}
		//插入流程历史记录
		unset($_POST['id']);
		$model = M('mis_officialdocument_process_info_history');
		$_POST['dotype'] = $_POST['auditprocess'];
		$_POST['dotime'] = time();
		$_POST['doinfo'] = $_POST['doinfo'];
		$_POST['tablename']=$name;
		$_POST['tableid']=$masid;
		$_POST['userid'] =$_SESSION[C('USER_AUTH_KEY')];
		$_POST['auditstatus'] =2;
		$_POST['orderno'] = $vo["orderno"];
		$_POST['ordercreateid'] = $vo["createid"];
		$_POST['ostatus'] = $vo['auditCount'];//流程节点组
		$_POST['pname'] = "加签用户组批阅";
		$_POST['createid'] = $userid;
		$_POST['createtime'] = time();
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		$list=$model->add ();
		if( !$list ){
			$this->error("流程历史记录插入失败");
		}
		$_POST['id']=$masid;
		$this->update();
	}
	//流程回退
	public function backprocess() {
		// 插入流程明细
		$modelname = $this->getActionName();
		$masid = $_POST['id'];
		$model2 = D ( $modelname );
		$vo = $model2->find($masid);
		//流程ID数组
		$ptmptidArr=explode(",",$vo['ptmptidArr']);
		//如果是加签则不存在流程节点中
		$auditorlist = array();
		//查询流程节点名称
		$MisOfficialdocumentAuditorDao = M("mis_officialdocument_auditor");
		if($ptmptidArr[$vo['auditCount']-1]){
			$auditor['id'] = $ptmptidArr[$vo['auditCount']-1];
			$auditorlist=$MisOfficialdocumentAuditorDao->where($auditor)->field('doinfo')->find();
			$auditorlist['doinfo'] = $auditorlist['doinfo']."(打回)";
		}else{
			$auditorlist['doinfo'] = "加签用户组(打回)";
		}

		unset($_POST['id']);
		$model = M('mis_officialdocument_process_info_history');
		$_POST['dotype'] = $_POST['backprocess'];
		$_POST['dotime'] = time();
		$_POST['doinfo'] = $_POST['doinfo'];
		$_POST['tablename']=$modelname;
		$_POST['tableid']=$masid;
		$_POST['userid'] =$_SESSION[C('USER_AUTH_KEY')];
		$_POST['auditstatus'] =-1;
		$_POST['orderno'] = $vo["orderno"];
		$_POST['ordercreateid'] = $vo["createid"];
		$_POST['ostatus'] = $vo['auditCount'];//流程节点组
		$_POST['pname'] = $auditorlist['doinfo'];
		$_POST['createid'] = $userid;
		$_POST['createtime'] = time();
		if (false === $model->create ()) {
			$this->error ( $model->getError () );
		}
		$list=$model->add ();
		if( !$list ){
			$this->error("流程历史记录插入失败");
		}
		$_POST['id']=$masid;
		if ($list!==false) { //保存成功
			$_POST['auditState']=-1;
			//$_POST['isread']=0;
			//$_POST['auditUser']='';
			$_POST['curAuditUser']='';
			if( $vo['alreadyAuditUser'] ){
				$alreadyAuditUser = explode(",",$vo['alreadyAuditUser'].",".$_SESSION[C('USER_AUTH_KEY')]);
				$alreadyAuditUser = array_unique($alreadyAuditUser);
				$_POST['alreadyAuditUser'] = implode(",",$alreadyAuditUser);
			}else{
				$_POST['alreadyAuditUser'] = $_SESSION[C('USER_AUTH_KEY')];
			}
			$this->update();
		} else {
			$this->error ( L('_ERROR_') );
		}
	}

	/**
	 *
	 * @Title: lookupmanage
	 * @Description: todo(用ztree形式查询出所有部门员工信息。)
	 * @author liminggang
	 * @throws
	 */
	public function lookupmanage(){
		
		//构造部门结构树
		$model= M('mis_system_department');
		$deptlist = $model->where("status = 1")->order("id asc")->select();
		$param['rel']="documentOutAudit_right";
		$param['url']="__URL__/lookupmanage/jump/1/deptid/#id#/parentid/#parentid#";
		$param['open'] = true;
		$typeTree = $this->getTree($deptlist,$param);
		$this->assign('tree',$typeTree);
		$map = array();
		$searchby = str_replace("-", ".", $_POST["searchby"]);
		$keyword=$this->escapeChar($_POST["keyword"]);
		if($_POST["keyword"]){
			$map[$searchby] =  array('like','%'.$keyword.'%');
			$this->assign('keyword',$keyword);
			$searchby = str_replace(".", "-", $_POST["searchby"]);
			$this->assign('searchby',$searchby);
		}
		$searchbylist=array(
				array("id" =>"user-name","val"=>"按员工姓名"),
				array("id" =>"orderno","val"=>"按员工编号"),
		);
		$this->assign("searchbylist",$searchbylist);
		$map['user.status']=1;
		$deptid		= $_REQUEST['deptid'];
		$parentid	= $_REQUEST['parentid'];
		if ($deptid && $parentid) {
			$map['user.dept_id'] = $deptid;
// 			$deptlist =array_unique(array_filter (explode(",",$this->findAlldept($deptlist,$deptid))));
// 			$map['user.dept_id'] = array(' in ',$deptlist);
		}
		$CommonAction = A("Common");
		$CommonAction->_list('MisHrPersonnelPersonInfoView',$map);
		$this->assign('deptid',$deptid);
		$this->assign('parentid',$parentid);
		if ($_REQUEST['jump']) {
			$this->display('lookupmanagelist');
		} else {
			$this->display("lookupmanage");
		}
	}
}