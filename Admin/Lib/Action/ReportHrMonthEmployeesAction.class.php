<?php
/**
 *
 * @Title: ReportHrMonthEmployeesAction
 * @Package package_name
 * @Description: todo(人事报表-月度员工数)
 * @author renling
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-19 下午2:23:34
 * @version V1.0
 */
class ReportHrMonthEmployeesAction extends CommonReportAction{
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
	public function lookuphrMonthEmployees(){
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
	public function lookuphrMonthEmployeesChart(){
		$montharray=array(
				"initDate"=>"期初数据",
				"injobDate"=>"录用人数",
				"leavrDate"=>"离职人数",
				"endDate"=>"期末数据");
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
		$listAarr=array();
		for($i=1;$i<=12;$i++){
			//月份期初人数（例如2013年1月份统计 取值为2012年12月份在职员工总数）
			$onetime="";
			$onetime=$time."-".$i."-01";
			/**
			 * 期初人数
			 */
			if($i==1){
				$initMap['status']=1;
				//员工状态为在职状态
				$initMap['working']=1;
				//员工入职日期
				$initMap['_string'] = 'indate< '.strtotime($onetime)." AND indate<>0";
				$listAarr[$i-1]['initDate']=$oneinitDate=$MisHrBasicEmployeeModel->where ($initMap)->count ('*');
			}else{
				$listAarr[$i-1]['initDate']=$listAarr[$i-2]['endDate'];
			}
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
			/**
			 * 录用人数
			 */
			//一月份录用人数
			$injobMap['status']=1;
			//员工入职日期
			$injobMap['_string'] = 'indate>= '.strtotime($onetime).' AND indate<='.strtotime($endtermtime)."  and indate<>0";
			//一月份录用人员
			$listAarr[$i-1]['injobDate']=$MisHrBasicEmployeeModel->where ($injobMap)->count ('*');
			/**
			 * 离职人数
			*/
			//一月份离职人数
			$leavejobMap['status']=1;
			//员工状态为离职
			$leavejobMap['working']=0;
			//员工入职日期
			$leavejobMap['_string'] = 'indate>= '.strtotime($onetime).' AND indate<='.strtotime($endtermtime);
			//一月份离职人数
			$listAarr[$i-1]['leavrDate']=$MisHrBasicEmployeeModel->where($leavejobMap)->count ('*');
			/**
			 * 期末人数
			*/
			$endMap['status']=1;
			//员工状态为在职状态
			$endMap['working']=1;
			//员工入职日期
			$endMap['_string']='indate<='.strtotime($endtermtime)." and indate <>0";
			$listAarr[$i-1]['endDate']=$MisHrBasicEmployeeModel->where ($endMap)->count ('*');
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
// 		$xmlWriter->writeAttribute("palette", '4');
		// 创建系列开始
		$xmlWriter->startElement("categories");
		//循环遍历创建
		for($j=1;$j<=12;$j++){
			$xmlWriter->startElement("category");
			$xmlWriter->writeAttribute("label",$j."月");
			$xmlWriter->endElement();
		}
		$xmlWriter->endElement();
		// 系列创建完成 开始创建数据
		foreach($montharray as $key=>$val){
			$xmlWriter->startElement("dataset");
			$xmlWriter->writeAttribute("seriesName",$val);
			if($key=="initDate"){
			$xmlWriter->writeAttribute("color","AFD8F8");
			}
			if($key=="injobDate"){
				$xmlWriter->writeAttribute("color","F6BD0F");
			}
			if($key=="leavrDate"){
				$xmlWriter->writeAttribute("color","F984A1");
			}
			if($key=="endDate"){
				$xmlWriter->writeAttribute("color","8BBA00");
			}
			//循环遍历创建 数据列表
				for($i=0;$i<12;$i++){
					$xmlWriter->startElement("set");
					$xmlWriter->writeAttribute("value",$listAarr[$i][$key]);
					$xmlWriter->endElement();
				}
			$xmlWriter->endElement();
		}
		$xmlWriter->endDocument();//结束XML
		$xmlWriter->flush();//输出XML对象
		unset($xmlWriter);//销毁XML对象
	}
}
