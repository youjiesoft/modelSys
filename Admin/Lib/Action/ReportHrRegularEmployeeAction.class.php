<?php
/**
 * 
 * @Title: ReportHrRegularEmployeeAction 
 * @Package package_name
 * @Description: todo(转正人数) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-21 上午11:02:58 
 * @version V1.0
 */
class ReportHrRegularEmployeeAction extends CommonReportAction{
	public function index(){
		$time=transTime(time(),'Y-m');
		$time=str_replace('-', '年', $time);
		$time=$time."月";
		$this->assign("time",$time);
		$this->display();
	}
	/**
	 * 
	 * @Title: lookuphrRegularEmployee
	 * @Description: todo(这里用一句话描述这个方法的作用)   
	 * @author renling 
	 * @date 2013-12-21 上午11:27:44 
	 * @throws
	 */
	public  function  lookuphrRegularEmployee(){
		$this->assign("time",$_REQUEST['time']);
		$this->display();
	}
	/**
	 *
	 * @Title: lookuphrMonthEmployeesChart
	 * @Description: todo(这里用一句话描述这个方法的作用)
	 * @author renling
	 * @date 2013-12-19 下午5:56:05
	 * @throws
	 */
	public function lookupHrRegularEmployeeChart(){
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		//获取查询区间
		$time=$_REQUEST['time'];
		$time = $time.'-1'; //月开始时间 例如 2013-10-1 0：00:00
		$time=str_replace('年', '-', $time);
		$time=str_replace('月', '', $time);
		$time=str_replace(' ', '', $time);
		$begindate = strtotime($time);
		$endtime = strtotime('next month', $begindate)-1;//月结束时间 例如 2013-10-31 23：59:59
		$MisHrBasicEmployeeList=$MisHrBasicEmployeeModel->query("SELECT COUNT(deptid) as count,mis_system_department.name AS 'name' FROM mis_hr_personnel_person_info  LEFT JOIN mis_system_department ON mis_system_department.id=mis_hr_personnel_person_info.deptid WHERE mis_hr_personnel_person_info.status=1 AND working=1 and transferdate>=".$begindate." and transferdate<=".$endtime."  GROUP BY (deptid) ");
		if(!$MisHrBasicEmployeeList){
			$MisHrBasicEmployeeList[0]['count']=0;
			$MisHrBasicEmployeeList[0]['name']="无数据";
		}
		import('@.ORG.BaseCharts.Chart');//引入Chart
		$data[] = array();
		//创建chart对象
		$chart = new Chart();
		// 默认参数		$xmlWriter->writeAttribute("showLegend", 1);
		$graphAttribute = array('useRoundEdges'=>'1','showLegend'=>'1',"formatNumberScale"=>'0');
		//调用方法进行设置
		$chart->setGraphAttribute($graphAttribute);
		//设置x坐标
		$chart->setX('name');
		//设置Y坐标orderno
		$chart->setY('count');
		//生成图表
		$chart->builderChart(Chart::$SINGLE_SERIES, $MisHrBasicEmployeeList );
	}
}
