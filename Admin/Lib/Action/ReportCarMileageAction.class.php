<?php
/**
 * 
 * @Title: ReportCarMileageAction 
 * @Package package_name
 * @Description: todo(行政报表-车辆行驶里程) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-25 下午4:19:57 
 * @version V1.0
 */
class ReportCarMileageAction extends CommonReportAction{
	/**
	 * (non-PHPdoc)
	 * @Description: todo(月度员工数)
	 * @see CommonAction::index()
	 */
	public function index(){
		$time=transTime(time(),'Y');
		$time=$time."年";
		$this->assign("time",$time);
		$this->display();
	}
	public function lookupCarMileage(){
		$year=$_REQUEST['year'];
		$this->assign("year",$year);
		$this->display();
	}
	/**
	 * 
	 * @Title: lookupCarMileageChart
	 * @Description: todo(车辆行驶里程构造chart)   
	 * @author renling 
	 * @date 2013-12-25 下午4:27:58 
	 * @throws
	 */
	public function lookupCarMileageChart(){
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		//取得年份
		if($_REQUEST['year']){
			//用户已选择年份
			$time=str_replace('年', '', $_REQUEST['year']);
		}else{
			//默认是当前年份
			$time=transTime(time(),'Y');
		}
		//查询全部车辆信息
		$MisSystemCarModel=D('MisSystemCar');
		$carMap['status']=1;
		$MisSystemCarList=$MisSystemCarModel->where($carMap)->getField("id,name");
		//还车记录
		$MisCarReturnModel=D('MisCarReturn');
		$listAarr=array();
		//循环车辆信息
		for($i=1;$i<=12;$i++){
			//月份期初人数（例如2013年1月份统计 取值为2012年12月份在职员工总数）
			$onetime="";
			$onetime=$time."-".$i."-01";
			//一月份期初人数（例如2013年1月份统计 取值为2012年12月份在职员工总数）
			if($time%4==0){
				//2 月截止天数为28
				if($i==2){
					$endtermtime=$time."-".$i."-29";
				}
			}
			$date=$time."-".$i;
			$firstday = date('Y-m-01', strtotime($date));
			$endtermtime=date('Y-m-d', strtotime("$firstday +1 month -1 day"));
			//$listAarr[$ckey][$i]['carID']=$ckey;
			foreach ($MisSystemCarList as $ckey=>$cval){
				$list=$MisCarReturnModel->query("SELECT   SUM(runKM) as 'runsum'  FROM mis_car_return  where status=1 and returnTime>=".strtotime($firstday)." and returnTime<=".strtotime($endtermtime)." and carID=".$ckey."  GROUP BY carID");
				if($list[0]['runsum']){
					$listAarr[$i][$ckey]['runsum']=$list[0]['runsum'];
				}else{
					$listAarr[$i][$ckey]['runsum']=0;
				}
			}
		}
		dump($listAarr);
		$xmlWriter = new XMLWriter();// 构造XML对象
		// 构造头部
		$xmlWriter->openURI('php://output');
		$xmlWriter->startDocument('1.0','UTF-8');
		$xmlWriter->setIndent(4);
		// 头部构造完毕 构造第一节点
		$xmlWriter->startElement("chart");
		$xmlWriter->writeAttribute("useRoundEdges", 1);//构造属性,"showLegend"=>'1','formatNumberScale'=>'0'
		$xmlWriter->writeAttribute("showLegend", 1);
		$xmlWriter->writeAttribute("formatNumberScale", 0);
// 						$xmlWriter->writeAttribute("numberPrefix ", '%');
		// 创建系列开始
		$xmlWriter->startElement("categories");
		//循环遍历创建
		for($i=1;$i<=12;$i++){
			$xmlWriter->startElement("category");
			$xmlWriter->writeAttribute("label",$i."月");
			$xmlWriter->endElement();
		}
		$xmlWriter->endElement();
		// 系列创建完成 开始创建数据
		foreach($MisSystemCarList as $key=>$val){
			$xmlWriter->startElement("dataset");
			$xmlWriter->writeAttribute("seriesName","[".getFieldBy($key, 'id', 'carno', 'mis_system_car')."]".$val);
			//循环遍历创建 数据列表
			foreach($listAarr as $skey=>$sval){
				$xmlWriter->startElement("set");
				$xmlWriter->writeAttribute("value",$sval[$key]['runsum']);
				$xmlWriter->endElement();
			}
			$xmlWriter->endElement();
		}
		$xmlWriter->endDocument();//结束XML
		$xmlWriter->flush();//输出XML对象
		unset($xmlWriter);//销毁XML对象
	}
}
