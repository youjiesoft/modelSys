<?php
/**
 * @Title: MisDecisionPersonAction
 * @Package package_name
 * @Description: todo(人事决策中心核心类)
 * @author 杨东
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-2-25 下午5:27:52
 * @version V1.0
 */
class MisDecisionPersonAction extends CommonAction{
	
	/**
	 * (non-PHPdoc)
	 * @see CommonAction::index()
	 */
	function index(){
		$this->createHrEmployeesTree();
		$this->display();
	}
	
	/**
	 * @var 人事报表树
	 */
	private $report = array("hrMonthEmployeesChart"=>"月度员工数",
			"hrNewandoldEmployeeChart"=>"新老员工构成",
			"hrDepartmentEmployeesChart"=>"部门人数统计",
			"hrLeaveEmployeeChart"=>"部门离职人员统计",
			//"hrSynthesizeEmployeesChart"=>"转正人数",
			"hrSynthesizeEmployeesChart"=>"人事综合统计");
	/**
	 * @Title: createHrEmployeesTree
	 * @Description: todo(构建人事树)   
	 * @author 杨东 
	 * @date 2014-2-27 下午12:01:00 
	 * @throws 
	*/  
	private function createHrEmployeesTree(){
		$zNodes = array();
		$zNodes[] = array('id' => 0,
				'name' => '人事报表',
				'title' => '人事报表',
				'open' => true);
		$id = 0;
		foreach ($this->report as $k => $v) {
			$id = $id+1;
			$zNodes[] = array('id' => $id,
					'pId' => 0,
					'name' => $v,
					'title' => $v,
					'rel' => "MisDecisionPersonindexview",
					'target' => 'ajax',
					'url' => "__URL__/".$k,
					'open' => true);
		}
		$this->assign("zNodes",json_encode($zNodes));
	}
	/**
	 *
	 * @Title: lookuphrMonthEmployeesChart
	 * @Description: todo(月度员工数)
	 * @author renling
	 * @date 2013-12-19 下午5:56:05
	 * @throws
	 */
	public function hrMonthEmployeesChart(){
		$this->createHrEmployeesTree();
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');//人事模型
		$MisHrLeaveEmployeeModel=D('MisHrLeaveEmployee');//人事离职模型
		//取得年份
		if($_REQUEST['year']){
			$time=str_replace('年', '', $_REQUEST['year']);//用户已选择年份
		}else{
			$time=transTime(time(),'Y');//默认是当前年份
		}
		$this->assign("title",$time."年月度员工数");
		$xAxis = array("categories"=>array());
		$series = array(
				0=>array("name"=>"期初数据","data"=>array()),
				1=>array("name"=>"录用人数","data"=>array()),
				2=>array("name"=>"离职人数","data"=>array()),
				3=>array("name"=>"期末数据","data"=>array())
		);
		for($i=1;$i<=12;$i++){
			//月份期初人数（例如2013年1月份统计 取值为2012年12月份在职员工总数）
			$onetime = "";
			$xAxis["categories"][] = str_pad($i,2,"0",STR_PAD_LEFT)."月";
			$onetime = $time."-".str_pad($i,2,"0",STR_PAD_LEFT)."-01";
			$starttime = strtotime($onetime);// 开始时间
			$endtime = strtotime("+1months",$starttime);// 结束时间
			/**
			 * 期初人数
			*/
			if($i==1){
				$initMap['status']=1;//员工状态为在职状态
				$initMap['working']=1;//员工入职日期
				$initMap['_string'] = 'indate< '.$starttime." AND indate<>0";
				$series[0]["data"][$i-1] = intval($MisHrBasicEmployeeModel->where ($initMap)->count ('*'));
			}else{
				$series[0]["data"][$i-1] = $series[3]["data"][$i-2];
			}
			//一月份期初人数（例如2013年1月份统计 取值为2012年12月份在职员工总数）
			/**
			 * 录用人数
			 */
			$injobMap['status']=1;//员工入职日期
			$injobMap['_string'] = 'indate>= '.$starttime.' AND indate<'.$endtime."  and indate<>0";//一月份录用人员
			$series[1]["data"][$i-1] = intval($MisHrBasicEmployeeModel->where ($injobMap)->count ('*'));
			/**
			 * 离职人数
			*/
			$leavejobMap['status']=1;//员工状态为离职
			$leavejobMap['auditState']=3; 
			$leavejobMap['_string'] = 'leavedate>= '.$starttime.' AND leavedate<'.$endtime;//一月份离职人数
			$series[2]["data"][$i-1] = intval($MisHrLeaveEmployeeModel->where($leavejobMap)->count ('*'));
			/**
			 * 期末人数
			*/
			$endMap['status']=1;//员工状态为在职状态
			$endMap['working']=1;//员工入职日期
			$endMap['_string']='indate<='.$endtime." and indate <>0";
			$series[3]["data"][$i-1] = intval($MisHrBasicEmployeeModel->where ($endMap)->count ('*'));
		}
		$this->assign("xAxis",json_encode($xAxis));
		$this->assign("series",json_encode($series));
		$this->display("hrMonthEmployeesChart");
	}
	/**
	 * @Title: hrNewandoldEmployeeChart
	 * @Description: todo(新老员工 构成比例 图表)
	 * @author 杨东
	 * @date 2014-2-26 下午3:18:58
	 * @throws
	 */
	public function hrNewandoldEmployeeChart(){
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');//人事模型
		$time=time();//获取当前时间戳
		$monthandday=transTime($time,'m-d');
		$year=transTime($time,'Y');
		$this->assign("title",$year."年新老员工组成比例");
		$lastoneyear=$year-1;//获取前一年年份
		$lastoneyeartime=strtotime($lastoneyear."-".$monthandday);//前一年月份时间戳
		//一年以下
		$oneyearMap['status']=1;
		$oneyearMap['working']=1;//在职员工
		$oneyearMap['_string']="indate>".$lastoneyeartime." and indate<>0";
		$MisHrBasicEmployeeList[0]['count']=$MisHrBasicEmployeeModel->where($oneyearMap)->count('*');
		$MisHrBasicEmployeeList[0]['name']="1年以下";
		//一至两年
		$lasttwoyear=$year-2;//获取前两年年份
		$lasttwoyeartime=strtotime($lasttwoyear."-".$monthandday);//前两年年月份时间戳
		$oneandtwoyearMap['status']=1;
		$oneandtwoyearMap['working']=1;//在职员工
		$oneandtwoyearMap['_string']="indate <= ".$lastoneyeartime." and indate<>0 and indate  >= ".$lasttwoyeartime;
		$MisHrBasicEmployeeList[1]['count']=$MisHrBasicEmployeeModel->where($oneandtwoyearMap)->count('*');
		$MisHrBasicEmployeeList[1]['name']="1至2年";
		//2至3年
		$lastthreeyear=$year-3;//获取前三年年份
		$lastthreeyeartime=strtotime($lastthreeyear."-".$monthandday);//前两年年月份时间戳
		$twoandthreeyearMap['status']=1;
		$twoandthreeyearMap['working']=1;//在职员工
		$twoandthreeyearMap['_string']="indate <= ".$lasttwoyeartime." and indate<>0 and indate  >= ".$lastthreeyeartime;
		$MisHrBasicEmployeeList[2]['count']=$MisHrBasicEmployeeModel->where($twoandthreeyearMap)->count('*');
		$MisHrBasicEmployeeList[2]['name']="2至3年";
		//3年以上
		$threeyearMap['status']=1;
		$threeyearMap['working']=1;//在职员工
		$threeyearMap['_string']="indate <= ".$lastthreeyeartime." and indate<>0 ";
		$MisHrBasicEmployeeList[3]['count']=$MisHrBasicEmployeeModel->where($threeyearMap)->count('*');
		$MisHrBasicEmployeeList[3]['name']="3年以上";
		import('@.ORG.BaseCharts.Highcharts');//引入Chart
		$data[] = array();
		//创建chart对象
		$chart = new Highcharts();
		// 默认参数
		//调用方法进行设置
		$chart->setTitle("构成比例");
		$chart->setX('name');//设置x坐标
		$chart->setY('count');//设置Y坐标orderno
		//生成图表
		$chart->builderChart(Highcharts::$SINGLE_SERIES, $MisHrBasicEmployeeList );
		$this->assign("xAxis",$chart->getCategories());
		$this->assign("series",$chart->getResults());
		$this->display("hrNewandoldEmployeeChart");
	}
	/**
	 * @Title: hrDepartmentEmployeesChart
	 * @Description: todo(部门人数统计)
	 * @author 杨东
	 * @date 2014-2-26 下午4:24:49
	 * @throws
	 */
	public function hrDepartmentEmployeesChart(){
		$this->assign("title","部门人数统计");
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');//人事模型
		$MisHrTalentAnalysisList=$MisHrBasicEmployeeModel->query("SELECT COUNT(deptid) as count,mis_system_department.name AS 'name' FROM mis_hr_personnel_person_info  LEFT JOIN mis_system_department ON mis_system_department.id=mis_hr_personnel_person_info.deptid WHERE mis_hr_personnel_person_info.status=1 AND working=1 GROUP BY (deptid) ");
		import('@.ORG.BaseCharts.Highcharts');//引入Chart
		//创建chart对象
		$chart = new Highcharts();
		// 默认参数
		$chart->setTitle('部门');
		$chart->setX('name');//设置x坐标
		$chart->setY('count');//设置Y坐标
		//生成图表
		$chart->builderChart(Highcharts::$SINGLE_SERIES, $MisHrTalentAnalysisList );
		$this->assign("xAxis",$chart->getCategories());
		$this->assign("series",$chart->getResults());
		$this->display("hrDepartmentEmployeesChart");
	}
	/**
	 * @Title: hrLeaveEmployeeChart
	 * @Description: todo(部门离职人员统计)
	 * @author 杨东
	 * @date 2014-2-26 下午4:31:47
	 * @throws
	 */
	public function hrLeaveEmployeeChart(){
		$this->assign("title","部门离职人员统计");
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		$MisSysDeptcountList = $MisHrBasicEmployeeModel->query("SELECT count(deptid) as count,deptid,mis_system_department.name AS 'name' FROM mis_hr_personnel_person_info  LEFT JOIN mis_system_department ON mis_system_department.id=mis_hr_personnel_person_info.deptid WHERE mis_hr_personnel_person_info.status=1 AND working=0 GROUP BY (deptid) ");
		import('@.ORG.BaseCharts.Highcharts');//引入Chart
		//创建chart对象
		$chart = new Highcharts();
		// 默认参数
		$chart->setTitle('部门');
		$chart->setX('name');//设置x坐标
		$chart->setY('count');//设置Y坐标
		//生成图表
		$chart->builderChart(Highcharts::$SINGLE_SERIES, $MisSysDeptcountList );
		$this->assign("xAxis",$chart->getCategories());
		$this->assign("series",$chart->getResults());
		$this->display("hrLeaveEmployeeChart");
	}
	/**
	 * @Title: hrSynthesizeEmployeesChart
	 * @Description: todo(人事綜合)
	 * @author 杨东
	 * @date 2014-2-27 上午11:18:43
	 * @throws
	 */
	public function hrSynthesizeEmployeesChart(){
		$tree = array();
		$tree[] = array('id' => 0,
				'name' => '统计类型',
				'title' => '统计类型',
				'open' => true);
		$tree[] = array('id' => 1,
				'pId' => 0,
				'name' => "年龄段",
				'title' => "年龄段",
				'rel' => "MisDecisionPersonindexview",
				'target' => 'ajax',
				'url' => "__URL__/hrSynthesizeEmployeesChart/type/age",
				'open' => true);
		$tree[] = array('id' => 2,
				'pId' => 0,
				'name' => "文化程度",
				'title' => "文化程度",
				'rel' => "MisDecisionPersonindexview",
				'target' => 'ajax',
				'url' => "__URL__/hrSynthesizeEmployeesChart/type/edu",
				'open' => true);
		$this->assign("tree",json_encode($tree));
		$type = $_REQUEST['type']?$_REQUEST['type']:'edu';
		//引入Chart
		import('@.ORG.BaseCharts.Highcharts');
		//创建chart对象
		$chart = new Highcharts();
		//设置x坐标
		$chart->setX('name');
		//设置Y坐标orderno
		$chart->setY('count');
		switch ($type){
			case 'age':
				$this->assign("defaultSelect",1);
				$this->assign("title","员工年龄段统计");
				$chart->setTitle('年龄段');
				$list=$this->ageList();
				break;
			case 'edu':
				$this->assign("defaultSelect",2);
				$this->assign("title","员工文化程度统计");
				$chart->setTitle('文化程度');
				$list=$this->eduList();
				break;
			default:
				break;
		}
		//生成图表
		$chart->builderChart(Highcharts::$SINGLE_SERIES, $list);
		$this->assign("xAxis",$chart->getCategories());
		$this->assign("series",$chart->getResults());
		$this->display("hrSynthesizeEmployeesChart");
	}
	/**
	 * @Title: eduList
	 * @Description: todo(获取教育水平数据) 
	 * @return Ambigous <mixed, multitype:, boolean>  
	 * @author 杨东 
	 * @date 2014-2-27 上午11:38:08 
	 * @throws 
	*/  
	private function eduList(){
		//人事模型
		$MisHrBasicEmployeeModel = D('MisHrBasicEmployee');
		$MisHrBasicEmployeeList = $MisHrBasicEmployeeModel->query("SELECT mis_hr_typeinfo.name as 'name',COUNT(education) AS 'count' FROM `mis_hr_personnel_person_info` ,mis_hr_typeinfo  WHERE mis_hr_personnel_person_info.status=1  AND education<> 0  and working=1 AND mis_hr_typeinfo.id=mis_hr_personnel_person_info.education   GROUP BY education");
		return $MisHrBasicEmployeeList;
	}
	/**
	 * @Title: ageList
	 * @Description: todo(获取年龄阶段数据) 
	 * @return Ambigous <multitype:, string, number, unknown>  
	 * @author 杨东 
	 * @date 2014-2-27 上午11:38:11 
	 * @throws 
	*/  
	private function ageList(){
		//人事模型
		$MisHrBasicEmployeeModel = D('MisHrBasicEmployee');
		//年龄配置模型
		$MisHrReportConfigurationModel = D('MisHrReportConfiguration');
		$MisHrReportConfigurationList = $MisHrReportConfigurationModel->where("status=1")->select();
		//当前时间
		$time = date('Y-m-d', strtotime(transTime(time())));
		$list = array();
		$listmap = array();
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

	function diff($date, $date1 = "now") {
		$time = strtotime($date);
		$y = date("Y", $time);
		$m = date("m", $time);
		$d = date("d", $time);
		$time1 = strtotime($date1);
		$_y = date("Y", $time1);
		$_m = date("m", $time1);
		$_d = date("d", $time1);
		if ($y == $_y) {
			$m1 = $m - $_m;
		} else {
			$m1 = $m + (12 - $_m);
		}
		if ($d >= $_d) {
			$d1 = $d - $_d;
		} else {
			$m1 --;
			$t1 = date("t");
			$d1 = $d + ($t1 - $_d);
		}
		return $m1 . "月零" . $d1 . "天";
	}
}