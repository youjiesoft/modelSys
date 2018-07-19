<?php
/**
 * 
 * @Title: ReportHrDepartmentEmployeesAction 
 * @Package package_name
 * @Description: todo(部门人数统计) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-20 下午5:46:21 
 * @version V1.0
 */
class ReportHrDepartmentEmployeesAction extends CommonReportAction{
	/**
	 *
	 * @Title: lookuphrMonthEmployeesChart
	 * @Description: todo(这里用一句话描述这个方法的作用)
	 * @author renling
	 * @date 2013-12-19 下午5:56:05
	 * @throws
	 */
	public function lookupHrDepartmentEmployeesChart(){
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		$MisHrTalentAnalysisList=$MisHrBasicEmployeeModel->query("SELECT COUNT(deptid) as count,mis_system_department.name AS 'name' FROM mis_hr_personnel_person_info  LEFT JOIN mis_system_department ON mis_system_department.id=mis_hr_personnel_person_info.deptid WHERE mis_hr_personnel_person_info.status=1 AND working=1 GROUP BY (deptid) ");
		import('@.ORG.BaseCharts.Chart');//引入Chart
		$data[] = array();
		//创建chart对象
		$chart = new Chart();
		// 默认参数
		$graphAttribute = array('useRoundEdges'=>'1');
		//调用方法进行设置
		$chart->setGraphAttribute($graphAttribute);
		//设置x坐标
		$chart->setX('name');
		//设置Y坐标orderno
		$chart->setY('count');
		//生成图表
		$chart->builderChart(Chart::$SINGLE_SERIES, $MisHrTalentAnalysisList );
	}
}
