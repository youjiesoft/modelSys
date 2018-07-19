<?php
/**
 * @Title: ReportCarUsageAction 
 * @Package package_name
 * @Description: todo(车辆使用情况) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-9 下午4:09:31 
 * @version V1.0
 */
class ReportCarUsageAction extends CommonAction{
	/**
	 * @Title: lookupCarUsage 
	 * @Description: todo(车辆使用情况报表显示)   
	 * @author renling 
	 * @date 2013-10-10 上午11:45:55 
	 * @throws
	 */	 
	public function lookupCarUsage(){
		//用于导出数据传参
		$this->assign('reporttype','CarUsage');
		$page = $_POST['page'] ? $_POST['page']:1;
		$limit = $_POST['rows'];
		$sidx = $_POST['sidx'];
		$sord = $_POST['sord'];
		$sarr = $_REQUEST;
		if(!$sidx) $sidx =1;
		$suburl = strstr($_SERVER['REQUEST_URI'],'lookupCarUsage');
		$suburl = str_replace('lookupCarUsage','',$suburl);
		$this->assign("suburl",$suburl);
		if ($_REQUEST['listtype']) {
			$model = D("ReportCarUsage");
			echo $model->CarUsageList($page,$limit,$sidx,$sord,$sarr);
		} else {
			$colNames = array(
					'序号','车牌号','责任驾驶人','本月行驶里程','累计行驶里程','本月维修费','累计维修费','本月维修次数','累计维修次数','维修厂家','本月油料费','累计油料费','本月是否发生交通事故','备注'
			);
			$colNames = json_encode($colNames);
			$this->assign("colNames",$colNames);
			$this->display();//普通列表模板
		}
	}
}