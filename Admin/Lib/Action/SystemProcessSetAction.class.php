<?php
/**
 * 
 * @Title: SystemProcessSetAction 
 * @Package package_name 
 * @Description: todo(系统流程配置) 
 * @author mashihe 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2011-1-7 下午3:40:39 
 * @version V1.0
 */
class SystemProcessSetAction extends CommonAction {
	/**
	 * (non-PHPdoc)
	 * 首页列表展示方法
	 * @see CommonAction::index()
	 */
	public function index() {
		$pid = $_POST['pid'];
		$typeid = $_POST['typeid'];
		//获取流程列表
		if($typeid){
			$map['status'] = 1;
			$map['typeid'] = $typeid;
			$model = D('ProcessInfo');
			$tylist = $model->where($map)->order('id desc')->select();
			$this->assign("tylist", $tylist);
		}
		$model = M("process_type");
		$typelist = $model->where("status = 1")->select();
		$this->assign ( 'typelist',$typelist);
		$ProcessNowSelected = Cookie::get("ProcessNowSelected");
		if ( $ProcessNowSelected ) {
			$pid = $ProcessNowSelected;
			$model=M("process_info");
			$typeid= $model->where("id=".$pid)->getField("typeid");
			$map2['status'] = 1;
			$map2['typeid'] = $typeid;
			$model = D('ProcessInfo');
			$tylist = $model->where($map2)->order('id desc')->select();
			$this->assign("tylist", $tylist);
			Cookie::delete("ProcessNowSelected");
		}
		if ($pid == '') {
			//节点条件
			//固定值节点-2流程新建,-1流程结束,0流程开始，已经为固定数据插入
			$condition['status'] = 1;
			$model = D('ProcessTemplate');
			$list = $model->where($condition)->select();
			$this->assign("list", $list);
		} else {
			//节点条件
			$model1 = D('ProcessRelation');
			$list1 = $model1->where('pid=' . $pid)->getField('tid,sort');
			$tid = array_keys($list1);
			$condition['status'] = 1;
			if ($tid) {
				$condition['id'] = array ('not in', $tid);
			}
			$model = D('ProcessTemplate');
			$list = $model->where($condition)->select();
			$this->assign("list", $list);
			$this->assign("sspid", $pid);
			$this->assign("typeid", $typeid);
			$this->getnode($pid);
		}
		$this->display();
	}
	/**
	 * @Title: comboxgetprocess 
	 * @Description: todo(选择部门加载加载流程)   
	 * @author 杨东 
	 * @date 2013-3-27 下午12:01:37 
	 * @throws
	 */
	public function comboxgetprocess(){
		$model=M("process_info");
		$typeid =$_POST['typeid'];
		$arr=array(array("","&mdash;&mdash;选择类型&mdash;&mdash;"));
		if ($typeid!='') {
			$map['typeid']=$typeid;
			$list = $model->where("typeid =".$typeid." or typeid=0")->order('id desc')->select();
			foreach($list as $k=>$v ){
				array_push($arr,array($v['id'], $v['name']));
			}
		}
		
		echo json_encode($arr);
	}
	/**
	 * @Title: getnode 
	 * @Description: todo(获取当前流程节点) 
	 * @param $pid  流程ID
	 * @author 杨东 
	 * @date 2013-3-27 下午12:00:41 
	 * @throws
	 */
	private function getnode($pid) {
		//判断是否已经启用
		$model1 = D('ProcessInfo');
		$condition['id'] = $pid;
		$status = $model1->where($condition)->getField('status');
		$this->assign('status', $status);
		$model = D("ProcessTemplate");
		if ($pid) {
			$sql = " and pr.pid=".$pid;
		}
		$info = $model->table('process_template as pt,process_relation as pr')->where('pt.id=pr.tid '.$sql)->field('pr.tid as tid,pt.name as name,pr.userid as userid,pr.duty as duty')->order('pr.sort')->select();
		$nodenum = count($info);
		foreach ($info as $key => $val) {
			$str .= '<li class="itemID" onmouseover="tips_over(this);" onmouseout="tips_out(this);">' .
					'<b class="b1"></b><b class="b2 d1"></b><b class="b3 d1"></b><b class="b4 d1">' .
					'</b><div class="b d1 k" ><input type="hidden" name="tid[]" value="' . $val['tid'] . '"/>' . $val['name'];
			if ($val['userid'] || $val['duty']) {
				$str .= '<font style="color:#FF0000;">(已授权)</font>';
				$i = $i+1;
			}
			$str .= '</div><div class="process_ico"></div><b class="b4b d1"></b>' .
					'<b class="b3b d1"></b><b class="b2b d1"></b><b class="b1b"></b>' ;
			$str .= '<span><a href="' . __URL__ . '/accredit/pid/' . $pid . '/tid/' . $val['tid'] . '" ' .
					'target="dialog" width="800" height="500" title="授权流程节点">授权</a>&nbsp;';
			$str .= '<a href="' . __URL__ . '/processconditon/pid/' . $pid . '/tid/' . $val['tid'] . '" ' .
					'target="dialog" title="该节点条件">条件</a></span>';
			$str .= '</li>';
		}
		if ($status == 2) {
			if ($nodenum == 0) {
				$this->assign('priv', 0);
			} else {
				if ($i == $nodenum) {
					$this->assign('priv', 1);
				} else {
					$this->assign('priv', 0);
				}
			}
		}
		$this->assign("str", $str);
	}
	/**
	 * @Title: processconditon 
	 * @Description: todo(流程节点条件规则方法输出模板)   
	 * @author liminggang 
	 * @date 2013-6-1 下午2:09:41 
	 * @throws
	 */
	public function processconditon(){
		$save = $_POST['save'];
		$model = D("ProcessRelation");
		if($save==1){
			$map["id"]=$_POST["id"];
			$re = $model->where($map)->setField("rules",$_POST["rules"]);
			if ($re!==false) {
				Cookie::set("ProcessNowSelected",$_POST['pid']);
				$this->success ( L('_SUCCESS_') );
			} else {
				$this->error ( L('_ERROR_') );
			}
		}
		$vo = $model->where("pid='" . $_REQUEST['pid'] . "' and tid='" . $_REQUEST['tid'] . "'")->find();
		$this->assign("vo", $vo);
		$this->display();
	}
	
	/**
	 * @Title: update
	 * @Description: todo(设置流程走向： 比如说 流程开始-->申请部门-->行政部门-->......->流程结束)   
	 * @author mashihe 
	 * @throws
	 */
	public function update() {
		//保存节点数据
		$model = D('ProcessRelation');
		//获取总数
		$count = $model->where("pid='" . $_POST['pid'] . "'")->count('id');
		$c['pid'] = $_POST['pid'];
		$temp = $_POST['tid'];
		if ($temp) {
			$c['tid'] = array('not in',$temp);
		}
		$model->where($c)->delete();
		foreach ($temp as $key => $val) {
			//判断流程模块是否存在
			$c2['pid'] = $_POST['pid'];
			$c2['tid'] = $val;
			$id = $model->where($c2)->getField('id');
			if ($id) {
				$data = array (
					'sort' => $key,
					'status' => 1
				);
				$list = $model->where(" id='" . $id . "' ")->save($data);
			} else {
				$data = array (
					'pid' => $_POST['pid'],
					'tid' => $val,
					'sort' => $key,
					'status' => 1,
				);
				$list = $model->data($data)->add();
			}
		}
		if ($list !== false) { //保存成功
			Cookie::set("ProcessNowSelected",$_POST['pid']);
			$this->assign ( 'jumpUrl', Cookie::get ( '_currentUrl_' ) );
			$this->success(L('_SUCCESS_'));
		} else {
			$this->error(L('_ERROR_'));
		}
	}
	/**
	 * @Title: accredit 
	 * @Description: todo(流程节点授权)   
	 * @author 杨东 
	 * @date 2013-3-27 上午11:57:59 
	 * @throws
	 */
	public function accredit() {
		$model = D("ProcessRelation");
		$list = $model->where("pid='" . $_REQUEST['pid'] . "' and tid='" . $_REQUEST['tid'] . "'")->find();
		$this->assign("vo", $list);
		if (isset($_REQUEST['step'])) {
			//判断有没有向前或向后并行
			$has_pre = $model->where("pid=" . $list['pid'] . " and sort < " . $list['sort'])->count('*');
			$has_next = $model->where("pid=". $list['pid'] . " and sort > " . $list['sort'])->count('*');
			if($has_pre==0 ) $has_next=0;
			$this->assign("pre", $has_pre);
			$this->assign("next", $has_next);
			
			if ($_REQUEST['step'] == 0) {
				/**
				 * 按用户授权
				 */
				//查询对应的流程节点
				$list['userid'] = explode(",", $list['userid']);
				$usermodel = D("User");//初始化用户表
				$usermap1['id'] = array('in',$list['userid']);
				$rolelist = $usermodel->where($usermap1)->distinct(true)->field('dept_id')->select();
				$role = array();
				foreach ($rolelist as $k => $v) {
					$role[] = $v['dept_id'];
				}
				$list['role'] = $role;
				//获取部门
				$deptmodel = D('MisSystemDepartment'); //部门模型
				$deptlist = $deptmodel->where('status = 1')->getField('id,name');
				foreach ($deptlist as $k => $v) {
					//获取部门下的用户
					$usermap['status'] = 1;
					$usermap['dept_id'] = $k;
					$userlist = $usermodel->where($usermap)->getField('id,name');
					if ($userlist) {
						$str .= "<div id='accredituser$k' class='unit textInput' style='margin-top:5px;width: 100%;'><label>";
						if (in_array($k,$list['role'])) {
							$str .= "<input type='checkbox' class='parentCls' onClick='nowchecked(\"accredituser$k\");' checked='true' />";
						} else {
							$str .= "<input type='checkbox' class='parentCls' onClick='nowchecked(\"accredituser$k\");' />";
						}
						$str .= $v. '：</label><div class="divider"></div><ul class="userul">';
						foreach ($userlist as $k1 => $v1) {
							$str .= '<li>';
							//判断用户选中
							if(in_array($k1,$list['userid'])){
								$str .= '<input type="checkbox" onclick="subCheck(\'accredituser'.$k.'\');" name="userid[]" value="'.$k1.'" checked="true" />';
							}else{
								$str .= '<input type="checkbox" onclick="subCheck(\'accredituser'.$k.'\');" name="userid[]" value="'.$k1.'" />';
							}
							$str .= $v1.'</li>';
						}
						$str .= '</ul></div>';
					}
				}
				$this->assign("str", $str);
				$this->display('accredituser');
				exit;
			}
			else if ($_REQUEST['step'] == 1) {//按职级授权
				//获取职级
				$dutymodel = M('mis_system_duty');
				$dutylist = $dutymodel->where("status = 1")->getField('id,name',true);
				$selected_duty = explode(",", $list['duty']);
				$this->assign("selected_duty", $selected_duty);
				$this->assign("dutylist", $dutylist);
				//获取部门
				$deptmodel = D('MisSystemDepartment'); //部门模型
				$deptlist = $deptmodel->where('status = 1')->getField('id,name',true);
				$selected_dept = explode(",", $list['role']);
				$this->assign("selected_dept", $selected_dept);
				$this->assign("deptlist", $deptlist);
				$this->display('accreditrank');
				exit;
			}
			else if ($_REQUEST['step'] == 2) {
				/**
				 * 按项目授权
				 */
				$m=M("mis_sales_project_usertype");
				$projectList = $m->where("status=1")->order("sort asc")->getField("id,name",true);
				
				if ($list['step'] == 2) {
					$list['duty'] = explode(",", $list['duty']);
				} else {
					$list['duty'] = 0;
				}
				$projectStr = '';
				foreach ($projectList as $k => $v) {
					$projectStr .= '<li>';
					if(in_array($k,$list['duty'])){
						$projectStr .= '<input type="checkbox" class="parentCls" name="duty[]" value="'.$k.'" checked="checked"/>';
					} else {
						$projectStr .= '<input type="checkbox" class="parentCls" name="duty[]" value="'.$k.'"/>';
					}
					$projectStr .= $v.'</li>';
				}
				$this->assign("projectStr", $projectStr);
				$this->display('accrediproject');
				exit;
			}
			else if ($_REQUEST['step'] == 3) {
				/**
				 * 按流程审核角色授权
				 */
				/**
				 * 按项目授权
				 */
				$model = D('ProcessRole');
				$roleList = $model->where('status = 1')->getField('id,name');
				if ($list['step'] == 3) {
					$list['duty'] = explode(",", $list['duty']);
				} else {
					$list['duty'] = 0;
				}
				$roleStr = '';
				foreach ($roleList as $k => $v) {
					$roleStr .= '<li>';
					if(in_array($k,$list['duty'])){
						$roleStr .= '<input type="checkbox" class="parentCls" name="duty[]" value="'.$k.'" checked="checked"/>';
					} else {
						$roleStr .= '<input type="checkbox" class="parentCls" name="duty[]" value="'.$k.'"/>';
					}
					$roleStr .= $v.'</li>';
				}
				$this->assign("roleStr", $roleStr);
				$this->display('accredirole');
				exit;
			}
			else if($_REQUEST['step'] == 4){
				//获取职级 
				$dutymodel = M('mis_system_duty');
				$dutylist = $dutymodel->where("status = 1")->getField('id,name',true);
				if ($list['step'] == 4) {
					$selected_duty = explode(",", $list['duty']);
					$this->assign("selected_duty_step_four", $selected_duty);
					$selected_dept = explode(",", $list['role']);
					$this->assign("selected_dept_four", $selected_dept);
				}
				$this->assign("dutylist", $dutylist);
				//获取部门
				$deptmodel = D('MisSystemDepartment'); //部门模型
				$deptlist = $deptmodel->where('status = 1')->getField('id,name',true);
				
				$this->assign("deptlist", $deptlist);
				$this->display('accreditoption');
				exit;
			}
		} else {
			/**
			 * 进入授权界面
			 */
			$this->display();
			exit;
		}
	}
}
?>