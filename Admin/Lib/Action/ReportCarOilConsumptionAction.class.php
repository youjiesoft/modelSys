<?php
/**
 *
 * @Title: ReportCarOilConsumptionAction
 * @Package package_name
 * @Description: todo(车辆油耗)
 * @author renling
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-25 上午10:34:11
 * @version V1.0
 */
class ReportCarOilConsumptionAction extends CommonReportAction{
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
	public function lookupCarOilConsumption(){
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
	public function lookupCarOilConsumptionChart(){
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
		$MisCarAddOilInfoModel=D('MisCarAddOilInfo');
		$listAarr=array();
		//循环车辆信息
		for($i=1;$i<=12;$i++){
			//一月份期初人数（例如2013年1月份统计 取值为2012年12月份在职员工总数）
			if($time%4==0){
				//2 月截止天数为28
				if($i==2){
					$endtermtime=$time."-".$i."-29 23:59";
				}
			}
			$date=$time."-".$i;
			$firstday = date('Y-m-01 00:00', strtotime($date));
			$endtermtime=date('Y-m-d 23:59', strtotime("$firstday +1 month -1 day"));
			foreach ($MisSystemCarList as $ckey=>$cval){
				$lastMap['status']=1;
				$lastMap['_string']="add_time>=".strtotime($firstday)." and add_time<=".strtotime($endtermtime);
				$lastMap['car_id']=$ckey;
				//取得每月份车辆加油记录
				$MisCarAddOilInfoList=$MisCarAddOilInfoModel->where($lastMap)->select();
				//加油总金额
				$sumamount=0;
				//油价
				$sumprice=0;
				//公里数
				$sumkilometre=0;
				foreach ($MisCarAddOilInfoList as $key=>$val){
					$sumamount+=$val['lastOilamount']; //加油总金额
					$sumprice+=$val['lastOilprice']; //总油价
					$sumkilometre+=$val['kilometre']; //公里数
				}
				//百公里耗油   不是百分比
				$oilavg=$sumamount/($sumprice/count($MisCarAddOilInfoList))/$sumkilometre;
				if($oilavg){
					//sprintf("%.2f", $oilavg)
					$listAarr[$i][$ckey]['oilavg']=sprintf("%.2f", $oilavg);
				}else{
					$listAarr[$i][$ckey]['oilavg']=0;
				}
			}
		}
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
				$xmlWriter->writeAttribute("value",$sval[$key]['oilavg']);
				//$xmlWriter->writeAttribute("value",$sval[$key]['oil_number']);
				//$xmlWriter->writeAttribute("value",$sval[$key]['avgoil']);
				$xmlWriter->endElement();
			}
			$xmlWriter->endElement();
		}
		$xmlWriter->endDocument();//结束XML
		$xmlWriter->flush();//输出XML对象
		unset($xmlWriter);//销毁XML对象
	}
}
