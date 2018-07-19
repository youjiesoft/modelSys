<?php
/**
 * 
 * @Title: ReportHrNewandoldEmployeeAction 
 * @Package package_name
 * @Description: todo(新老员工构成) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-20 下午3:28:57 
 * @version V1.0
 */
class ReportHrNewandoldEmployeeAction extends CommonReportAction{
	/**
	 *
	 * @Title: lookuphrMonthEmployeesChart
	 * @Description: todo(这里用一句话描述这个方法的作用)
	 * @author renling
	 * @date 2013-12-19 下午5:56:05
	 * @throws
	 */
	public function lookupHrNewandoldEmployeeChart(){
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		//获取当前时间戳
		$time=time();
		$monthandday=transTime($time,'m-d');
		$year=transTime($time,'Y');
		//获取前一年年份
		$lastoneyear=$year-1;
		//前一年月份时间戳
		$lastoneyeartime=strtotime($lastoneyear."-".$monthandday);
		//一年以下
		$oneyearMap['status']=1;
		//在职员工
		$oneyearMap['working']=1;
		$oneyearMap['_string']="indate>".$lastoneyeartime." and indate<>0";
		$MisHrBasicEmployeeList[0]['count']=$MisHrBasicEmployeeModel->where($oneyearMap)->count('*');
		$MisHrBasicEmployeeList[0]['name']="1年以下";
		//一至两年
		//获取前两年年份
		$lasttwoyear=$year-2;
		//前两年年月份时间戳
		$lasttwoyeartime=strtotime($lasttwoyear."-".$monthandday);
		//一至两年
		$oneandtwoyearMap['status']=1;
		//在职员工
		$oneandtwoyearMap['working']=1;
		$oneandtwoyearMap['_string']="indate <= ".$lastoneyeartime." and indate<>0 and indate  >= ".$lasttwoyeartime;
		$MisHrBasicEmployeeList[1]['count']=$MisHrBasicEmployeeModel->where($oneandtwoyearMap)->count('*');
		$MisHrBasicEmployeeList[1]['name']="1至2年";
		//2至3年
		//获取前三年年份
		$lastthreeyear=$year-3;
		//前两年年月份时间戳
		$lastthreeyeartime=strtotime($lastthreeyear."-".$monthandday);
		//2至3年
		$twoandthreeyearMap['status']=1;
		//在职员工
		$twoandthreeyearMap['working']=1;
		$twoandthreeyearMap['_string']="indate <= ".$lasttwoyeartime." and indate<>0 and indate  >= ".$lastthreeyeartime;
		$MisHrBasicEmployeeList[2]['count']=$MisHrBasicEmployeeModel->where($twoandthreeyearMap)->count('*');
		$MisHrBasicEmployeeList[2]['name']="2至3年";
		//3年以上
		$threeyearMap['status']=1;
		//在职员工
		$threeyearMap['working']=1;
		$threeyearMap['_string']="indate <= ".$lastthreeyeartime." and indate<>0 ";
		$MisHrBasicEmployeeList[3]['count']=$MisHrBasicEmployeeModel->where($threeyearMap)->count('*');
		$MisHrBasicEmployeeList[3]['name']="3年以上";
		$this->assign("time",$time);
		import('@.ORG.BaseCharts.Chart');//引入Chart
		$data[] = array();
		//创建chart对象
		$chart = new Chart();
		// 默认参数
		$graphAttribute = array('useRoundEdges'=>'1',"showLegend"=>'1',"formatNumberScale"=>'0');
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
