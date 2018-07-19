<?php
/**
 *
 * @Title: ReportCarDeptApplyAction
 * @Package package_name
 * @Description: todo(行政报表-部门申请用车次数)
 * @author renling
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-24 上午9:28:40
 * @version V1.0
 */
class ReportCarDeptApplyAction extends CommonReportAction{
	/**
	 * (non-PHPdoc)
	 * @Description: todo(月度员工数)
	 * @see CommonAction::index()
	 */
	public function index(){
		$time=transTime(time(),'Y-m');
		$time=str_replace('-', '年', $time);
		$time=$time."月";
		$this->assign("time",$time);
		$this->display();
	}
	public function lookupCarDeptApply(){
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
	public function lookupCarDeptApplyChart(){
		// 		echo transTime(1359419400);
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		//取得年份
		if($_REQUEST['year']){
			//用户已选择年份
			$time= $_REQUEST['year'];
		}else{
			//默认是当前年份
			$time=transTime(time(),'Y年m月');
		}
		$time = $time.'-1'; //月开始时间 例如 2013-10-1 0：00:00
		$time=str_replace('年', '-', $time);
		$time=str_replace('月', '', $time);
		$time=str_replace(' ', '', $time);
		$begindate = strtotime($time);
		$endtime = strtotime('next month', $begindate)-1;//月结束时间 例如 2013-10-31 23：59:59
		//查询全部车辆信息
		$MisSystemCarModel=D('MisSystemCar');
		$carMap['status']=1;
		$MisSystemCarList=$MisSystemCarModel->where($carMap)->getField("id,name");
		//派车申请
		$MisRequestCarModel=D('MisRequestCar');
		//组成结果数组
		$listAarr=$MisRequestCarModel->query("SELECT COUNT(*) AS count ,mis_system_department.name  AS 'dname', mis_system_car.name AS 'carname' ,mis_request_car.departmentID FROM mis_request_car LEFT JOIN  mis_system_car  ON mis_system_car.id= mis_request_car.carID LEFT JOIN mis_system_department ON mis_system_department.id=mis_request_car.departmentID WHERE mis_request_car.status = 1 AND (departureTime >= ".$begindate." AND departureTime <= ".$endtime." 	AND  carId<>0 AND carId<>' ') AND (`auditState` = 3) GROUP BY carID,departmentID");
		import('@.ORG.BaseCharts.Chart');
		//创建chart对象
		$chart = new Chart();
		// 默认参数
		$graphAttribute = array('useRoundEdges'=>'1');
		//调用方法进行设置
		$chart->setGraphAttribute($graphAttribute);
		//设置x坐标
		$chart->setX("dname");
		//设置Y坐标
		$chart->setY("count");
		$chart->setSeries("carname");
		$chart->builderChart(Chart::$MULTI_SERIES_CHARTS, $listAarr);
		// 		$xmlWriter = new XMLWriter();// 构造XML对象
		// 		// 构造头部
		// 		$xmlWriter->openURI('php://output');
		// 		$xmlWriter->startDocument('1.0','UTF-8');
		// 		$xmlWriter->setIndent(4);
		// 		// 头部构造完毕 构造第一节点
		// 		$xmlWriter->startElement("chart");
		// 		$xmlWriter->writeAttribute("useRoundEdges", 1);//构造属性,"showLegend"=>'1','formatNumberScale'=>'0'
		// 		$xmlWriter->writeAttribute("showLegend", 1);
		// 		$xmlWriter->writeAttribute("formatNumberScale", 0);
		// 		// 				$xmlWriter->writeAttribute("palette", '1');
		// 		// 创建系列开始
		// 		$xmlWriter->startElement("categories");
		// 		//循环遍历创建
		// 		foreach($listAarr as $ckey=>$cval){
		// 			$xmlWriter->startElement("category");
		// 			$xmlWriter->writeAttribute("label","[".getFieldBy($ckey, 'id', 'carno', 'mis_system_car')."]".getFieldBy($ckey, 'id', 'name', 'mis_system_car'));
		// 			$xmlWriter->endElement();
		// 		}
		// 		$xmlWriter->endElement();
		// 		// 系列创建完成 开始创建数据
		// 		foreach($listAarr as $dkey=>$dval){
		// 			foreach($dval as $skey=>$sval){
		// 				$xmlWriter->startElement("dataset");
		// 				$xmlWriter->writeAttribute("seriesName",getFieldBy($sval['departmentID'], 'id', 'name', 'mis_system_department'));
		// 				//循环遍历创建 数据列表
		// 				$xmlWriter->startElement("set");
		// 				$xmlWriter->writeAttribute("value",$sval['count']);
		// 				$xmlWriter->endElement();
		// 				$xmlWriter->endElement();
		// 			}
		// 		}
		// 		$xmlWriter->endDocument();//结束XML
		// 		$xmlWriter->flush();//输出XML对象
		// 		unset($xmlWriter);//销毁XML对象
	}
}
