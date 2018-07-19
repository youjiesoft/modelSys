<?php
/**
 *
 * @Title: ReportHrAgeEmployeeAction
 * @Package package_name
 * @Description: todo(人事报表 年龄段分析)
 * @author renling
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-1-9 下午4:12:34
 * @version V1.0
 */
class ReportHrAgeEmployeeAction extends CommonAction{
	/**
	 *
	 * @Title: lookupHrAgeEmployee
	 * @Description: todo(查看页面)
	 * @author renling
	 * @date 2014-1-21 下午3:59:13
	 * @throws
	 */
	public function lookupHrAgeEmployee(){
		//默认为年龄段报表
		$type=$_REQUEST['type']?$_REQUEST['type']:'age';
		switch ($type){
			case 'age':
				$disstr="截止目前年龄段统计【横坐标为年龄段，纵坐标为人数(人)】";
				break;
			case 'edu':
				$disstr="截止目前文化程度统计【横坐标为文化程度，纵坐标为人数(人)】";
				break;
			default:
				break;
		}
		$this->assign("disstr",$disstr);
		$this->assign("url",$type);
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
	public function lookupHrAgeEmployeeChart(){
		$type=$_REQUEST['type']?$_REQUEST['type']:'age';
		switch ($type){
			case 'age':
				$list=$this->ageList();
				break;
			case 'edu':
				$list=$this->eduList();
				break;
			default:
				break;
		}
		$this->assign("disstr",$disstr);
		//引入Chart
		import('@.ORG.BaseCharts.Chart');
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
		$chart->builderChart(Chart::$SINGLE_SERIES, $list);
	}
	private function eduList(){
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		$MisHrBasicEmployeeList=$MisHrBasicEmployeeModel->query("SELECT mis_hr_typeinfo.name as 'name',COUNT(education) AS 'count' FROM `mis_hr_personnel_person_info` ,mis_hr_typeinfo  WHERE mis_hr_personnel_person_info.status=1  AND education<> 0  and working=1 AND mis_hr_typeinfo.id=mis_hr_personnel_person_info.education   GROUP BY education");
		return $MisHrBasicEmployeeList;
	}
	private function ageList(){
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		//年龄配置模型
		$MisHrReportConfigurationModel=D('MisHrReportConfiguration');
		$MisHrReportConfigurationList=$MisHrReportConfigurationModel->where("status=1")->select();
		//当前时间
		$time=date('Y-m-d', strtotime(transTime(time())));
		$list=array();
		$listmap=array();
		foreach($MisHrReportConfigurationList as $key=>$val){
			$startage=date('Y-m-d', strtotime("$time -".$val['startage']." year"));
			$endage=date('Y-m-d', strtotime("$time -".$val['endage']." year"));
			$listmap['status']=1;
			$listmap['working']=1; //在职
			$listmap['_string'] = 'birthday>= '.strtotime($endage)." AND birthday<=".strtotime($startage);
			$list[$key]['name']=$val['startage'].'岁~'.$val['endage']."岁"; //组成显示名称
			$count=$MisHrBasicEmployeeModel->where($listmap)->count('*');
			if($count){
				$list[$key]['count']=$count;
			}else{
				$list[$key]['count']=0;
			}
		}
		return $list;
	}
}