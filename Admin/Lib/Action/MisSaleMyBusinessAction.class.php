<?php
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
class MisSaleMyBusinessAction extends CommonAction {
	public function _filter(&$map){
		if ($_SESSION["a"] != 1){
			$map['mis_sale_business.status']=array("gt",-1);
		}
	}
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
		
		 if($_REQUEST['businessstatus']==null){
		 	$_REQUEST['businessstatus']=7;
		 }
		
		$businessstatus=$_REQUEST['businessstatus'];
		$this->assign('businessstatus',$_REQUEST['businessstatus']);
		if($businessstatus!=7 && $businessstatus!=9){
			$name = $this->getActionName();
			//列表过滤器，生成查询Map对象
			$map = $this->_search ($name);
			if($businessstatus==3){
				$map['mis_sale_business_allot.userid']=$_SESSION[C('USER_AUTH_KEY')];
				$map['mis_sale_business.businessstatus']=array('in',array('3','6'));
				$map['mis_sale_business_allot.turnstatus']=0;
			}elseif($businessstatus==4){
				$map['mis_sale_business_allot.userid']=$_SESSION[C('USER_AUTH_KEY')];
				$map['mis_sale_business.businessstatus']=$_REQUEST['businessstatus'];
				$map['mis_sale_business_allot.turnstatus']=1;
			}elseif($businessstatus==2){
				$map['mis_sale_business.businessstatus']=$_REQUEST['businessstatus'];
				$map['mis_sale_business_allot.turnstatus']=0;
				$map['mis_sale_business_allot.zhuanpai']=1;
				$map['mis_sale_business_allot.zhuanpairen']=$_SESSION[C('USER_AUTH_KEY')];
			}elseif($businessstatus==8){
				$map['mis_sale_business_allot.userid']=$_SESSION[C('USER_AUTH_KEY')];
				$map['mis_sale_business.businessstatus']=2;
				$map['mis_sale_business_allot.turnstatus']=0;
			}else{
				$map['mis_sale_business_allot.userid']=$_SESSION[C('USER_AUTH_KEY')];
				$map['mis_sale_business.businessstatus']=$_REQUEST['businessstatus'];
				$map['mis_sale_business_allot.turnstatus']=0;
			}
			
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
			///////////////////////////////////////////////////////////////////////////////////
			
			///////////////////////////////////////////////////////////////////////////////////
			
			if (! empty ( $name )) {
				$qx_name=$name;
				if(substr($name, -4)=="View"){
					$qx_name = substr($name,0, -4);
				}
				//验证浏览及权限
				if( !isset($_SESSION['a']) ){
					$map=D('User')->getAccessfilter($qx_name,$map);
				}
				unset($map['companyid']);
				$this->_list ( 'MisSaleBusinessView', $map);
			}
			//begin
			$scdmodel = D('SystemConfigDetail');
			//读取列名称数据(按照规则，应该在index方法里面)
			$detailList = $scdmodel->getDetail($name);
			if ($detailList) {
				$this->assign ( 'detailList', $detailList );
			}
			//扩展工具栏操作
			$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
			if($businessstatus=='3'){
				unset($toolbarextension['js-add']);
				unset($toolbarextension['js-edit']);
				unset($toolbarextension['js-delete']);
				unset($toolbarextension['js-acquireself']);
				unset($toolbarextension['js-check']);
				unset($toolbarextension['js-accept']);
				unset($toolbarextension['js-reject']);
			}elseif($businessstatus=='8'){
				unset($toolbarextension['js-add']);
				unset($toolbarextension['js-edit']);
				unset($toolbarextension['js-delete']);
				unset($toolbarextension['js-reserve']);
				unset($toolbarextension['js-edit']);
				unset($toolbarextension['js-item']);
				unset($toolbarextension['js-acquireself']);
				unset($toolbarextension['js-check']);
				unset($toolbarextension['js-communicate']);
				unset($toolbarextension['js-turn']);
				unset($toolbarextension['js-client']);
				unset($toolbarextension['js-allot']);
			}elseif($businessstatus=='2'){
				unset($toolbarextension['js-delete']);
				unset($toolbarextension['js-reserve']);
				unset($toolbarextension['js-edit']);
				unset($toolbarextension['js-item']);
				unset($toolbarextension['js-acquireself']);
				unset($toolbarextension['js-check']);
				unset($toolbarextension['js-communicate']);
				unset($toolbarextension['js-accept']);
				unset($toolbarextension['js-reject']);
				unset($toolbarextension['js-turn']);
				unset($toolbarextension['js-allot']);
			}elseif($businessstatus=='4'){
				unset($toolbarextension['js-delete']);
				unset($toolbarextension['js-edit']);
				unset($toolbarextension['js-reserve']);
				unset($toolbarextension['js-item']);
				unset($toolbarextension['js-accept']);
				unset($toolbarextension['js-reject']);
				unset($toolbarextension['js-turn']);
				unset($toolbarextension['js-acquireself']);
				unset($toolbarextension['js-check']);
				unset($toolbarextension['js-communicate']);
				unset($toolbarextension['js-allot']);
			}elseif($businessstatus=='5'){
				unset($toolbarextension['js-delete']);
				unset($toolbarextension['js-edit']);
				unset($toolbarextension['js-reserve']);
				unset($toolbarextension['js-item']);
				unset($toolbarextension['js-accept']);
				unset($toolbarextension['js-reject']);
				unset($toolbarextension['js-turn']);
				unset($toolbarextension['js-edit']);
				unset($toolbarextension['js-acquireself']);
				unset($toolbarextension['js-check']);
				unset($toolbarextension['js-communicate']);
				unset($toolbarextension['js-allot']);
			}
		}else{
			$name = $this->getActionName();//'MisSaleBusiness';
			$name1=$this->getActionName();
			//列表过滤器，生成查询Map对象
			$map = $this->_search ($name);
			
			if($businessstatus=='7'){
				$businessMap['provider']=$_SESSION[C('USER_AUTH_KEY')];
				$businessMap['userid']=$_SESSION[C('USER_AUTH_KEY')];
				$businessMap['_logic']='OR';
				//$map['_complex'] = $businessMap;
				$map['_string']=' provider='.$_SESSION[C('USER_AUTH_KEY')].' or userid='.$_SESSION[C('USER_AUTH_KEY')];
				
			}elseif($businessstatus=='9'){
				$map['provider']=$_SESSION[C('USER_AUTH_KEY')];
			}
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
			//////////////////////////////////////////////////////////////////////////////////////////////
			
			//////////////////////////////////////////////////////////////////////////////////////////////
			if (! empty ( $name )) {
				$qx_name=$name;
				if(substr($name, -4)=="View"){
					$qx_name = substr($name,0, -4);
				}
				//验证浏览及权限
				if( !isset($_SESSION['a']) ){
					$map=D('User')->getAccessfilter($qx_name,$map);
				}
				unset($map['departmentid']);
				unset($map['companyid']);
				$this->_list ( $name, $map);
			}
			//begin
			$scdmodel = D('SystemConfigDetail');
			//读取列名称数据(按照规则，应该在index方法里面)
			$detailList = $scdmodel->getDetail($name);
			if ($detailList) {
				$this->assign ( 'detailList', $detailList );
			}
			//扩展工具栏操作
			$toolbarextension = $scdmodel->getDetail($name1,true,'toolbar');
		
			unset($toolbarextension['js-acquireself']);
			unset($toolbarextension['js-reserve']);
			unset($toolbarextension['js-item']);
			unset($toolbarextension['js-accept']);
			unset($toolbarextension['js-reject']);
			unset($toolbarextension['js-check']);
			unset($toolbarextension['js-communicate']);
			unset($toolbarextension['js-client']);
			
			if($businessstatus!=7){
				unset($toolbarextension['js-turn']);
			}
		}
			
			
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
	
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		if($_REQUEST['jump'] == "jump"){
			$this->display('indexview');exit;
		}
	
		$this->display ();
		return;
	}
	
	public function _after_list($voList){
		if($_REQUEST['_URL_'][1]!='lookupacquire' && ($_REQUEST['businessstatus']==null || $_REQUEST['businessstatus']==7 ||$_REQUEST['businessstatus']==9) ){
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
	public function add() {
		$modelname = 'MisSaleBusiness';
		$this->getSystemConfigDetail($modelname);
		$userid=$_SESSION[C('USER_AUTH_KEY')];
		$vo['provider']=$userid;
		//查询用户是否是联络站成员
		$rolegroup_userModel=M('rolegroup_user');
		$roleMap['rolegroup_id']=173;
		$roleMap['user_id']=$userid;
		$roleList=$rolegroup_userModel->where($roleMap)->find();
		if($roleList){
			$userModel=M('user');
			$userMap['id']=$userid;
			$userlist=$userModel->where($userMap)->find();
			$lianluozhanModel=M('mis_auto_gbdzk');
			$lianluozhanMap['denglumingchen']=$userlist['account'];
			$lisnluozhanList=$lianluozhanModel->where($lianluozhanMap)->find();
			$vo['jinronglianluozhan']=$lisnluozhanList['id'];
			$vo['xuanzeleixing']=2;
		}
		$this->assign('vo',$vo);
		$this->assign('userid',$userid);
		$time=time();
		$this->assign('time',$time);
		$this->display ();
	}
	
	function _after_insert($id) {
		$issallotself=$_POST['issallotself'];
		if($issallotself==1){
				$name='MisSaleBusinessAllot';
				$model = D ($name);
				$data1['bid'] = $id;
				$data1['userid'] = $_SESSION[C('USER_AUTH_KEY')];
				$data1['orderno'] = $_POST['orderno'];
				$data1['endtime'] = strtotime($_POST['endtime']);
				$data1['alloterid'] = $_SESSION[C('USER_AUTH_KEY')];
				$data1['createid'] = $_SESSION[C('USER_AUTH_KEY')];
				$data1['companyid'] = $_SESSION[C('companyid')];
				$data1['createtime'] = time();
				//保存当前数据对象
				$list1=$model->data($data1)->add();
				if($list1==false){
					$this->error ( L('_ERROR_') );
				}else{
					//添加分派数据
					$allotlogMode=M('mis_sale_business_allot_log');
					$allotlogData['bid']=$id;
					$allotlogData['fenpairen']=$_SESSION[C('USER_AUTH_KEY')];
					$allotlogData['yewuyuan']=$_SESSION[C('USER_AUTH_KEY')];
					$allotlogData['createtime']=time();
					$allotlogData['zidonghuoqu']=1;
					$allotlogLits=$allotlogMode->add($allotlogData);
					if($allotlogLits==false){
						$this->error ( '添加分派记录失败' );
					}else{
						$this->success ( L('_SUCCESS_'));
					}
				}
		}
	}
	
	
	function edit() {
		//获取当前控制器名称
		$name='MisSaleBusiness';
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$vo = $model->where($map)->find();
		//读取动态配制
		$this->getSystemConfigDetail($name);
		//扩展工具栏操作
		$scdmodel = D('SystemConfigDetail');
	
		//获取附件信息
		$this->getAttachedRecordList($id,true,true,$name);
		// 获取现 可能有的地区信息
		$areaModel = M('MisAddressRecord');
		$areainfomap['tablename'] =array(' in', array($this->getActionName(),'MisSaleBusiness'));
		$areainfomap['tableid'] = $id ;
		$areaArr = $areaModel->where($areainfomap)->select();
		foreach ($areaArr as $key=>$val){
			$areainfoarry[$val['fieldname']][]=$val;
		}
		$this->assign('areainfoarry' , $areainfoarry);
		//lookup带参数查询
		$module=A($name);
		if (method_exists($module,"_after_edit")) {
			call_user_func(array(&$module,"_after_edit"),&$vo);
		}
		$this->assign( 'vo', $vo );
	
		$this->display ();
	}
	
	
	function _after_update() {
		$issallotself=$_POST['issallotself'];
		if($issallotself=='1'){
			$name='MisSaleBusinessAllot';
				$model = D ($name);
				$data1['bid'] = $_POST['id'];
				$data1['userid'] = $_SESSION[C('USER_AUTH_KEY')];
				$data1['orderno'] = $_POST['orderno'];
				$data1['endtime'] = strtotime($_POST['endtime']);
				$data1['alloterid'] = $_SESSION[C('USER_AUTH_KEY')];
				$data1['updateid'] = $_SESSION[C('USER_AUTH_KEY')];
				$data1['createid'] = $_SESSION[C('USER_AUTH_KEY')];
				$data1['companyid'] = $_SESSION[C('companyid')];
				$data1['createtime'] = time();
				$data1['updatetime'] = time();
				//保存当前数据对象
				$list1=$model->data($data1)->add();
		
				if($list1==false){
					$this->error ( L('_ERROR_') );
				}else{
					//添加分派数据
					$allotlogMode=M('mis_sale_business_allot_log');
					$allotlogData['bid']=$_POST['id'];
					$allotlogData['fenpairen']=$_SESSION[C('USER_AUTH_KEY')];
					$allotlogData['yewuyuan']=$_SESSION[C('USER_AUTH_KEY')];
					$allotlogData['createtime']=time();
					$allotlogData['zidonghuoqu']=1;
					$allotlogLits=$allotlogMode->add($allotlogData);
					if($allotlogLits==false){
						$this->error ( '添加分派记录失败' );
					}else{
						$this->success ( L('_SUCCESS_'));
					}
				}
		}
	}
	
	
	public function acquire() {
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
		
		$name1='MisSaleMyBusiness';
		//列表过滤器，生成查询Map对象
		$map = $this->_search ($name1);
		
		$map['mis_sale_business.businessstatus']=1;
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name = $this->getActionName();
		if (! empty ( $name )) {
			$qx_name=$name;
			if(substr($name, -4)=="View"){
				$qx_name = substr($name,0, -4);
			}
			//验证浏览及权限
			if( !isset($_SESSION['a']) ){
				$map=D('User')->getAccessfilter($qx_name,$map);
			}
			//需要引用数据权限参数
			$_POST['isbrows']=1;
			$this->_list ( $name1, $map );
		}
		//begin
		$scdmodel = D('SystemConfigDetail');
		//读取列名称数据(按照规则，应该在index方法里面)
		$detailList = $scdmodel->getDetail($name1);
		if ($detailList) {
			$this->assign ( 'detailList', $detailList );
		}
		//扩展工具栏操作
		$toolbarextension = $scdmodel->getDetail($name,true,'toolbar');
		
		unset($toolbarextension['js-delete']);
		unset($toolbarextension['js-reserve']);
		unset($toolbarextension['js-item']);
		unset($toolbarextension['js-accept']);
		unset($toolbarextension['js-reject']);
		unset($toolbarextension['js-turn']);
		unset($toolbarextension['js-edit']);
		unset($toolbarextension['js-check']);
		unset($toolbarextension['js-communicate']);
		unset($toolbarextension['js-allot']);
		
		if ($toolbarextension) {
			$this->assign ( 'toolbarextension', $toolbarextension );
		}
		//end
	
		if( intval($_POST['dwzloadhtml']) ){
			$this->display("dwzloadindex");exit;
		}
		//首页收件箱调用方法，为ajax调用
		if ($_GET['type'] == "ajaxcall") {
			$this->display ("ajax_index");exit;
		}
	
		$userid =$_SESSION[C('USER_AUTH_KEY')];
		$this->assign ( 'userid', $userid );
	
		$this->display ('lookupacquire');
		return;
	}
	
	
	function accept(){
		$name='MisSaleBusiness';
		$model = D ( $name );
		$id = $_REQUEST [$model->getPk ()];
		$map['id'] = $id;
		$data['businessstatus'] = 3;
		$data['userid'] =  $_SESSION[C('USER_AUTH_KEY')];
		$list=$model->where($map)->save($data);
		// 更新数据
		if (false !== $list) {
			//转交记录设置为受理
			$turnlogMode=M('mis_sale_business_turn_log');
			$turnlogMap['bid']=$id;
			$turnlogMap['shifoujieshou']=0;
			$turnlogMap['quxiao']=0;
			$turnlogMap['jieshouren']=$_SESSION[C('USER_AUTH_KEY')];
			$turnlogData['shifoujieshou']=1;
			$turnlogData['shifoujieshu']=1;
			$turnlogLits=$turnlogMode->where($turnlogMap)->save($turnlogData);
			if($turnlogLits==false){
				$this->error ( '修改转交记录失败' );
			}else{
				$this->success ( L('_SUCCESS_'));
			}
		} else {
			$this->error ( L('_ERROR_') );
		}
	}
	//取消退回原商机处理人
	function lookupreject(){
		$name='MisSaleBusiness';
		$model = D ( $name );
		$id = $_REQUEST ['id'];
		$name1='MisSaleBusinessAllot';
		$model1 = D ( $name1 );
		//查询原单据处理人
		$allotMap['bid']=$id;
		$allotMap['turnstatus']=0;
		$allotMap['zhuanpai']=1;
		$allotList=$model1->where($allotMap)->find();
		if($allotList['zhijiezhuanjiao']==1){
			//如果是直接转交的数据恢复新建 删除分派记录
			$map['id'] = $id;
			$data['businessstatus'] = 1;
			$list=$model->where($map)->save($data);
			if(false !== $list){
				$allotlistInfo=$model1->where($allotMap)->delete();
				
				if($allotlistInfo==false){
					$this->error ( L('_ERROR_') );
				}else{
					//转交记录设置为受理
					$turnlogMode=M('mis_sale_business_turn_log');
					$turnlogMap['bid']=$id;
					$turnlogMap['shifoujieshou']=0;
					$turnlogMap['jieshouren']=$_SESSION[C('USER_AUTH_KEY')];
					$turnlogMap['shifoujieshu']=0;
					$turnlogData['quxiao']=1;
					$turnlogData['quxiaoshijian']=time();
					$turnlogData['quxiaoliyou']=$_REQUEST['quxiaoliyou'];
					$turnlogData['shifoujieshu']=1;
					$turnlogLits=$turnlogMode->where($turnlogMap)->save($turnlogData);
					if($turnlogLits==false){
						$this->error ( L('_ERROR_') );
					}else{
						$this->success ( L('_SUCCESS_'));
					}
				}
			}else{
				$this->error ( L('_ERROR_') );
			}
			
		}else{
			$map['id'] = $id;
			$data['businessstatus'] = 3;
			$data['userid']=$allotList['zhuanpairen'];
			$list=$model->where($map)->save($data);
			if (false !== $list) {
				//设置转交
				
				$data1['bid'] = $id;
				$data1['userid'] = $allotList['zhuanpairen'];
				$data1['orderno'] = $allotList['orderno'];
				$data1['endtime'] = $allotList['endtime'];
				$data1['alloterid'] = $allotList['alloterid'];
				$data1['createid'] = $_SESSION[C('USER_AUTH_KEY')];
				$data1['companyid'] = $_SESSION[C('companyid')];
				$data1['createtime'] = time();
				$data1['zhuanpai'] = 0;
				$aList=$model1->add($data1);
				if($aList==false){
					$this->error ('取消失败' );
				}else{
					$allList=$model1->where($allotMap)->delete();
					if($allList==false){
						$this->error ('设置状态失败，取消失败' );
					}
					
					//转交记录设置为受理
					$turnlogMode=M('mis_sale_business_turn_log');
					$turnlogMap['bid']=$id;
					$turnlogMap['shifoujieshu']=0;
					$turnlogMap['shifoujieshou']=0;
					$turnlogMap['jieshouren']=$_SESSION[C('USER_AUTH_KEY')];
					$turnlogData['quxiao']=1;
					$turnlogData['shifoujieshu']=1;
					$turnlogData['quxiaoshijian']=time();
					$turnlogData['quxiaoliyou']=$_REQUEST['quxiaoliyou'];
					$turnlogLits=$turnlogMode->where($turnlogMap)->save($turnlogData);
					if($turnlogLits==false){
						$this->error ( '修改转交记录失败' );
					}else{
						$this->success ( L('_SUCCESS_'));
					}
				}
			} else {
				$this->error ( L('_ERROR_') );
			}
		}
		
	}
	function reject(){
		$name='MisSaleBusinessView';
		$model = D ( $name );
		$id = $_REQUEST['id'];
		$map['id'] = $id;
		$map['turnstatus'] = 0;
		$map['bid'] = $id;
		$list=$model->where($map)->find();
		$this->assign('vo',$list);
		$this->display();
	}

	//转交插入
	function lookupturnallot(){
		$id=$_REQUEST['id'];
		$allotid=$_REQUEST['allotid'];
		$MisSaleBusinessModel=D('MisSaleBusiness');
		$MisSaleBusinessAllotModel=D('MisSaleBusinessAllot');
		$busMap['id']=$id;
		$busDate['businessstatus']=2;
		$list=$MisSaleBusinessModel->where($busMap)->save($busDate);
		if($list==false){
			$this->error ('转交失败' );
		}
		$allotMap['id']=$allotid;
		//查询原单据
		$allotList=$MisSaleBusinessAllotModel->where($allotMap)->find();
		
		$data1['bid'] = $id;
		$data1['userid'] = $_REQUEST['userid'];
		$data1['orderno'] = $_REQUEST['orderno'];
		$data1['endtime'] = strtotime($_REQUEST['endtime']);
		$data1['alloterid'] = $allotList['alloterid'];
		$data1['createid'] = $_SESSION[C('USER_AUTH_KEY')];
		$data1['companyid'] = $_SESSION[C('companyid')];
		$data1['createtime'] = time();
		$data1['zhuanpai'] = 1;
		$data1['zhuanpairen'] = $_SESSION[C('USER_AUTH_KEY')];
		$aList=$MisSaleBusinessAllotModel->add($data1);
		if($aList==false){
			$this->error ('转交失败' );
		}else{
			$allotaList=$MisSaleBusinessAllotModel->where($allotMap)->delete();
			if($allotaList==false){
				$this->error ('转交失败' );
			}
			//添加转交数据
			$turnlogMode=M('mis_sale_business_turn_log');
			$turnlogData['bid']=$id;
			$turnlogData['zhuanjiaoren']=$_SESSION[C('USER_AUTH_KEY')];
			$turnlogData['jieshouren']=$_REQUEST['userid'];
			$turnlogData['createtime']=time();
			$turnlogData['quxiaoshijian']=time();
			$turnlogLits=$turnlogMode->add($turnlogData);
			if($turnlogLits==false){
				$this->error ( '添加转交记录失败' );
			}else{
				$this->success ( L('_SUCCESS_'));
			}
		}
	}
	function turn(){
		$name='MisSaleBusinessView';
		$model = D ( $name );
		$id = $_REQUEST['id'];
		$map['id'] = $id;
		$map['turnstatus'] = 0;
		$map['bid'] = $id;
		$list=$model->where($map)->find();
		$this->assign('vo',$list);
		$this->display();
	}

	function lookupacquireself(){
		//获取当前控制器名称
		$name='MisSaleBusiness';
		$model = D ( $name );
		//获取当前主键
		$id = $_REQUEST [$model->getPk ()];
		$map['id']=$id;
		$vo = $model->where($map)->find();
		//lookup带参数查询
		$userid =$_SESSION[C('USER_AUTH_KEY')];
		$name1='MisSaleBusinessAllot';
		$MisSaleBusinessAllotmodel = D ($name1);
		$data1['bid'] = $id;
		$data1['userid'] = $userid;
		$data1['endtime'] = $vo['endtime'];
		$data1['alloterid'] = $_SESSION[C('USER_AUTH_KEY')];
		$data1['updateid'] = $_SESSION[C('USER_AUTH_KEY')];
		$data1['createid'] = $_SESSION[C('USER_AUTH_KEY')];
		$data1['companyid'] = $_SESSION[C('companyid')];
		$data1['createtime'] = time();
		$data1['updatetime'] = time();
		//保存当前数据对象
		$list1=$MisSaleBusinessAllotmodel->add($data1);
		if (false !== $list1) {
			$name2='MisSaleBusiness';
			$MisSaleBusinessModel=D ($name2);
			// 修改以前的数据  修改为处理完成
			$map1['id'] = $id;
			$data['businessstatus'] = 3;
			$data['userid'] = $userid;
			$data['updatetime'] = time();
			$list=$MisSaleBusinessModel->where($map1)->save($data);
			// 更新数据
			if (false !== $list) {
			//添加分派数据
				$allotlogMode=M('mis_sale_business_allot_log');
				$allotlogData['bid']=$id;
				$allotlogData['fenpairen']=$_SESSION[C('USER_AUTH_KEY')];
				$allotlogData['yewuyuan']=$_SESSION[C('USER_AUTH_KEY')];
				$allotlogData['createtime']=time();
				$allotlogData['zidonghuoqu']=1;
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
	function _before_edit(){
		$userid=$_SESSION[C('USER_AUTH_KEY')];
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
		$this->checkifexistcodeororder('mis_sale_business','orderno','MisSaleBusiness');
		
		$acquiretime=strtotime($_REQUEST['acquiretime']);
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
		$days=trim($_REQUEST['days']);
		if(empty($days) || $days=='' || $days==0 ){
			$_POST['endtime']=null;
		}else{
			$_POST['endtime']=date("Y-m-d",strtotime("+".$days." day",$acquiretime));
		}
		
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
		
		$acquiretime=strtotime($_REQUEST['acquiretime']);
		$days=trim($_REQUEST['days']);
		
		if(empty($days) || $days == "" || $days==0){
			$_POST['endtime']=null;
		}else{
			$_POST['endtime']=date("Y-m-d",strtotime("+".$days." day",$acquiretime));
		}
	}
	
	function lookupgetSourceTime(){
		//查询有效天数
		$sourceid=$_REQUEST['sourceid'];
		$sourceModel=D('MisSaleBusinessSource');
		$map['id']=$sourceid;
		$list=$sourceModel->where($map)->find();
		$youxiaotianshu=$list['youxiaotianshu'];
		echo json_encode($youxiaotianshu);
	}
}
?>