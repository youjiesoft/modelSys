<?php
use DataTables\Editor\Field;

/**
 * @Title: BusinessAction
 * @Package package_name
 * @Description: todo(动态表单_自动生成-商机)
 * @author 管理员
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-09-23 16:28:46
 * @version V1.0
*/
class MisSaleBusinessAction extends CommonAction {
	public function index() {
	 if(!isset($_SESSION['a'])){
			//查询分派组和转交组人员
			$model=D("User");
			// 获取选中组
			$group    =   D("Rolegroup");
			//获取当前用户组信息
			$groupId ='169';//转交组
			$groupUserList = array();
			if(!empty($groupId)) {
				//获取当前组的用户列表
				$isidlist = array();
				$grouplist	=	$group->getGroupUserList($groupId);
				foreach ($grouplist as $vo){
					$isidlist[]	=	$vo['id'];
				}
				$groupmap['id'] = array('in', $isidlist);
				//查询出当前已选中用户
				$groupUserList = $model->where($groupmap)->getField('id,name');
			}
			
			$fgroupId ='168';//分派组
			$fgroupUserList = array();
			if(!empty($fgroupId)) {
				//获取当前组的用户列表
				$fisidlist = array();
				$fgrouplist	=	$group->getGroupUserList($fgroupId);
				foreach ($fgrouplist as $fvo){
					$fisidlist[]	=	$fvo['id'];
				}
				$fgroupmap['id'] = array('in', $fisidlist);
				//查询出当前已选中用户
				$fgroupUserList = $model->where($fgroupmap)->getField('id,name');
			}
			
			//判断登录人是否在分派组或转交组中
			$fenuserid=array_key_exists($_SESSION[C('USER_AUTH_KEY')], $fgroupUserList);
			$zhuanUserid=array_key_exists($_SESSION[C('USER_AUTH_KEY')], $groupUserList);
			if($fenuserid){
				$_REQUEST['fenuserid']=1;
			}else{
				$_REQUEST['fenuserid']=0;
			}
			if($zhuanUserid){
				$_REQUEST['zhuanuserid']=1;
			}else{
				$_REQUEST['zhuanuserid']=0;
			}
		 }else{
		 		$_REQUEST['fenuserid']=1;
		 		$_REQUEST['zhuanuserid']=1;
		 }
		
		$name = $this->getActionName();
		$businessstatus=$_REQUEST['businessstatus'];
		$this->assign('businessstatus',$businessstatus);
		if($businessstatus!=null && $businessstatus!=1){
			$listname='MisSaleBusinessView';
			$detailName='MisSaleMyBusiness';
			$name1='MisSaleMyBusiness';
			//列表过滤器，生成查询Map对象
			$map = $this->_search ($name1);
			if($businessstatus==2){
				$map['turnstatus']=0;
				$map['mis_sale_business.businessstatus']=array('in',array('2','3','6'));
			}elseif($businessstatus==4){
				$map['turnstatus']=1;
				$map['mis_sale_business.businessstatus']=$_REQUEST['businessstatus'];
			}else{
				$map['turnstatus']=0;
				$map['mis_sale_business.businessstatus']=$_REQUEST['businessstatus'];
			}
		}else{
			$listname=$name;
			$detailName=$name;
			//列表过滤器，生成查询Map对象
			$map = $this->_search ($name);
			if(!empty($businessstatus)){
				$map['mis_sale_business.businessstatus']=$businessstatus;
			}
		}
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		if (! empty ( $name )) {
			$qx_name=$name;
			if(substr($name, -4)=="View"){
				$qx_name = substr($name,0, -4);
			}
		
			//验证浏览及权限
			if( !isset($_SESSION['a']) ){
				$map=D('User')->getAccessfilter($qx_name,$map);
			}
			unset($map['createid']);
			if(!$_SESSION['a']){
				//查询当前业务员的部门，只显示当前部门业务员的数据
				$MisHrPersonnelUserDeptViewModel=D('MisHrPersonnelUserDeptView');
				if($_SESSION['user_dep_id']){
					$personmap['deptid']=$_SESSION['user_dep_id'];
				}
				if($_SESSION['companyid']){
					$personmap['companyid']=$_SESSION['companyid'];
				}
				$personList=$MisHrPersonnelUserDeptViewModel->where($personmap)->field('userid')->select();
				foreach ($personList as $pk=>$pv){
					$personListInfo[]=$pv['userid'];
				}
				$where['mis_sale_business.userid']=array('in',$personListInfo);
				$where['mis_sale_business.businessstatus']=array('neq',1);
				$where['_logic']='AND';
				$condition['_complex'] = $where;
				
				//查询当前部门下的区域
				$MisSystemDepartmentModel=D('MisSystemDepartment');
				$depMap['id']=$_SESSION['user_dep_id'];
				$quyu=$MisSystemDepartmentModel->where($depMap)->getField('quyu');
				$areaData=explode(',', $quyu);
				if(!empty($quyu)){
					$condition['mis_sale_business.areaid']=array('in',$areaData);
				}
				$condition['_logic']='OR';
				$map['_complex']=$condition;
				
			}
			unset($map['departmentid']);
			$this->_list ( $listname, $map );
		}
		
		//begin
		$scdmodel = D('SystemConfigDetail');
		
		//读取列名称数据(按照规则，应该在index方法里面)
		$detailList = $scdmodel->getDetail($detailName);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		if($businessstatus=='1'){
			unset($toolbarextension['js-check']);
			unset($toolbarextension['js-reallot']);
		}elseif($businessstatus=='4'){
			unset($toolbarextension['js-delete']);
			unset($toolbarextension['js-edit']);
			unset($toolbarextension['js-check']);
			unset($toolbarextension['js-turn']);
			unset($toolbarextension['js-allot']);
			unset($toolbarextension['js-reallot']);
		}elseif($businessstatus=='2'){
			unset($toolbarextension['js-delete']);
			unset($toolbarextension['js-check']);
			unset($toolbarextension['js-turn']);
			unset($toolbarextension['js-allot']);
			unset($toolbarextension['js-reallot']);
		}elseif($businessstatus=='5'){
			unset($toolbarextension['js-delete']);
			unset($toolbarextension['js-edit']);
			unset($toolbarextension['js-allot']);
			unset($toolbarextension['js-turn']);
		}else{
			unset($toolbarextension['js-check']);
			unset($toolbarextension['js-reallot']);
		}
		
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		//end
	
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		if($_REQUEST['jump']){
			$this->display('indexview');exit;
		}
		$this->display ();
	}
	
	
	public function _after_list($voList){
		if($_REQUEST['businessstatus']!=2 && $_REQUEST['businessstatus']!=5  && $_REQUEST['businessstatus']!=4){
			foreach ($voList as $vok=>$vov){
				if($vov['businessstatus']!=1){
					//查询分派的数据
					$bmap['bid']=$vov['id'];
					if($vov['businessstatus']==4){
						$bmap['turnstatus']=1;
					}else{
						$bmap['turnstatus']=0;
					}
					$allotModel=D('MisSaleBusinessAllot');
					$allotList=$allotModel->where($bmap)->find();
					$voList[$vok]['allotendtime']=$allotList['endtime'];
					$voList[$vok]['allotuserid']=$allotList['userid'];
					$voList[$vok]['endstatus']=$allotList['endstatus'];
				}else{
					$voList[$vok]['allotendtime']=null;
					$voList[$vok]['allotuserid']=null;
					$voList[$vok]['endstatus']=null;
				}
			}
		}
	}
	
	
	function lookupturn(){
		$name='MisSaleBusiness';
		$model = D ( $name );
		$id = $_REQUEST['id'];
		$map['id'] = $id;
		$list=$model->where($map)->find();
		$this->assign('vo',$list);
		$this->display();
	}
	
	function lookupturninsert(){
		$name='MisSaleBusiness';
		$model = D ( $name );
		$name1='MisSaleBusinessAllot';
		$model1 = D ( $name1 );
		$id = $_REQUEST['id'];
		//改变商机状态
		$map['id']=$id;
		$data['businessstatus']=2;
		$list=$model->where($map)->save($data);
		if($list==false){
			$this->error ( L('_ERROR_') );
		}else{
			$data1['bid'] = $id;
			$data1['userid'] = $_REQUEST['userid'];
			$data1['orderno'] = $_REQUEST['orderno'];
			$data1['endtime'] = strtotime($_REQUEST['endtime']);
			$data1['alloterid'] = $_SESSION[C('USER_AUTH_KEY')];
			$data1['createid'] = $_SESSION[C('USER_AUTH_KEY')];
			$data1['companyid'] = $_SESSION[C('companyid')];
			$data1['zhuanpai'] =1;
			$data1['createtime'] = time();
			$data1['zhijiezhuanjiao']=1;
			$list1=$model1->add($data1);
			if($list1==false){
				$this->error ( L('_ERROR_') );
			}else{
				//添加转交记录
				$turnlogMode=M('mis_sale_business_turn_log');
				$turnlogData['bid']=$id;
				$turnlogData['zhuanjiaoren']=$_SESSION[C('USER_AUTH_KEY')];
				$turnlogData['jieshouren']=$_REQUEST['userid'];
				$turnlogData['createtime']=time();
				$turnlogData['quxiaoshijian']=time();
				$turnlogLits=$turnlogMode->add($turnlogData);
				if($turnlogLits==false){
					$this->error ( L('_ERROR_') );
				}else{
					$this->success ( L('_SUCCESS_'));
				}
			}
		}
		
	}
	function check(){
		$name='MisSaleBusiness';
		$model = D ( $name );
		$id = $_REQUEST [$model->getPk ()];
		$map['id'] = $id;
		$data['businessstatus'] = 1;
		$list=$model->where($map)->save($data);
		// 更新数据
		if (false !== $list) {
			$name1='MisSaleBusinessAllot';
			$model1 = D ( $name1 );
			$map1['bid'] = $id;
			$map1['turnstatus'] = 0;
			$list1=$model1->where($map1)->delete();
			if($list1==false){
				$this->error ( L('_ERROR_') );
			}else{
				$this->success ( L('_SUCCESS_'));
			}
			
				
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	
	function  allot(){
		//获取当前控制器名称
		$name='MisSaleBusiness';
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$vo = $model->where($map)->find();
		//lookup带参数查询
		$rel=$_REQUEST['rel'];
		$this->assign('rel',$rel);
		$userid =$_SESSION[C('USER_AUTH_KEY')];
		$this->assign ( 'userid', $userid );
		$this->assign( 'vo', $vo );
		$this->display();
	}
	
	//分派保存
	function lookupallot(){
		$name='MisSaleBusinessAllot';
		$model = D ($name);
		$condition['bid']=$_REQUEST['bid'];
		$allotbInfo=$model->where($condition)->delete();
		if($allotbInfo==false){
			$this->error ( L('_ERROR_') );
		}else{
			$data1['bid'] = $_REQUEST['bid'];
			$data1['userid'] = $_REQUEST['userid'];
			$data1['orderno'] = $_REQUEST['orderno'];
			$data1['endtime'] = strtotime($_REQUEST['endtime']);
			$data1['alloterid'] = $_SESSION[C('USER_AUTH_KEY')];
			$data1['createid'] = $_SESSION[C('USER_AUTH_KEY')];
			$data1['companyid'] = $_SESSION[C('companyid')];
			$data1['createtime'] = time();
			//保存当前数据对象
			$list1=$model->data($data1)->add();
			if (false !== $list1) {
				$name1='MisSaleBusiness';
				$saveModel=D ($name1);
				$id = $_REQUEST['id'];// 替换ID
				// 修改以前的数据  修改为处理完成
				$map['id'] = $id;
				$data['businessstatus'] = 3;
				$data['userid'] = $_REQUEST['userid'];
				$data['endtime']=strtotime($_REQUEST['endtime']);
				$data['updatetime'] = time();
				$list=$saveModel->where($map)->save($data);
				// 更新数据
				if (false !== $list) {
					//如果分派给的不是部门经理则发知会给部门经理
					//查询该商机业务员
					$userid=$_REQUEST['userid'];
					$roleid=D('Rolegroup')->getRoleId(); //角色
					$user_dept_dutyModel=M('user_dept_duty');
					$deptid=$user_dept_dutyModel->where (array('userid'=>$userid))->getField("deptid");//部门
					//通过角色部门获取部门经理
					$mis_organizational_recodeModel=M('mis_organizational_recode');
					$reMap['deptid']=$deptid;
					$reMap['rolegroup_id']=$roleid;
					$jinliuserid[0]=$mis_organizational_recodeModel->where($reMap)->getField("userid");
					$isinarray=in_array($_REQUEST['userid'], $jinliuserid);
					$isfeninarray=in_array($_SESSION[C('USER_AUTH_KEY')], $jinliuserid);
					if(!$isinarray && $isfeninarray){
						$this->lookupWorkMisNotify($jinliuserid, 'MisSaleBusiness',$id,$_REQUEST['userid'],2,$_SESSION[C('USER_AUTH_KEY')]);
					}
					//添加分派数据
					$allotlogMode=M('mis_sale_business_allot_log');
					$allotlogData['bid']=$_REQUEST['bid'];
					$allotlogData['fenpairen']=$_SESSION[C('USER_AUTH_KEY')];
					$allotlogData['yewuyuan']=$_REQUEST['userid'];
					$allotlogData['createtime']=time();
					$allotlogLits=$allotlogMode->add($allotlogData);
					if($allotlogLits==false){
						$this->error ( '添加分派记录失败' );
					}else{
						$this->success ( L('_SUCCESS_'));
					}
				} else {
					$this->error ( L('_ERROR_') );
				}
			} else {
				$this->error ( L('_ERROR_') );
			}
		}
	}
	
	function reallot(){
		//获取当前控制器名称
		$name='MisSaleBusiness';
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$vo = $model->where($map)->find();
		//lookup带参数查询
		
		$userid =$_SESSION[C('USER_AUTH_KEY')];
		$this->assign ( 'userid', $userid );
		$this->assign( 'vo', $vo );
		$this->display();
	}
	
	function lookupreallotadd(){
		$name='MisSaleBusinessAllot';
		$model = D ($name);
		$data1['bid'] = $_REQUEST['bid'];
		$data1['userid'] = $_REQUEST['userid'];
		$data1['orderno'] = $_REQUEST['orderno'];
		$data1['endtime'] = strtotime($_REQUEST['endtime']);
		$data1['alloterid'] = $_SESSION[C('USER_AUTH_KEY')];
		$data1['createid'] = $_SESSION[C('USER_AUTH_KEY')];
		$data1['companyid'] = $_SESSION[C('companyid')];
		$data1['createtime'] = time();
		//保存当前数据对象
		$condition['bid']=$_REQUEST['bid'];
		$con['turnstatus']=1;
		$allotInfo=$model->where($condition)->save($con);
		if($allotInfo==false){
			$this->error ( L('_ERROR_') );
		}
		$list1=$model->data($data1)->add();
		if (false !== $list1) {
				$name1='MisSaleBusiness';
				$saveModel=D ($name1);
				 $id = $_REQUEST['id'];// 替换ID
				// 修改以前的数据  修改为处理完成
				$map['id'] = $id;
				$data['businessstatus'] = 3;
				$data['userid'] = $_REQUEST['userid'];
				$data['endtime']=strtotime($_REQUEST['endtime']);
				$data['updatetime'] = time();
				$data['updateid'] = $_SESSION[C('USER_AUTH_KEY')];
				 $list=$saveModel->where($map)->save($data);
				 $condition['turnstatus']=1;
				 $allotbInfo=$model->where($condition)->delete();
				 if($allotbInfo==false){
				 	$this->error ( L('_ERROR_') );
				 }
				// 更新数据
				 if (false !== $list) {
				 	//如果分派给的不是部门经理则发知会给部门经理
				 	//查询该商机业务员
				 	$userid=$_REQUEST['userid'];
				 	$roleid=D('Rolegroup')->getRoleId(); //角色
				 	$user_dept_dutyModel=M('user_dept_duty');
				 	$deptid=$user_dept_dutyModel->where (array('userid'=>$userid))->getField("deptid");//部门
				 	//通过角色部门获取部门经理
				 	$mis_organizational_recodeModel=M('mis_organizational_recode');
				 	$reMap['deptid']=$deptid;
				 	$reMap['rolegroup_id']=$roleid;
				 	$jinliuserid[0]=$mis_organizational_recodeModel->where($reMap)->getField("userid");
				 	$isinarray=in_array($_REQUEST['userid'], $jinliuserid);
				 	$isfeninarray=in_array($_SESSION[C('USER_AUTH_KEY')], $jinliuserid);
				 	if(!$isinarray && $isfeninarray){
				 		$this->lookupWorkMisNotify($jinliuserid, 'MisSaleBusiness', $_REQUEST['bid'],$_REQUEST['userid'],2,$_SESSION[C('USER_AUTH_KEY')]);
				 	}
				 	
					 //添加分派数据
					$allotlogMode=M('mis_sale_business_allot_log');
					$allotlogData['bid']=$_REQUEST['bid'];
					$allotlogData['fenpairen']=$_SESSION[C('USER_AUTH_KEY')];
					$allotlogData['yewuyuan']=$_REQUEST['userid'];
					$allotlogData['createtime']=time();
					$allotlogLits=$allotlogMode->add($allotlogData);
					if($allotlogLits==false){
						$this->error ( '添加分派记录失败' );
					}else{
						$this->success ( L('_SUCCESS_'));
					}
				} else {
					$this->error ( L('_ERROR_') );
				} 
		} else {
			$this->error ( L('_ERROR_') );
		}
		
	}
	
	/**
	 * @Title: _before_edit
	 * @Description: todo(前置编辑函数)
	 * @author 管理员
	 * @date 2014-09-23 16:28:46
	 * @throws 
	*/
	function _after_edit(){
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		// 获取现 可能有的地区信息
		$areainfoModel = M('MisAddressRecord');
		$arreamap['tablename'] =array(' in', array($this->getActionName(),'MisSaleMyBusiness'));
		$arreamap['tableid'] = $_REQUEST['id'] ;
		$areaArr = $areainfoModel->where($arreamap)->select();
		foreach ($areaArr as $key=>$val){
			$areainfoarry[$val['fieldname']][]=$val;
		}
		//dump($areainfoarry);
		$this->assign('areainfoarry' , $areainfoarry);
		$this->assign('userid',$userid);
	}
	/**
	 * @Title: _before_insert
	 * @Description: todo(前置添加函数)
	 * @author 管理员
	 * @date 2014-09-23 16:28:46
	 * @throws 
	*/
	function _before_insert(){
		$acquiretime=strtotime($_REQUEST['acquiretime']);
		$id=$_REQUEST['days'];
		$name='MisSaleExpiryDate';
		$model = D ( $name );
		$map['id']=$id;
		$vo = $model->where($map)->find();
		$days=$vo['name'];
		
		$name1='MisSystemDays';
		$model1=D($name1);
		$unixdate=strtotime(date("Y-m-d",$acquiretime));
		$condition=array('unixdate'=>array('gt',$unixdate),'type'=>1);
		$list=$model1->where($condition)->limit($days)->select();
		$lastArray = array_pop($list);
		//$_POST['endtime']=$lastArray['standdate'];
		$_POST['userid']=$_SESSION[C('USER_AUTH_KEY')];
		
	}
	/**
	 * @Title: _before_update
	 * @Description: todo(前置修改函数)  
	 * @author 管理员
	 * @date 2014-09-23 16:28:46
	 * @throws
	*/
	function _before_update(){
		$this->checkifexistcodeororder('mis_sale_business','orderno','MisSaleBusiness',1);
// 		$acquiretime=strtotime($_REQUEST['acquiretime']);
// 		$id=$_REQUEST['days'];
// 		$name='MisSaleExpiryDate';
// 		$model = D ( $name );
// 		$map['id']=$id;
// 		$vo = $model->where($map)->find();
// 		$days=$vo['name'];
		
// 		$name1='MisSystemDays';
// 		$model1=D($name1);
// 		$unixdate=strtotime(date("Y-m-d",$acquiretime));
// 		$condition=array('unixdate'=>array('gt',$unixdate),'type'=>1);
// 		$list=$model1->where($condition)->limit($days)->select();
// 		$lastArray = array_pop($list);
// 		$_POST['endtime']=$lastArray['standdate'];

		$acquiretime=strtotime($_REQUEST['acquiretime']);
		$days=trim($_REQUEST['days']);
		if(empty($days) || $days=="" || $days==0){
			$_POST['endtime']=null;
		}else{
			$_POST['endtime']=date("Y-m-d",strtotime("+".$days." day",$acquiretime));
		}
		
		if(strtotime($_POST['endtime'])>strtotime(date('Y-m-d'))){
			$_POST['shixiao']=0;
		}else{
			$_POST['shixiao']=1;
		}
		
	}
	/**
	 * @Title: _after_insert
	 * @Description: todo(后置insert函数)  
	 * @author 管理员
	 * @date 2014-09-23 16:28:46
	 * @throws
	*/
	function _after_insert($id){
	}
	/**
	 * @Title: _after_update
	 * @Description: todo(后置update函数)  
	 * @author 管理员
	 * @date 2014-09-23 16:28:46
	 * @throws
	*/
	function _after_update(){
	}
	
	function update($isrelation=false) {
		//获取当前数据ID
		$id = $_POST['id'];
		$name=$this->getActionName();
		logs($_POST , $name.'_update_'.date('Y-m-d-H' , time()) ,'',__CLASS__,__FUNCTION__,__METHOD__);
		 
		//查询当前审批节点  model 权限取值begin
		$mis_work_monitoringDao = M("mis_work_monitoring");
		$userid = $_SESSION[C('USER_AUTH_KEY')];
		$map = array();
		$map['tablename'] = $name;
		$map['tableid'] = $id;
		$monlist = $mis_work_monitoringDao->where($map)->field("curNodeId,ostatus")->order("id desc")->select();
		if(count($monlist)>0){
			foreach($monlist as $mk=>$mv){
				$relationid = getFieldBy($mv['ostatus'], "id", "relationid", "process_relation_form");
				if($relationid < 1422900000 && $relationid>0){
					$_SESSION["nodeActionName".$userid] = $name;
					$_SESSION['nodeAuditId'.$userid] = $relationid;
					$_REQUEST['node'] = $relationid;
					break;
				}
			}
		}
		//model 权限取值 End
	
		$model = D ( $name );
		//这里用来存储临时缓存文件
		$updateBackup=$this->setOldDataToCache($model,$name,$id,'update');
		if (false === $model->create ()) {
			if(!$isrelation){
				$this->error ( $model->getError () );
			}else{
				throw new NullPointExcetion($model->getError () . ' ACTION: ' .MODULE_NAME);
				return false;
			}
		}
		// 更新数据
		$list=$model->save ();
		logs($model->getLastSql() , $name.'_update_sql_'.date('Y-m-d-H' , time()) ,'',__CLASS__,__FUNCTION__,__METHOD__);
		logs($model->getDBError() , $name.'_update_sql[ERROR]_'.date('Y-m-d-H' , time()) ,'',__CLASS__,__FUNCTION__,__METHOD__);
		 
		if (false !== $list) {
			$vo = $model->where("id =".$id)->find();
			$pkValue=$id;
	
			//修改附件信息
			$this->swf_upload($id,0,null,$vo['projectid'],$vo['projectworkid']);
			// 地区信息修改 @nbmxkj - 20141030 16:05
			$this->area_info($id,'MisSaleMyBusiness');
			//执行成功后，用A方法进行实例化，判断当前控制器中是否存在_after_update方法
			$module2=A($name);
			if (method_exists($module2,"_after_update")) {
				call_user_func(array(&$module2,"_after_update"),$list);
			}
			/*
			 * _over_update 方法，为静默插入生单。
			*/
			if (method_exists($module2,"_over_update")) {
				//模型对象名与插入的id值,这里2是修改
				$paramate=array($name,$pkValue,2,$updateBackup);
				//ischageoperateid为1的时候。表示审批流过来的变更节点审批终审。需要进行变更漫游
				if($_POST['ischageoperateid']==1){
					//模型对象名与插入的id值，这里5是变更
					$paramate=array($name,$pkValue,5,$updateBackup);
				}
				call_user_func_array(array(&$module2,"_over_update"),$paramate);
			}
			/*
			 * startprocess,在页面是不存在。此参数是在启动流程startprocess方法中默认赋值的，为了关闭insert的成功success输出
			*/
			$startprocess = $_POST ['startprocess'];
			/*
			 * operateid 确认提交标记
			*/
			// 套表时特有属性，nbmxkj@20150625 1516
			// __coverformoperateid__ : mian/children
			if($_POST['operateid']==1){
				//这里清除内存表缓存的修改前数据代码
				$this->unsetOldDataToCache($updateBackup);
	
				if(!$_POST['__coverformoperateid__']){
					//版本控制
					$saveList=$this->SaveVersionWord($id,$name);
				}
				//修改子流程方法
				$this->_before_overProcess($id);
			}
				
			if ($startprocess !== 1) {
				if(!$isrelation){
					$this->success ( "表单数据保存成功！" );
				}else{
					return $id;
				}
			}
		} else {
			if(!$isrelation){
				$this->error ( L('_ERROR_').$model->getDBError().'=-='.$model->getLastSql() );
			}else{
				throw new NullPointExcetion( L('_ERROR_').$model->getDBError().'=+='.$model->getLastSql() );
				return false;
			}
		}
	}
	
	function edit($num=1) {
		// 实例化对应数据表模型
		$name = $this->getActionName ();
		// 审批流 动态建模页面时的子表数据获取 add by nbmkxj@20150129 2214
		$viewCheckPath = LIB_PATH.'Model/'.$name.'ViewModel.class.php';
		$model = D ( $name);
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$vo = $model->where($map)->find();
		// 		dump($model->getlastsql());
		$retSql = <<<EOF
	
				<script>
				console.log("表数据查询条件:{$model->getLastSql()}");
				</script>
EOF;
		//   		 echo $retSql;
		if(false ===$vo && APP_DEBUG){
			$this->error($model->getDBError());
		}
		/*
		 * 验证新增页面或者修改页面字段权限控制
		 * 查询固定流程是否存在
		 */
		$ProcessInfoModel = D ( "ProcessInfo" );
		//验证流程是否存在
		$pcarr = $ProcessInfoModel->getProcessInfo($name);
		if($pcarr){
			//存在流程配置
			$map = array();
			$map['pinfoid'] = $pcarr ['id'];
			$map['tablename'] = "process_info";
			$map['status'] = 1;
			$map['flowtype'] = 0; //开始节点
			$ProcessRelationModel = D ( "ProcessRelation" );
			// 获取流程节点数据
			$relationList = $ProcessRelationModel->where ( $map )->find();
			if($relationList){
				$userid = $_SESSION[C('USER_AUTH_KEY')];
				$_SESSION['nodeAuditId'.$userid]="";
				$_SESSION["nodeActionName".$userid] = $name;
				$_SESSION['nodeAuditId'.$userid] = $relationList['id'];
				$_REQUEST['node'] = $relationList['id'];
			}
		}
		//end
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
	
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
		if(C('AREA_TYPE')==1){
			$areainfomap['tablename'] = $this->getActionName();
		}elseif(C('AREA_TYPE')==2){
			$areainfomap['tablename'] = D($this->getActionName())->getTableName();
		}
	
		$areainfomap['tableid'] = $id ;
		$areaArr = $areaModel->where($areainfomap)->select();
		foreach ($areaArr as $key=>$val){
			$areainfoarry[$val['fieldname']][]=$val;
		}
		$this->assign('areainfoarry' , $areainfoarry);
		//lookup带参数查询
		$module=A($name);
//		$module->_after_edit();
		if (method_exists($module,"_after_edit")) {
			call_user_func(array(&$module,"_after_edit"),&$vo);
		}
		//读取动态配制
		$this->getSystemConfigDetail($name,$vo);
// 		dump($vo);
		$this->assign( 'vo', $vo );
		if($_REQUEST['curModelForDataManage']){
			return $vo;
		}else if($num){
			$this->display ();
		}
	
	}
	
	function _before_view(){
		$name=$this->getActionName();
		$communicateModel=D('MisSaleCommunicateLog');
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['bid']=$id;
		$voList = $communicateModel->where($map)->order('linktime desc')->select();
		foreach ($voList as $vk=>$vval){
			$voList[$vk]['xianshishijian']=$vval['linktime'];
			$voList[$vk]['leixing']=1;//1沟通记录
		}
// 		$this->assign('voList',$voList);//沟通记录
		//查询转交分派记录
		$allotlogModel=M('mis_sale_business_allot_log');
		$allotlogList=$allotlogModel->where(array('bid'=>$id))->order('createtime desc')->select();
		$turnlogModel=M('mis_sale_business_turn_log');
		$turnlogList=$turnlogModel->where(array('bid'=>$id))->order('createtime desc')->select();
		//查询转储备记录
		$MisAutoTssModel=D('MisAutoTss');
		$TssMap['bid']=$id;
		$MisAutoTssList=$MisAutoTssModel->where($TssMap)->order('createtime desc')->select();

		foreach ($allotlogList as $alk=>$alv){
			$allotlogList[$alk]['xianshishijian']=$alv['createtime'];
			$allotlogList[$alk]['leixing']=2;//2分派记录
		}
		foreach ($turnlogList as $tlk=>$tlv){
			$turnlogList[$tlk]['xianshishijian']=$tlv['createtime'];
			$turnlogList[$tlk]['leixing']=3;//3转交记录
		}
		foreach ($MisAutoTssList as $tsk=>$tsv){
			$MisAutoTssList[$tsk]['xianshishijian']=$tsv['createtime'];
			$MisAutoTssList[$tsk]['leixing']=4;//4 转储备记录
		}
		//将沟通、转交、分派记录重组
		if(!empty($voList) && !empty($allotlogList)){
			$endList=array_merge($voList,$allotlogList);
		}elseif(empty($voList)){
			$endList=$allotlogList;
		}elseif(empty($allotlogList)){
			$endList=$voList;
		}
		if(!empty($turnlogList) && !empty($endList)){
			$end1VoList=array_merge($endList,$turnlogList);
		}elseif(empty($turnlogList)){
			$end1VoList=$endList;
		}elseif(empty($endList)){
			$end1VoList=$turnlogList;
		}
		
		if(!empty($MisAutoTssList) && !empty($end1VoList)){
			$endVoList=array_merge($end1VoList,$MisAutoTssList);
		}elseif(empty($MisAutoTssList)){
			$endVoList=$end1VoList;
		}elseif(empty($end1VoList)){
			$endVoList=$MisAutoTssList;
		}
		
		foreach ($endVoList as $evk=>$evv){
			$shijianData[$evk]=$evv['xianshishijian'];
		}
		array_multisort($shijianData,SORT_DESC,$endVoList);
		$this->assign('endVoList',$endVoList);
// 		$this->assign('allotlogList',$allotlogList);//分派
// 		$this->assign('turnlogList',$turnlogList);//转交
// 		//查询转储备记录
// 		$MisAutoTssModel=D('MisAutoTss');
// 		$TssMap['bid']=$id;
// 		$MisAutoTssList=$MisAutoTssModel->where($TssMap)->order('createtime desc')->select();
// 		foreach ($MisAutoTssList as $tsk=>$tsv){
// 			$MisAutoTssList[$tsk]['ShowActionName']='MisAutoTss';
// 		}
		$this->assign('MisAutoTssList',$MisAutoTssList);
	}
	
	
	
	function lookupPinyin($_String, $_Code='UTF8'){ //GBK页面可改为gb2312，其他随意填写为UTF8
		$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
				"|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
				"cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
				"|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
				"|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
				"|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
				"|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
				"|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
				"|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
				"|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
				"|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
				"she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
				"tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
				"|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
				"|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
				"zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
		$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
				"|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
				"|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
				"|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
				"|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
				"|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
				"|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
				"|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
				"|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
				"|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
				"|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
				"|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
				"|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
				"|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
				"|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
				"|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
				"|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
				"|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
				"|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
				"|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
				"|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
				"|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
				"|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
				"|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
				"|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
				"|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
				"|-10270|-10262|-10260|-10256|-10254";
		$_TDataKey   = explode('|', $_DataKey);
		$_TDataValue = explode('|', $_DataValue);
		$_Data = array_combine($_TDataKey, $_TDataValue);
		arsort($_Data);
		reset($_Data);
		if($_Code!= 'gb2312') $_String = $this->lookup_U2_Utf8_Gb($_String);
		$_Res = '';
		for($i=0; $i<strlen($_String); $i++) {
			$_P = ord(substr($_String, $i, 1));
			if($_P>160) {
				$_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;
			}
			$_Res .= $this->lookup_Pinyin($_P, $_Data);
		}
		return preg_replace("/[^a-z0-9]*/", '', $_Res);
	}
	function lookup_Pinyin($_Num, $_Data){
		if($_Num>0 && $_Num<160 ){
			return chr($_Num);
		}elseif($_Num<-20319 || $_Num>-10247){
			return '';
		}else{
			foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
			return $k;
		}
	}
	function lookup_U2_Utf8_Gb($_C){
		$_String = '';
		if($_C < 0x80){
			$_String .= $_C;
		}elseif($_C < 0x800) {
			$_String .= chr(0xC0 | $_C>>6);
			$_String .= chr(0x80 | $_C & 0x3F);
		}elseif($_C < 0x10000){
			$_String .= chr(0xE0 | $_C>>12);
			$_String .= chr(0x80 | $_C>>6 & 0x3F);
			$_String .= chr(0x80 | $_C & 0x3F);
		}elseif($_C < 0x200000) {
			$_String .= chr(0xF0 | $_C>>18);
			$_String .= chr(0x80 | $_C>>12 & 0x3F);
			$_String .= chr(0x80 | $_C>>6 & 0x3F);
			$_String .= chr(0x80 | $_C & 0x3F);
		}
		return iconv('UTF-8', 'GB2312', $_String);
	}
	/**
	 * lookupSelectTime
	 *商机定时更新 
	 */
	function lookupSelectTime(){
		//判断是否超期
		$time=strtotime(date("Y-m-d",time()));
		$MisSaleBusinessViewModel=D('MisSaleBusinessView');
		$allotModel=D('MisSaleBusinessAllot');
		$model=D('MisSaleBusiness');
		$allotMap['endstatus']=0;
		$allotMap['turnstatus']=0;
		$allotMap['allotendtime']=array('lt',$time);
		$allotMap['allotendtime']=array('neq',null);
		$allotMap['allotendtime']=array('neq',0);
		$allotList=$MisSaleBusinessViewModel->where($allotMap)->select();
		foreach ($allotList as $ak=>$av){
			if($av['allotendtime']<$time){
				if($av['businessstatus']!=4 && $av['businessstatus']!=5 && $av['turncustomer']!=1){
					$id[]=$av['allotid'];
					$bid[]=$av['id'];
				}
			}
		}
		$amap['id']=array('in',$id);
		$adata['endstatus']=1;
		$list=$allotModel->where($amap)->save($adata);
		//判断是否延期
		/* if(!empty($bid)){
			$chaoqiMap['id']=array('in',$bid);
			$chaoqiData['yanqizhuangtai']=1;
			$chaoqiList=$model->where($chaoqiMap)->save($chaoqiData);
		} */
		
		//查询新建商机是否失效
		$Map['businessstatus']=1;
		$Map['endtime']=array('lt',$time);
		$Map['endtime']=array('neq',null);
		$List=$model->where($Map)->select();
		foreach ($List as $lk=>$lv){
			if($av['endtime']<$time){
				$businessId[]=$lv['id'];
			}
		}
		$bmap['id']=array('in',$businessId);
		$bdata['shixiao']=1;
		$blist=$model->where($bmap)->save($bdata);
		
		//超期未处理的发布通知给部门经理
		//查询到期未处理的商机
		$MisSaleCommunicateLogModel=D('MisSaleCommunicateLog');
		foreach ($bid as $bk=>$bv){
			$logMap['bid']=$bv;
			$logList=$MisSaleCommunicateLogModel->where($logMap)->select();
			if($logList==null){
				//查询该商机业务员
				$businessList=$model->where(array('id'=>$bv))->find();
				$userid=$businessList['userid'];
				$roleid=D('Rolegroup')->getRoleId(); //角色				
				$user_dept_dutyModel=M('user_dept_duty');
				$deptid=$user_dept_dutyModel->where (array('userid'=>$userid))->getField("deptid");//部门
				//通过角色部门获取部门经理
				$mis_organizational_recodeModel=M('mis_organizational_recode');
				$reMap['deptid']=$deptid;
				$reMap['rolegroup_id']=$roleid;
				$jinliuserid[0]=$mis_organizational_recodeModel->where($reMap)->getField("userid");
				//发送知会
				$this->lookupWorkMisNotify($jinliuserid, 'MisSaleBusiness',$bv,$userid,1);
			}
		}
		$allotModel->commit();
		 if(false!=$list){
		 	echo json_encode($list);
		 	/* $map['id'] = array('in',$bid);
			$map['businessstatus']=array('neq','4');
			$data['businessstatus']=5;
			$listInfo=$model->where($map)->save($data);
			$model->commit(); */
		} 
	}
	
	function lookupWorkMisNotify($informpersonid,$modelname, $tableid,$userid,$messagetype,$allotid){
		if ($informpersonid) {
			$sendidArr = array ();
			$sendidArr = $informpersonid;
			$nodeModel = M('node');
			$modelUser = D('User');
			//通过modelname查找到对应的模块中文名
			$modelNameChinese = '商机';
			$username = $modelUser->where(array('id'=>$userid))->getField('name');
			$allotname=$modelUser->where(array('id'=>$allotid))->getField('name');
			//通过modelname查找到对应的单据编号
			$orderInfo = D($modelname)->where("id='".$tableid."'")->field("orderno")->find();
			$orderno=$orderInfo['orderno'];
			$noticeTypeName="工作知会：";
			if($messagetype==1){
				$messageTitle = '业务员'.$username.'的  '. $modelNameChinese .' 单据号为  ' . $orderno . ' 截止日期已到还未处理，已经超期！';
			}else{
				$messageTitle = $modelNameChinese .' 单据号为  ' . $orderno . '的单据被'.$allotname.'分派给'.$username;
			}
			
			//系统推送消息
			if(!is_array($sendidArr)){
				$sendidArr=array($sendidArr);
			}
			//生成发件人名字符串
		
			$condition = array('id'=>array('in', $sendidArr) );
			$nameArray = $modelUser->where($condition)->getField('id,name');
				//名字，字符串
			$recipientNameString = implode(",",$nameArray);
	
			//接收人，ID字符串
			$recipientListIDString = implode(',',$sendidArr);
			$notifyModel=D('MisNotify');
			//数据区
			$data['title'] = $messageTitle;
			$data['recipient'] = $recipientListIDString;
			$data['recipientname'] = $recipientNameString;
			$data['createid'] = 0;
			$data['createtime'] =  time();
			$data['status'] = 1;
			$data['type'] = $messagetype;
			$data['orderno'] = $orderno;
			$data['tableid'] = $tableid;
			$data['modelname'] = $modelname;
			$data['name'] = $modelNameChinese;
			$notifyModel->add($data);
		}
	}
	
	
	
	
	
}
?>
