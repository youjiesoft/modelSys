<?php
/**
 * 
 * @Title: ReportEmployeeLeaveAction 
 * @Package package_name
 * @Description: todo(行政报表-请假报表) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-21 下午3:24:03 
 * @version V1.0
 */
class ReportEmployeeLeaveAction extends CommonReportAction{
	public function index(){
		$time=transTime(time(),'Y');
		$time=$time."年";
		$this->assign("time",$time);
		$this->display();
	}
	public function lookupEmployeeLeave(){
		$year=$_REQUEST['year'];
		$this->assign("year",$year);
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
	public function lookupEmployeeLeaveChart(){
		//用户已选择年份统计
		if($_REQUEST['year']){
			$time=str_replace('年', '', $_REQUEST['year']);
		}else{
			//默认为当前年份
			$time=transTime(time(),'Y');
		}
		//人事模型
		$MisHrPersonnelLeaveInfoModel=D('MisHrPersonnelLeaveInfo');
		 //12月份请假人数统计
		$listAarr=array();
		for($i=1;$i<=12;$i++){
			//月份期初人数（例如2013年1月份统计 取值为2012年12月份在职员工总数）
			$onetime="";
			$onetime=$time."-".$i."-01";
			//一月份期初人数（例如2013年1月份统计 取值为2012年12月份在职员工总数）
			if($time%4==0)
			{
				//2 月截止天数为28
				if($i==2){
					$endtermtime=$time."-".$i."-29";
				}
			}
			$date=$time."-".$i;
			$firstday = date('Y-m-01', strtotime($date));
			$endtermtime=date('Y-m-d', strtotime("$firstday +1 month -1 day"));
			//请假状态
			$leaveMap['status']=1;
			//状态为批准
			$leaveMap['auditState']=3;
			//设置请假开始时间
			$leaveMap['_string'] = 'beginleavedate>= '.strtotime($onetime).' AND beginleavedate<='.strtotime($endtermtime);
			//统计该月请假人数
			$listAarr[$i-1]['name']=$i."月";
			$listAarr[$i-1]['count']=$MisHrPersonnelLeaveInfoModel->where($leaveMap)->count ('*');
			if(!$listAarr[$i-1]['count']){
				//如果查询无数据 默认显示为0
				$listAarr[$i-1]['count']=0;
			}
		}
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
		$chart->builderChart(Chart::$SINGLE_SERIES, $listAarr );
	 
	}
}
