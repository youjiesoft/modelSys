<?php
/**
 * 
 * @Title: MisSaleProjectProgressAction 
 * @Package package_name
 * @Description: todo( 系统报表) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2015年5月6日 上午11:37:55 
 * @version V1.0
 */
class MisSaleProjectProgressAction extends CommonAction {
	public function businessCaseAnalysis(){
		$name = $this->getActionName();
		$model = D($name);
		$projectNumber = $model->getProjectNumber();
		$itemAmount = $model->getItemAmount();
		$this->assign('projectNumber',$projectNumber);
		$this->assign('itemAmount',$itemAmount);
		$this->display();
	}
	public function index(){
		$name = $this->getActionName();
		$model = D($name);
		$MisSystemCompanyModel=D("MisSystemCompany");
		$MisSystemCompanyid=$MisSystemCompanyModel->getCompanyOne();
		$companyid=$_SESSION['companyid']?$_SESSION['companyid']:$MisSystemCompanyid;
		$list = $model->getProgressList($companyid);
		$this->assign('list',$list);
		$this->display();
	}
	/**
	 * 
	 * @Title: projectMessage
	 * @Description: todo(项目详细信息)   
	 * @author renling 
	 * @date 2015年5月13日 下午1:50:28 
	 * @throws
	 */
	public function projectMessage(){
		$name = $this->getActionName();
		$model = D($name);
		$list = $model->getProgressMessage();
		$this->assign("list",$list);
		$this->display();
	}
}
?>