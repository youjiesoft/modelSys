<?php
/**
 * @Title: MisSalesMyProjectRolegroupAction
 * @Package package_name
 * @Description: todo(项目权限组管理)
 * @author yangxi
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-15 下午6:04:23
 * @version V1.0
 */
class MisSalesMyProjectRolegroupAction extends CommonAction {
	public function _filter(& $map) {
		if ($_SESSION["a"] != 1) $map['status']=array("gt",-1);
	}
	
	public function index(){
		$this->display('index');
	}
	//进入授权页面	
	function roleGroupAuthorize(){
		$map['id'] = $_REQUEST['rolegroupid'];
		$name['title']='项目权限管理';
		$model = M('mis_sales_project_rolegroup');
		$list = $model->where($map)->find();
		$modelProject = M('mis_auto_kimpu');
		if($list['dandushouquanID']){//如果有单独授权ID则查询出显示到页面
			$map = array();
			$map['id'] = array('in',$list['dandushouquanID']);
			$listProject = $modelProject->where($map)->order('id desc')->getField('orderno',true);
			$listProjectstring=implode(' ',$listProject);
			$this->assign('listProjectstring',$listProjectstring);
			
		}
		
		$this->assign('rolegroupid',$_REQUEST['rolegroupid']);
		$this->assign('nodelist',$name);
		$this->assign('vo',$list);
		$this->display('roleGroupAuthorizeRight');
	}
	//添加或修改组权限方法
	function writeRoleGroup(){
		//根据表ID查询数据 
		$map['id'] = $_POST['rolegroupid'];
		$model = D('MisSalesMyProjectRolegroup');
		//根据组ID查询到数据
		$list = $model->where($map)->select();
		//过滤条件判断 如果有 则添加进去
		if($_POST['rules']){
			$data['rules'] = $_POST['rules'];
			$data['showrules'] = $_POST['showrules'];
			$data['rulesinfo'] = $_POST['rulesinfo'];
		}else{
			$data['rules'] = "";
			$data['showrules'] = "";
			$data['rulesinfo'] = "";
		}
		//判断是否有单独授权的项目ID
		if ($_POST['dandushouquanID']){
			$data['dandushouquanID'] = $_POST['dandushouquanID'];
		}else{
			$data['dandushouquanID'] = "";
		}
		//判断是否有数据
		if(!$list){
			$this->error('没有此用户组');
		}else{
			//获取需要更新权限值
			$data['plevels'] = $_REQUEST['plevels'];
			if($list){
				//修改人的数据信息
				$data['updatetime']=time();
				$data['updateid']=$_SESSION[C('USER_AUTH_KEY')];
				$ret=$model->where($map)->save($data);
			}
			if($ret===false){
				$this->error($model->getDBError());
			}else{
				$this->success('保存成功');
			}
		}
	}

	
	//获取用户列表
	public function lookupRoleGroupPerson(){
		$model=D("User");
		// 获取选中组
		$group    =   D("MisSalesMyProjectRolegroup");
		//获取当前用户组信息
		$groupId =  isset($_REQUEST['selectGroupId'])?$_REQUEST['selectGroupId']:'';
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
			$groupUserList = $model->where($groupmap)->getField('id,account,name,duty_id,dept_id');
		}
		$this->assign('groupUserList',$groupUserList);
		$this->assign('selectGroupId',$_REQUEST['selectGroupId']);
	
		$map = array();
		$map['status'] = array('GT',0);
		//是管理员的不显示出来
		//$map['name'] = array('NEQ','管理员');
		if (method_exists ( $this, '_filterLookupSelectUser' )) {
			$this->_filterLookupSelectUser ( $map );
		}
		$list = $model->field("id,name,dept_id,email,mobile,pinyin")->where($map)->order('sort ASC')->select();
		foreach ($list as $uk=>$uval){
			if($uval['employeid']){
				$working=getFieldBy($uval['employeid'], 'id', 'working', 'mis_hr_personnel_person_info');
				if($working==0){
					unset($list[$uk]);
				}
			}
		}
		$num = count($list);
		$this->assign("num",$num);// 总人数
		$returnarr = array();
		$dptmodel = D("MisSystemDepartment");//部门表
		$deptlist = $dptmodel->where("status=1")->order("id asc")->field('id,name,parentid')->select();
		//部门树形
		$returnarr=$dptmodel->getDeptZtree($_SESSION['companyid'],'','','','',1);
		$this->assign('usertree',$returnarr);
		//用户组的树
		$rolegroup = array();
		$rolegroupModel = D('MisSalesMyProjectRolegroup');
		$rolegroupList = $rolegroupModel->where("status=1")->order("id asc")->field('id,name,pid')->select();//所有的组
		$rolegroup_userModel = M('rolegroup_user');
		$rolegroup_userList = $rolegroup_userModel->field("rolegroup_id,user_id")->order('rolegroup_id ASC')->select();
		foreach ($rolegroupList as $k => $v) {
			foreach ($rolegroup_userList as $k2 => $v2) {
				if($v["id"] == $v2["rolegroup_id"]){
					$rolegroupList[$k]["useridarr"][] = $v2["user_id"];
				}
			}
		}
		foreach($rolegroupList as $ke=>$va){
			$newRole=array();
			$newRole['id'] = -$va['id'];
			$newRole['pId'] = 0;
			$newRole['title'] = $va['name']; //光标提示信息
			$newRole['name'] = missubstr($va['name'],18,true); //结点名字，太多会被截取,针对于现在的ZTREE，宽度不能超过18个字符。
			$newRole['open'] = false;
			$istrue = false;
			$userarr = array();
			$usernamearr = array();
			$emailarr = array();
			foreach ($list as $k2 => $v2) {
				if(in_array($v2['id'],$va["useridarr"])){
					$istrue = true;
					$newv2 = array();
					$userarr[] = $v2['id'];
					$usernamearr[] = $v2['name'];
					$emailarr[] = $v2['email'];
					$newv2['email'] = $v2['email'];
					$newv2['id'] = $v2['id'];
					$newv2['userid'] = $v2['id'];
					$newv2['pId'] = -$va['id'];
					$newv2['pinyin'] = $v2['pinyin']; //拼音
					$newv2['title'] = $v2['name']; //光标提示信息
					$newv2['username'] = $v2['name']; //光标提示信息
					$newv2['name'] = missubstr($v2['name'],18,true); //结点名字，太多会被截取,针对于现在的ZTREE，宽度不能超过18个字符。
					$newv2['icon'] = "__PUBLIC__/Images/icon/group.png";
					$newv2['open'] = false;
					array_push($rolegroup,$newv2);
				}
			}
			if($istrue){
				$newRole["userid"] = implode(",",$userarr);
				$newRole["email"] = implode(",",$emailarr);
				$newRole["username"] = implode(",",$usernamearr);
				array_push($rolegroup,$newRole);
			}
		}
		// 		dump($rolegroup);
		$this->assign('rolegrouptree',json_encode($rolegroup));
		//公司的树
		$companytree=$dptmodel->getDeptZtree('','','','','',2);
		$this->assign('sysCompanytree',$companytree);
		// 		$this->assign('usertree',$returnarr);
	
		$this->assign('data',$_POST["data"]);
		$this->assign('ulid',$_POST["ulid"]);
		if($_POST["ulid"]){
			$this->display("multiple");// 选多个用户
		} else {
			$this->display("singleUser");// 选单个用户
		}
	}
	
	/*
	+----------------------------------------------------------
	* 用户增加组操作权限
	+----------------------------------------------------------
	* @access public
	+----------------------------------------------------------
	* @return void
	+----------------------------------------------------------
	* @throws FcsException
	+----------------------------------------------------------
	*/
	public function setUser() {
		$id     = $_POST['groupUserId'];
		$groupId	=	$_POST['groupId'];
		$group    =   D("MisSalesMyProjectRolegroup");
		$group->delGroupUser($groupId);
		$result = $group->setGroupUsers($groupId,$id);
		var_dump($_POST['groupUserId']);
		if($result===false) {
			$this->error('授权失败！');
		}else {
			//删除浏览权限文件
			//删除浏览级别权限
			$obj_dir = new Dir;
			$directory =  DConfig_PATH."/BrowsecList";
			if(isset($directory)){
				$obj_dir->del($directory);
			}
			$this->success('授权成功！');
		}
	}
	//删除组 还有组以下的所有人员
	public function delete(){
		$id = $_GET['id'];
		$model = M("mis_sales_project_rolegroup");
		$getlist = $model->where('id='.$id)->select();
		if($getlist){
			$list = $model->where('id='.$id)->delete();
			if($list<1){
				$this->error('授权组删除失败');
			}
			$modeluser = M('mis_sales_project_rolegroup_user');
			//判断授权组下的用户
			$list = $modeluser->where('rolegroup_id='.$id)->delete();
			$this->success('删除成功');
		}else{
			$this->error('授权组删除失败');
		}
	}
}
?>