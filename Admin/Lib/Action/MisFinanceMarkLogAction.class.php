<?php
/**
 * @Title: MisFinanceBankAccountAction
 * @Package 财务-盖章登记管理：功能类
 * @Description: TODO(盖章登记管理)
 * @author eagle
 * @company 重庆特米洛科技有限公司˾
 * @copyright 重庆特米洛科技有限公司˾
 * @date 2012-6-10 19:18:54
 * @version V1.0
 */
class MisFinanceMarkLogAction extends CommonAuditAction {
	/** @Title: _filter
	 * @Description: (构造检索条件) 
	 * $map 条件数组  
	 * @author liminggang 
	 * @date 2013-5-31 下午3:59:44 
	 * @throws 
	*/  
	public function _filter(&$map){
		if ($_SESSION["a"] != 1) $map['status']=array("gt",-1);
	}

	/** @Title: _before_add
	 * @Description: (添加前缀函数) 
	 * @author liminggang 
	 * @date 2013-5-31 下午3:59:44 
	 * @throws 
	*/ 
	public function _before_add(){
		//查询所有部门信息
		$deptmodel = D("MisSystemDepartment");
		$deptlist=$deptmodel->where("status=1")->select();
		//selectTree做用是生成树型结构的下接选择
		$deptlists=$this->selectTree($deptlist);
		$this->assign("deptlist",$deptlists);
		//获取盖章类型	
// 		$otypeModel=D("MisOrderTypes");
// 		$list=$otypeModel->where("groupid=7 and type=89 and status=1")->select();
// 		$this->assign("list",$list);
		//dirct 2014 04 26
		$MisSealOfRegistrationModel = D("MisSealOfRegistration");
		//主章
		$mainlist = $MisSealOfRegistrationModel->where("status = 1 and typeid = 1")->field("id,name")->select();
		$this->assign('mainlist',$mainlist);
		//辅章
		$auxlist = $MisSealOfRegistrationModel->where("status = 1 and typeid = 2")->field("id,name")->select();
		$this->assign('auxlist',$auxlist);
		$this->assign('createid',$_SESSION[C('USER_AUTH_KEY')]);
		$this->assign('time',time());
	}

	/** @Title: _before_edit
	 * @Description: (修改前缀函数)
	 * @author liminggang
	 * @date 2013-5-31 下午3:59:44
	 * @throws
	 */
	public function _before_edit(){
		$id = $_REQUEST ['id'];
		$map['id']=$id;
		//查出当前记录的部门ID
		$modelHRET = D($this->getActionName());
		$modelHRETList = $modelHRET->where($map)->find();
		//查询所有部门信息
		$deptmodel = D("MisSystemDepartment");
		$deptlist=$deptmodel->where("status=1")->select();
		//selectTree做用是生成树型结构的下接选择
		$deptlists=$this->selectTree($deptlist,0,0,$modelHRETList['department_id']);
		$this->assign("deptlist",$deptlists);
		//dirct 2014 04 26
		$MisSealOfRegistrationModel = D("MisSealOfRegistration");
		//主章
		$mainlist = $MisSealOfRegistrationModel->where("status = 1 and typeid = 1")->field("id,name")->select();
		$this->assign('mainlist',$mainlist);
		//辅章
		$auxlist = $MisSealOfRegistrationModel->where("status = 1 and typeid = 2")->field("id,name")->select();
		$this->assign('auxlist',$auxlist);
		//查询处理状态
		$this->getdotype();
	}
	/**
	 * @Title: _before_auditEdit
	 * @Description: todo(打开审核页面前置函数)
	 * @author
	 * @date 2013-5-31 下午4:14:13
	 * @throws
	 */
	public function _before_auditEdit(){
		$id = $_REQUEST ['id'];
		$map['id']=$id;
		//查出当前记录的部门ID
		$modelHRET = D($this->getActionName());
		$modelHRETList = $modelHRET->where($map)->find();
		//查询所有部门信息
		$deptmodel = D("MisSystemDepartment");
		$deptlist=$deptmodel->where("status=1")->select();
		//selectTree做用是生成树型结构的下接选择
		$deptlists=$this->selectTree($deptlist,0,0,$modelHRETList['department_id']);
		$this->assign("deptlist",$deptlists);
	}
	/**
	 * @Title: _before_auditView
	 * @Description: todo(打开审核预览前置函数)
	 * @author
	 * @date 2013-5-31 下午4:14:56
	 * @throws
	 */
	public function _before_auditView(){
		$id = $_REQUEST ['id'];
		$map['id']=$id;
		//查出当前记录的部门ID
		$modelHRET = D($this->getActionName());
		$modelHRETList = $modelHRET->where($map)->find();
		//查询所有部门信息
		$deptmodel = D("MisSystemDepartment");
		$deptlist=$deptmodel->where("status=1")->select();
		//selectTree做用是生成树型结构的下接选择
		$deptlists=$this->selectTree($deptlist,0,0,$modelHRETList['department_id']);
		$this->assign("deptlist",$deptlists);
		//查询处理状态
		$this->getdotype();
	}
	/**
	 * @Title: seal 
	 * @Description: todo(盖章)   
	 * @author liminggang 
	 * @date 2014-4-22 上午9:19:53 
	 * @throws
	 */
	public function seal(){
		$id = $_POST['id'];	
		$model=D($this->getActionName());
		$data['id'] = $id;
		$data['sealuserid'] = $_SESSION[C('USER_AUTH_KEY')];
		$data['sealtime'] = time();
		$result=$model->save($data);
		if($result===false){
			$this->error("盖章失败");
		}else{
			$this->success("盖章成功");
		}
	}
}
?>