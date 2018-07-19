<?php
/**
 * @Title: ProcessRoleAction 
 * @Package package_name 
 * @Description: todo(流程角色管理) 
 * @author laicaixia 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-4-2 下午3:35:15 
 * @version V1.0
 */
class ProcessRoleAction extends CommonAction {	
	/**
	 * @Title: _empty 
	 * @Description: todo(空操作判定方法)   
	 * @author liminggang 
	 * @date 2013-6-1 下午2:22:59 
	 * @throws
	 */
	public function _empty() {
		//空操作
		$this->error("您访问的页面不存在！");
	}
	
	/**
	 * @Title: _filter(& $map)  ||  _before_index()
	 * @Description: todo(首页的检索)
	 */
	public function _filter(& $map) {
		if ($_SESSION["a"] != 1);
		$map['status']=1;
		// 获取查询条件
		$searchby	= $this->escapeChar($_POST['searchby']);
		$searchtype	= $this->escapeChar($_POST['searchtype']);
		$keyword	= $this->escapeChar($_POST['keyword']);
		$this->assign('searchby', $searchby);
		$this->assign('searchtype', $searchtype);
		$this->assign('keyword', $keyword);
		if ($keyword) {
			$map[$searchby] = ($searchtype==2) ? array('like',"%".$keyword."%"):$keyword;
		}
	}
	public function _before_index() {
		$searchtype = array (
			array ("id" => "2","val" => "模糊查找"),
			array ("id" => "1","val" => "精确查找")
		);
		$this->assign('searchtypelist', $searchtype);
	}
	
	/**
	 * @Title: _before_add()
	 * @Description: todo(进入新增)
	 */
	public function _before_add() {
		//获取部门
		$deptmodel = D('MisSystemDepartment'); //部门表
		$deptlist = $deptmodel->where('status = 1')->getField('id,name');//查询部门
		$deptStr = '';//构造对像
		foreach ($deptlist as $k => $v) {
			$deptStr .= '<li>';
			$deptStr .= '<input type="checkbox" class="parentCls" name="deptid[]" value="'.$k.'" onclick="deptChecked(\'deptDivVal_add\',this)"/>';
			$deptStr .= '<span>'.$v.'</span></li>';
		}
		$this->assign("deptStr", $deptStr);
		//获取用户
		$user = D("User");//用户表
		$list2=$user->where('status = 1')->select();//查询用户
// 		$userStr = '';//构造对像
// 		foreach ($list2 as $k => $v) {
// 			$userStr .= '<li>';
// 			$userStr .= '<input type="checkbox" class="parentCls" name="userid[]" value="'.$k.'"/>';
// 			$userStr .= $v.'</li>';
// 		}
		$this->assign('userlist',$list2);
// 		$this->assign('userStr',$userStr);
	}
	public function _before_edit() {
		
	}	
	/**
	 * @Title:_before_insert
	 * @Description: todo(执行新增)
	 */
	public function _before_insert() {
		$this->common();
	}
	
	/**
	 * @Title:_after_edit(&$vo)
	 * @Description: todo(进入修改)
	 */
	public function _after_edit(&$vo) {
		//获取部门
		$deptmodel = D('MisSystemDepartment'); //部门表
		$deptlist = $deptmodel->where('status = 1')->getField('id,name');//查询部门
		$deptStr = '';//构造对像
		$vo['deptid'] = explode(",", $vo['deptid']);//转换字符串
		$deptCheckList = array();
		foreach ($deptlist as $k => $v) {
			$deptStr .= '<li>';
			if(in_array($k,$vo['deptid'])){
				$deptCheckList[] = $v;
				$deptStr .= '<input type="checkbox" class="parentCls" name="deptid[]" value="'.$k.'" checked="checked" onclick="deptChecked(\'deptDivVal_edit\',this)"/>';
			} else {
				$deptStr .= '<input type="checkbox" class="parentCls" name="deptid[]" value="'.$k.'" onclick="deptChecked(\'deptDivVal_edit\',this)"/>';
			}
			$deptStr .= '<span>'.$v.'</span></li>';
		}
		$this->assign("deptStr", $deptStr);
		$this->assign("deptCheckStr", implode(',', $deptCheckList));
		//获取用户
		$user = D("User");//用户表
		$userlist2=$user->where('status = 1')->select();//查询用户名
		$vo['userid'] = explode(",", $vo['userid']);//转换字符串
		$userlist = array();
		$userCheckList = array();
		foreach ($userlist2 as $k => $v) {
			if(in_array($v['id'],$vo['userid'])){
				$v['checked'] = true;
				$userCheckList[] = $v['name'];
				$userlist[$v['id']] = $v;
			}
		}
		foreach ($userlist2 as $k => $v) {
			if(!$userlist[$v['id']]){
				$v['checked'] = false;
				$userlist[$v['id']] = $v;
			}
		}
		$this->assign('userlist',$userlist);
		$this->assign("userCheckStr", implode(',', $userCheckList));
// 		$userStr = '';//构造对像
// 		$vo['userid'] = explode(",", $vo['userid']);//转换字符串
// 		foreach ($userlist2 as $k => $v) {
// 			$userStr .= '<li>';
// 			if(in_array($k,$vo['userid'])){
// 				$userStr .= '<input type="checkbox" class="parentCls" name="userid[]" value="'.$k.'" checked="checked"/>';
// 			}else{
// 				$userStr .= '<input type="checkbox" class="parentCls" name="userid[]" value="'.$k.'"/>';
// 			}
// 			$userStr .= $v.'</li>';
// 		}
// 		$this->assign('userStr',$userStr);
	}
	
	/**
	 * @Title:_before_update
	 * @Description: todo(执行更新)
	 */
	public function _before_update() {
		$this->common();
	}
	
	/**
	 * @Title:common()
	 * @Description: todo(公共方法)
	 */
	private function common(){
		//转换字符串【 部门（deptid）| 用户（userid）】
		if($_POST['deptid']) {
			$_POST['deptid'] = implode(',',$_POST['deptid']);
		} else {
			$_POST['deptid'] = '';
		}
		if($_POST['userid']) {
			$_POST['userid'] = implode(',',$_POST['userid']);
		} else {
			$_POST['userid'] = '';
		}
	}
}
?>