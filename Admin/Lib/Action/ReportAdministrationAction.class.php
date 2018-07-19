<?php
/**
 * @Title: ReportStorageAction
 * @Package package_name
 * @Description: todo(行政报表控制器)
 * @author renling
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-4-24 下午4:30:43
 * @version V1.0
 */
class ReportAdministrationAction extends CommonAction{
	/**
	 * (non-PHPdoc)
	 * @Description: todo(行政报表列表提示信息)
	 * @see CommonAction::index()
	 */
	public function index(){
		$this->error("请选择该模板下具体相应报表");
		exit;
	}
		
	/**
	 * @Title: getCarOilReport
	 * @Description: todo(入库流水账报表检索输出模板方法)
	 * @author renling
	 * @date 2013-5-16 下午5:03:23
	 * @throws
	 */
	public function getCarOilReport(){
		//是否需要输入检索条件状态值。
		$result=$this->isReportIssearch("getCarOilReport");
		$this->assign('result',$result);
		$this->display();
	}
	/**
	 * @Title: lookupGetCarOilReport 
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author liminggang 
	 * @date 2013-7-24 下午5:17:54 
	 * @throws
	 */
	public function lookupGetCarOilReport(){
		//用于导出数据传参
		$this->assign('reporttype','lookupGetCarOilReport');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupGetCarOilReport');
		$suburl = str_replace('lookupGetCarOilReport','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$model = D("ReportAdministration");
			echo $model->getGetCarOilEport($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'序号','部门','车牌','车型','姓名','油卡号','中石化加油站','余额','合计','备注'
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->display();
		}
	}
	/**
	 * @Title: isReportIssearch
	 * @Description: todo(此方法为通用方法，判断报表是否输入检索条件)
	 * @param varchar $name 报表名称
	 * @return Ambigous <number, multitype:, mixed, boolean>
	 * @author liminggang
	 * @date 2013-5-31 下午4:16:34
	 * @throws
	 */
	private function  isReportIssearch($name){
		$misReportConfigurationModel=D('MisReportConfiguration');
		$sql="SELECT mis_report_configuration.issearch FROM node LEFT JOIN mis_report_configuration  ON mis_report_configuration.reportid=node.id WHERE node.name='".$name."'  AND node.status=1 AND mis_report_configuration.status=1";
		$result=$misReportConfigurationModel->query($sql);
		if($result[0]['issearch']!=0){
			$result=1;
		}else{
			$result=0;
		}
		return $result;
	}
}