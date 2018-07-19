<?php
/**
 * @Title: file_name
 * @Package package_name
 * @Description: todo(所有报表导出execl，PDF权限控制)
 * @author liminggang
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-6-3 上午10:00:39
 * @version V1.0
 */
class ReportExcelAction extends CommonReportAction{
	function index() {
		// 		dump($_REQUEST);exit;
		$reporttype = $_REQUEST['reporttype'];
		$this->assign("reporttype",$reporttype);
		$sidx = $_REQUEST['sidx'];
		$sord = $_REQUEST['sord'];

		//-----------------------------------------
		$page = $_REQUEST['page'];
		$limit = $_REQUEST['rows'];
		$sarr = $_REQUEST;
		//导出Excel或者PDF,in fact the value is 1 or 2 ,1 representative Execl and 2 representative PDF .
		$gettype = $_REQUEST['gettype'];
		//-----------------------------------------
		switch ($reporttype) {
			case 3:
				//订单进度明细表
				$wh = "";
				$sarr = $_REQUEST;
				foreach( $sarr as $k=>$v) {
					$v = urldecode($v);
					switch ($k) {
						case 'id':
						case 'code':
						case 'name':
							$wh .= " AND od.".$k." LIKE '%".$v."%'";
							break;
						default:
							break;
					}
				}
				$this->getOrderProgressDetailed($sidx,$sord,$wh);
				//$this->display();
				break;
			case 9:
				$wh = "";
				$sarr = $_REQUEST;
				foreach( $sarr as $k=>$v) {
					$v = urldecode($v);
					switch ($k) {
						case 'id':
						case 'code':
						case 'name':
							$wh .= " AND od.".$k." LIKE '%".$v."%'";
							break;
						default:
							break;
					}
				}
				$this->getSalesOrderStatistics($sidx,$sord,$wh);
				//$this->display();
			case 10:
				//销售未采购明细表
				$this->getSalesNotpurchaseList();
				$this->display();
				break;
			case 'salesValueAnalysis':
				//客户增值分析
				$this->getSaleSvalueAnalysisExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'materialStracking':
				//物资申请跟踪表
				$this->getMaterialStrackingExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportPurchaseOrder':
				//采购订单统计表
				$this->getReportPurchaseOrderExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'purchaseOrderReceipt':
				//采购订收货统计表
				$this->getPurchaseOrderReceiptExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'procurementExecution':
				//采购执行状况表
				$this->getProcureMentExecutionExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportPurchaseOrderTracking':
				//采购订单跟踪表
				$this->getReportPurchaseOrderTrackingExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'materialApplicationNotPurchase':
				//物资申请未采购表
				$this->getMaterialApplicationNotPurchaseExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'monthOutCollect':
				//月苗出库汇总表
				$this->getMonthOutCollectExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'seedLingInventory':
				//苗木库存表
				$this->getSeedlingInventoryExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportIntoAccount':
				//入库流水账
				$this->getReportIntoAccountExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportOutAccount':
				//出库流水账
				$this->getReportOutAccountExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportStandCrop':
				//现存量查询
				$this->getReportStandcropExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'salesOrderDetail':
				//销售订单明细
				$this->getSalesOrderDetailExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportProjectPerson':
				//项目人员汇总表
				$this->getReportProjectPersonExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportProjectHrPersonnel':
				//单个人员项目信息表
				$this->getReportProjectPersonnelExcel($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrIntroducerInfoEport':
				//人事介绍人
				$this->getHrIntroducerInfoEport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrPersonContractEport':
				//合同
				$this->gethrPersonContractEport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrInviteRereport':
				//人事招聘信息
				$this->getHrinviteRereport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrProjectRecordsEport':
				//所在项目
				$this->getHrProjectRecordsEport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrPersonEducationEport':
				//培训教育经历
				$this->getHrPersonEducationEport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrPersonExperienceEport':
				//工作经验
				$this->getHrPersonExperienceEport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrPersonFamilyEport':
				//家庭成员报表
				$this->getHrPersonFamilyEport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrPersonnelBasisEport':
				//人事基本信息
				$this->getHrPersonnelBasisEport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
				//申购材料记录
			case 'reportPurchaseMaterial':
				$this->getReportPurchaseMaterial($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
				//申购苗木
			case 'reportPurchaseNursery':
				$this->getReportPurchaseNursery($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrPersonnelPositiveInfoEport':
				$this->getReportPersonnelPositiveInfo($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'hrContractExtensionEport':
				$this->getReportHrContractExtensionEport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'lookupGetCarOilReport':
				$this->getReportGetCarOilReport($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportTemporary':
				$this->getReportTemporary($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportProjectMaintain':
				$this->getReportProjectMaintain($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportFixation':
				$this->getReportFixation($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportAlarm':
				$this->getReportAlarm($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportBlasting':
				$this->getReportBlasting($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportCityalarm':
				$this->getReportCityalarm($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportProjectEngineer':
				$this->getReportProjectEngineer($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportBlastingNote':
				$this->reportBlastingNote($page,$limit,$sidx,$sord,$sarr,$gettype);
				break;
			case 'reportBlastingServiceAmount':
				$this->reportBlastingServiceAmount($page,$limit,$sidx,$sord,$sarr,$gettype);
		}
	}
	//民爆服务费
	private function reportBlastingServiceAmount($page,$limit,$sidx,$sord,$sarr,$gettype){
		$wh = "status=1  and  auditState=3 and  depttype=3 and objmodelname='MisBusinessContractCivilianBlasting'";
		$begindate ='';
		$endtime ='';
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '-', $v);
					$v=str_replace('日', '', $v);
					$begindate = strtotime($v);
					break;
				case 'overdate':
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '-', $v);
					$v=str_replace('日','', $v);
					$v=str_replace(' ', '', $v);
					$endtime = strtotime($v);
					break;
			}
		}
		if($endtime){
			$wh.= " and mis_business_invoice_manager.createtime >= ".$begindate." AND  mis_business_invoice_manager.createtime <= ".$endtime;
		}else{
			$wh.= " and mis_business_invoice_manager.createtime >= ".$begindate;
		}
		$model = D("ReportExcel");
		$header = array(
				//'orderno'=>'单据号 ',
				'customername'=>'客户名称',
				'linkman'=>'联系人'	,
				'tel'=>'公司电话',
				'caddr'=>'公司地址',
				'contractdate'=>'合同期限',
				'supervisedate'=>'监管期限',
				'accreditpenum'=>'派驻人数',
				'unitprice'=>'金额(每人)',
				'invoicetotalamount'=>'开票总金额',
		);
		$sortBy=$sidx.' '.$sord;//like this : id  desc
		$data = $this->_listData("MisBusinessInvoiceManager", $wh, $sortBy, $page, $limit, '',false,"ReportBlastingServiceAmount");
		if(count($data)>=1){
			//列表组后一行
			$ItemIndex=count($data); //3
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['accreditpenum']=$data[0]['allperson'];//人数合计
			$data[$ItemIndex]['unitprice']=$data[0]['allunitprice'];//金额合计
			$data[$ItemIndex]['invoicetotalamount']=$data[0]['sumamount'];//总额合计
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'民爆服务费PDF');
		}
	}
	//民爆收据
	private function reportBlastingNote($page,$limit,$sidx,$sord,$sarr,$gettype){
		$wh='status=1';//修改点2014.1.3 ---2
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '-', $v);
					$v=str_replace('日','', $v);
					$v=str_replace(' ', '', $v);
					$begindate = strtotime($v);
					break;
				case 'overdate':
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '-', $v);
					$v=str_replace('日','', $v);
					$v=str_replace(' ', '', $v);
					$endtime = strtotime($v);
					break;
			}
		}
		if($endtime){
			$wh.= " and mis_business_receipt_note.enterdate >= ".$begindate." AND  mis_business_receipt_note.enterdate <= ".$endtime." group by  customerid,subunit,customaddr";
		}else{
			$wh.= " and mis_business_receipt_note.enterdate >= ".$begindate." group by  customerid,subunit,customaddr";
		}
		$model = D("ReportExcel");
		$header = array(
				//'contractid'=>'民爆合同',
				'customername'=>'客户单位',
				'subunit'=>'客户二级单位',
				'linkman'=>'客户联系人',
				'linktel'=>'客户联系电话',
				'invoiceoption'=>'开票项目',
				'storagefee'=>'储存费',//新增 2014.1.21 ys
				'escortfees'=>'押运费',
				"deliveryfees"=>'配送费',
				'handlingcharges'=>'装卸费',//新增2014.1.3
				"totalamount"=>'总金额',
				'enterdate'=>'入账时间',
		);
		$sortBy=$sidx.' '.$sord;
		$data = $this->_listData("MisBusinessReceiptNote", $wh, $sortBy, $page, $limit, '',false,"ReportBlastingNote");
		if(count($data)>=1){
			//列表组后一行
			$ItemIndex=count($data); //3
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['storagefee']=number_format($data[0]['allstoragefees'],2);//存储费合计--------2014.1.21
			$data[$ItemIndex]['escortfees']=number_format($data[0]['allescortfees'],2);//押运费合计
			$data[$ItemIndex]['deliveryfees']=number_format($data[0]['alldeliveryfees'],2);//配送费合计
			$data[$ItemIndex]['handlingcharges']=number_format($data[0]['allhandlingcharges'],2);//配送费合计
			$data[$ItemIndex]['totalamount']=number_format($data[0]['sumamount'],2);//总额合计
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'民爆收据统计PDF');
		}
	}
	/**
	 * @Title: getReportProjectEngineer
	 * @Description: todo(项目工程合同报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author yuansl
	 * @date 2013-12-26 上午10:55:27
	 * @throws
	 */
	private function getReportProjectEngineer($page,$limit,$sidx,$sord,$sarr,$gettype){
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v = $v.'-1'; //月开始时间  例如 2013-10-1 0：00:00
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '', $v);
					$v=str_replace(' ', '', $v);
					$begindate = strtotime($v);
					$endtime = strtotime('next month', $begindate)-1;  //月结束时间 例如 2013-10-31 23：59:59
					//合同创建时间为本月
					//$wh .= " mis_business_contract_project_engineer.effectdate >= ".$begindate." AND  mis_business_contract_project_engineer.effectdate <= ".$endtime."  AND auditState=3 and status=1";
					$wh .= " mis_business_contract_project_engineer.effectdate <= ".$endtime." AND  mis_business_contract_project_engineer.expirydate >= ".$begindate."  and auditState=3 and status=1";
				break;
			}
		}
		$model = D("ReportExcel");
		$header = array(
				'customername'=>'单位名称',
				'customtypename'=>'类别',
				'caddr'=>'单位地址',
				'linkman'=>'联系人',
				'linktel'=>'联系人电话',
				'firstservice'=>'首次服务',
				'contractdate'=>'合同期',
				'amount'=>'金额',
				"projectname"=>'项目名称',
				"projectaddress"=>'项目地址',
				"projecttime"=>'工期',
				"projectlinkman"=>'项目联系人',
				"projectlinktel"=>'项目联系电话',
				'remark'=>'备注',
		);
		$sortBy=$sidx.' '.$sord;
		$data = $this->_listData("MisBusinessContractProjectEngineer", $wh, $sortBy, $page, $limit, '',false,"ReportProjectEngineer");
		if(count($data)>=1){
			//列表组后一行
			$ItemIndex=count($data); //3
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['amount']=number_format($data[0]['sumamount']);
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'工程项目同报表PDF');
		}
	}
	/**
	 * @Title: getReportAlarm
	 * @Description: todo(联网报警合报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author yuansl
	 * @date 2013-12-26 上午10:54:56
	 * @throws
	 */
	private function getReportAlarm($page,$limit,$sidx,$sord,$sarr,$gettype){
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v = $v.'-1'; //月开始时间  例如 2013-10-1 0：00:00
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '', $v);
					$v=str_replace(' ', '', $v);
					$begindate = strtotime($v);
					$endtime = strtotime('next month', $begindate)-1;  //月结束时间 例如 2013-10-31 23：59:59
					//合同创建时间为本月
					//$wh= " mis_business_contract_alarm.effectdate >= ".$begindate." AND  mis_business_contract_alarm.effectdate <= ".$endtime."  AND auditState=3 and status=1";
					$wh= " mis_business_contract_alarm.effectdate <= ".$endtime." AND  mis_business_contract_alarm.expirydate >= ".$begindate."  and auditState=3 and status=1";
					break;
			}
		}
		$model = D("ReportExcel");
		$header = array(
				'customername'=>'单位名称',
				'customtypename'=>'类别',
				'caddr'=>'单位地址',
				'linkman'=>'联系人',
				'linktel'=>'联系人电话',
				'firstservice'=>'首次服务',
				'contractdate'=>'合同期',
				'amount'=>'金额',
				'remark'=>'备注',
		);
		$sortBy=$sidx.' '.$sord;
		$data = $this->_listData("MisBusinessContractAlarm", $wh, $sortBy, $page, $limit, '',false,"ReportAlarm");
		if(count($data)>=1){
			//列表最后一行
			$ItemIndex=count($data); //3
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['amount']=number_format($data[0]['sumamount']);
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'联网报警合同报表PDF');
		}
	}
	/**
	 * @Title: getReportCityalarm
	 * @Description: todo(城市联网报警合同报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author yuansl
	 * @date 2013-12-20 上午11:06:52
	 * @throws
	 */
	private function getReportCityalarm($page,$limit,$sidx,$sord,$sarr,$gettype){
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v = $v.'-1'; //月开始时间  例如 2013-10-1 0：00:00
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '', $v);
					$v=str_replace(' ', '', $v);
					$begindate = strtotime($v);
					$endtime = strtotime('next month', $begindate)-1;  //月结束时间 例如 2013-10-31 23：59:59
					//发票创建时间为本月
					//$wh= " mis_business_contract_cityalarm.effectdate >= ".$begindate." AND  mis_business_contract_cityalarm.effectdate <= ".$endtime. " AND auditState=3 and status=1"; ;
					$wh= " mis_business_contract_cityalarm.effectdate <= ".$endtime." AND  mis_business_contract_cityalarm.expirydate >= ".$begindate."  and auditState=3 and status=1";
					break;
			}
		}
		$model = D("ReportExcel");
		$header = array(
				'customername'=>'单位名称',
				'customtypename'=>'类别',
				'caddr'=>'单位地址',
				'linkman'=>'联系人',
				'linktel'=>'联系人电话',
				'firstservice'=>'首次服务',
				'contractdate'=>'合同期',
				'amount'=>'金额',
				'remark'=>'备注',
		);
		$sortBy=$sidx.' '.$sord;
		$data = $this->_listData("MisBusinessContractCityalarm", $wh, $sortBy, $page, $limit, '',false,"ReportCityalarm");
		if(count($data)>=1){
			//列表组后一行
			$ItemIndex=count($data); //3
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['amount']=$data[0]['sumamount'];
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'城市报警合同报表PDF');
		}
	}

	/**
	 * @Title: getReportProjectMaintain
	 * @Description: todo(项目维护合同报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author yuansl
	 * @date 2013-12-20 下午5:21:25
	 * @throws
	 */
	private function getReportProjectMaintain($page,$limit,$sidx,$sord,$sarr,$gettype){
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v = $v.'-1'; //月开始时间  例如 2013-10-1 0：00:00
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '', $v);
					$v=str_replace(' ', '', $v);
					$begindate = strtotime($v);
					$endtime = strtotime('next month', $begindate)-1;  //月结束时间 例如 2013-10-31 23：59:59
					//发票创建时间为本月
					//$wh= " mis_business_contract_project_maintain.effectdate >= ".$begindate." AND  mis_business_contract_project_maintain.effectdate <= ".$endtime." and auditState=3 and status=1";;
					$wh= " mis_business_contract_project_maintain.effectdate <= ".$endtime." AND  mis_business_contract_project_maintain.expirydate >= ".$begindate."  and auditState=3 and status=1";
					break;
			}
		}
		$model = D("ReportExcel");
		$header = array(
				'customername'=>'单位名称',
				'customtypename'=>'类别',
				'caddr'=>'单位地址',
				'linkman'=>'联系人',
				'linktel'=>'联系人电话',
				'firstservice'=>'首次服务',
				'contractdate'=>'合同期',
				'amount'=>'金额',
				"projectname"=>'项目名称',
				"projectaddress"=>'项目地址',
				"projecttime"=>'工期',
				"projectlinkman"=>'项目联系人',
				"projectlinktel"=>'项目联系电话',
				'remark'=>'备注',
		);
		$sortBy=$sidx.' '.$sord;
		$data = $this->_listData("MisBusinessContractProjectMaintain", $wh, $sortBy, $page, $limit, '',false,"ReportProjectMaintain");
		if(count($data)>=1){
			//列表组后一行
			$ItemIndex=count($data); //3
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['amount']=$data[0]['sumamount'];
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'项目维护同报表PDF');
		}
	}
	/**
	 * @Title: getReportBlasting
	 * @Description: todo(民爆合同报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author yuansl
	 * @date 2013-12-26 上午10:54:11
	 * @throws
	 */
	private function getReportBlasting($page,$limit,$sidx,$sord,$sarr,$gettype){
		$wh = "status = 1";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v = $v.'-1'; //月开始时间  例如 2013-10-1 0：00:00
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '', $v);
					$v=str_replace(' ', '', $v);
					$begindate = strtotime($v);
					$endtime = strtotime('next month', $begindate)-1;  //月结束时间 例如 2013-10-31 23：59:59
					//合同创建时间为本月
					//$wh .= " AND  mis_business_contract_civilian_blasting.signdate >= ".$begindate." AND  mis_business_contract_civilian_blasting.signdate <= ".$endtime;
					$wh .= " AND mis_business_contract_civilian_blasting.effectdate <= ".$endtime." AND  mis_business_contract_civilian_blasting.expirydate >= ".$begindate."  and auditState=3 and status=1";
					break;
			}
		}
		$header = array(
				'customername'=>'单位名称',
				'customtypename'=>'类别',
				'customaddr'=>'单位地址',
				'linkman'=>'联系人',
				'linktel'=>'联系人电话',
				'onceservedate'=>'首次服务',
				'contractdate'=>'合同期',
				"storagefee"=>'储存费',// 储存费  新增   ---2014.1.14  storagefee
				"ctamount"=>'合同金额',//   合同金额--- ---2014.1.14  ctamount
				'sumservicecharge'=>'每月服务费',
				'blastingsite'=>'爆破施工地点',
				'escortfees'=>'押运费(￥/吨)',
				'deliveryexplosivefess'=>'炸药配送费 (￥/次)',
				'deliverydetonatorfess'=>'雷管配送费(￥/次)',
				'accreditpenum'=>'合同岗位',
				'realityaccreditpenum'=>'实际岗位',
				'remark'=>'备注',
		);
		$sortBy=$sidx.' '.$sord;
		$data =  $this->_listData("MisBusinessContractCivilianBlasting", $wh, $sortBy, $page, $limit,'',false,'ReportBlasting');
		if(count($data)>=1){
			//数组最后一行加入合计
			$ItemIndex=count($data);
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['sumservicecharge']=$data[0]['sumamount'];
			$data[$ItemIndex]['accreditpenum']=$data[0]['sumaccreditpenum'];
			$data[$ItemIndex]['realityaccreditpenum']=$data[0]['sumrealityaccreditpenum'];

			$data[$ItemIndex]['escortfees']=number_format($data[0]['sumescortfees'],2);
			$data[$ItemIndex]['deliveryexplosivefess']=number_format($data[0]['sumdeliveryexplosivefess'],2);
			$data[$ItemIndex]['deliverydetonatorfess']=number_format($data[0]['sumdeliverydetonatorfess'],2);

			$data[$ItemIndex]['storagefee']=number_format($data[0]['sumstoragefee'],2);
			$data[$ItemIndex]['ctamount']=number_format($data[0]['sumctamount'],2);
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'民爆合同报表PDF');
		}
	}


	/**
	 * @Title: getReportFixation
	 * @Description: todo(固定业务合同报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author yuansl
	 * @date 2013-12-20 上午11:07:36
	 * @throws
	 */
	private function getReportFixation($page,$limit,$sidx,$sord,$sarr,$gettype,$showname,$discolname){
		$shownamelist="";
		$wh=" auditState=3 and status=1";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v = $v.'-1'; //月开始时间  例如 2013-10-1 0：00:00
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '', $v);
					$v=str_replace(' ', '', $v);
					$begindate = strtotime($v);
					$endtime = strtotime('next month', $begindate)-1;  //月结束时间 例如 2013-10-31 23：59:59
					//发票创建时间为本月
					//$wh.= " and mis_business_contract_fixation.effectdate >= ".$begindate." AND  mis_business_contract_fixation.effectdate <= ".$endtime;
					$wh.= " and mis_business_contract_fixation.effectdate <= ".$endtime." AND  mis_business_contract_fixation.expirydate >= ".$begindate."  and auditState=3 and status=1";
					break;
				case 'discolname':
					$shownamelist=$v;
					break;

			}
		}
		$model = D("ReportExcel");
		$header = array(
				'customername'=>'单位名称',
				'customtypename'=>'类别',
				'linkcaddr'=>'单位地址',
				'linkman'=>'联络人',
				'linkmantel'=>'联络电话',
				'firstservice'=>'首次服务',
				'contractdate'=>'合同期',
				'accreditpenum'=>'合同岗位',
				'unitprice'	=>'每人每月单价',
				'sumservicecharge'=>'月服务费',
				'realityaccreditpenum'=>'实际岗位',
				'amount'=>'合同总金额',
				'remark'=>'备注',
		);
		if($shownamelist){
			$headerArr=array();
			$shownamenewlist=explode(',', $shownamelist);
			foreach($shownamenewlist as $sname){
				if($sname){
					foreach ($header as $key=>$hname){
						if($key==$sname){
							$headerArr[$key]=$hname;
						}
					}
				}
			}
		}
		$headerList=$headerArr?$headerArr:$header;
		$sortBy=$sidx.' '.$sord;
		$data = $this->_listData("MisBusinessContractFixation", $wh, $sortBy, $page, $limit, '',false,"ReportFixation");
		if(count($data)>=1){
			//数组最后一行加入合计
			$ItemIndex=count($data); //3
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['amount']=$data[0]['sumamount'];
			$data[$ItemIndex]['unitprice']=$data[0]['sumunitprice'];
			$data[$ItemIndex]['sumservicecharge']=$data[0]['sumservicechargeCount'];
			$data[$ItemIndex]['accreditpenum']=$data[0]['sumaccreditpenum'];
			$data[$ItemIndex]['realityaccreditpenum']=$data[0]['sumrealityaccreditpenum'];
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($headerList,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($headerList,$data,'固定业务合同报表PDF');
		}
	}
	/**
	 * @Title: getReportTemporary
	 * @Description: todo(临时业务合同报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author yuansl
	 * @date 2013-12-20 下午5:48:35
	 * @throws
	 */
	private function getReportTemporary($page,$limit,$sidx,$sord,$sarr,$gettype){
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v = $v.'-1'; //月开始时间  例如 2013-10-1 0：00:00
					$v=str_replace('年', '-', $v);
					$v=str_replace('月', '', $v);
					$v=str_replace(' ', '', $v);
					$begindate = strtotime($v);
					$endtime = strtotime('next month', $begindate)-1;  //月结束时间 例如 2013-10-31 23：59:59
					//发票创建时间为本月
					//$wh .= " mis_business_contract_temporary.effectdate >= ".$begindate." AND  mis_business_contract_temporary.effectdate <= ".$endtime." and auditState=3 and status=1";
					$wh .= " mis_business_contract_temporary.effectdate <= ".$endtime." AND  mis_business_contract_temporary.expirydate >= ".$begindate."  and auditState=3 and status=1";
					break;
			}
		}
		$model = D("ReportExcel");
		$header = array(
				'customername'=>'单位名称',
				'customtypename'=>'类别',
				'address'=>'单位地址',
				'temporaryname'=>'岗位性质',
				'linkman'=>'联系人',
				'linkmantel'=>'联系人电话',
				'onceservedate'=>'首次服务',
				'contractdate'=>'合同期',
				'unitprice'=>'每人每次合同单价',
				'sumservicecharge'=>'服务费总额',
				'accreditpenum'=>'合同岗位',
				'realityaccreditpenum'=>'实际岗位',
				'remark'=>'备注',
		);
		$sortBy=$sidx.' '.$sord;
		$data =  $this->_listData("MisBusinessContractTemporary", $wh, $sortBy, $page, $limit,'',false,'ReportTemporary');
		if(count($data)>=1){
			//数组最后一行加入合计
			$ItemIndex=count($data);
			$data[$ItemIndex]['customername']="合计";
			$data[$ItemIndex]['unitprice']=$data[0]['sumunitprice'];
			$data[$ItemIndex]['sumservicecharge']=$data[0]['sumamount'];
			$data[$ItemIndex]['accreditpenum']=$data[0]['sumaccreditpenum'];
			$data[$ItemIndex]['realityaccreditpenum']=$data[0]['sumrealityaccreditpenum'];
		}
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'人防临时勤务报表PDF');
		}
	}
	private function getReportGetCarOilReport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'nd'=>'序号',
				'deptname'=>'部门',
				'carno'=>'车牌',
				'carname'=>'车型',
				'name'=>'姓名',
				'oil_id'=>'油卡号',
				'countamount'=>'中石化加油站',
				'oil_balance'=>'余额',
				'countamount'=>'合计',
				'remark'=>'备注',
		);
		$data = $model->getReportGetCarOilReport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'邮费报表PDF');
		}
	}

	/**
	 * @Title: getReportHrContractExtensionEport
	 * @Description: todo(续约提醒导出execl/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author liminggang
	 * @date 2013-7-24 下午12:01:06
	 * @throws
	 */
	private function getReportHrContractExtensionEport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'nd'=>'序号',
				'orderno'=>'员工编号',
				'name'=>'姓名',
				'deptname'=>'部门',
				'dutyname'=>'职位',
				'indate'=>'入职日期'
		);
		$data = $model->getHrContractExtensionEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'续约提醒PDF');
		}
	}
	/**
	 * @Title: getReportPersonnelPositiveInfo
	 * @Description: todo(转正提醒导出execl/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author liminggang
	 * @date 2013-7-24 下午12:01:10
	 * @throws
	 */
	private function getReportPersonnelPositiveInfo($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'nd'=>'序号',
				'orderno'=>'员工编号',
				'name'=>'姓名',
				'deptname'=>'部门',
				'dutyname'=>'职位',
				'indate'=>'入职日期'
		);
		$data = $model->getHrPersonnelPositiveInfoEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'转正提醒PDF');
		}
	}

	private function getReportPurchaseNursery($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header=array(
				'projectname'=>'项目名称',
				'orderno'=>'申请单号',
				'proname'=>'物料名称',
				'prodbh'=>'申请胸径',
				'prodheight'=>'申请高度',
				'prodcanopy'=>'申请冠幅',
				'intoproexpend04'=>'验收胸径',
				'intoproexpend01'=>'验收高度',
				'intoproexpend03'=>'验收冠幅',
				'unitname'=>'单位',
				'applyqty'=>'申请数量',
				'isOrder'=>'是否建单',
				'isAssign'=>'是否分派',
				'orderqty'=>'验收数量',
				'orderunitprice'=>'单价',
				'orderamount'=>'总额',
				'DeliveryAmount'=>'分摊运费',
				'prodtypename'=>'苗木属性',
				'AssignUserName'=>'采购人',
				'intototime'=>'到货日期',
				'intoorderno'=>'验收单号',
				'intocreatetime'=>'输单日期',
				'ordersupname'=>'供应商',
				'intoForderno'=>'发票或收据单号',
				'intopaymoney'=>'付款情况',
				'applyname'=>'申请人/验收人',
				'applydmdate'=>'需用日期',
				'applyapdate'=>'申请日期',
				'AssignTime'=>'接单日期',
				'applyremark'=>'备注',
		);
		$data = $model->getReportPurchaseNurseryExcel($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'苗木申购记录PDF');
		}
	}
	/**
	 * @Title: getReportPurchaseMaterial
	 * @Description: todo(材料申购报表)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author renling
	 * @date 2013-5-9 上午11:25:38
	 * @throws
	 */
	private function getReportPurchaseMaterial($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header=array(
				'projectname'=>'项目名称',
				'orderno'=>'申请单号',
				'proname'=>'物料名称',
				'prosize'=>'申请规格',
				'prodename'=>'申请产品名称',
				'intoprosize'=>'验收规格',
				'inviteresources'=>'验收产品名称',
				'unitname'=>'单位',
				'applyqty'=>'申请数量',
				'orderqty'=>'验收数量',
				'orderunitprice'=>'单价',
				'orderamount'=>'总额',
				'isOrder'=>'是否建单',
				'isAssign'=>'是否分派',
				'AssignUserName'=>'采购人',
				'intototime'=>'到货日期',
				'intoorderno'=>'验收单号',
				'intocreatetime'=>'输单日期',
				'ordersupname'=>'供应商',
				'intoForderno'=>'发票或收据单号',
				'intopaymoney'=>'付款情况',
				'applyname'=>'申请人/验收人',
				'applydmdate'=>'需用日期',
				'applyapdate'=>'申请日期',
				'AssignTime'=>'接单日期',
				'applyremark'=>'备注',
		);
		$data = $model->getReportPurchaseMaterialExcel($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'材料申购记录PDF');
		}
	}
	/**
	 * @Title: getHrinviteRereport
	 * @Description: todo(人事招聘信息报表)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author renling
	 * @date 2013-5-9 上午11:25:38
	 * @throws
	 */
	private function getHrinviteRereport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header=array(
				'name'=>'姓名',
				'sex'=>'性别',
				'age'=>'年龄',
				'education'=>'学历',
				'professional'=>'专业',
				'nativeplace'=>'籍贯',
				'inviteresources'=>'招聘渠道',
				'datetime'=>'预约时间',
				'interviewposition'=>'应聘岗位',
				'senioritypay'=>'工作年限',
				'contacttel'=>'联系方式',
				'interviewtim'=>'面试时间',
				'accidentplace'=>'初试结果',
				'interviewagain'=>'复式结果',
				'joinedtime'=>'待入职时间'
		);
		$data = $model->getHrinviteRereportExcel($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'人事招聘信息PDF');
		}
	}
	/**
	 * @Title: getReportProjectPersonnelExcel
	 * @Description: todo(单个人员项目信息表 导出excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author renling
	 * @date 2013-5-7 下午4:43:48
	 * @throws
	 */
	private function  getReportProjectPersonnelExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header=array(
				'personname'=>'姓名',
				'perduty'=>'所在项目',
				'dutyname'=>'项目职位',
				'begindate'=>'开始时间',
				'enddate'=>'离开时间',
				'iscondition'=>'所在状态'
		);
		$wh="";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'id':
					$wh .= " AND user.id =".$v;
					break;
				case 'personname':
					$wh .= " AND user.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_sales_project_usertype.name LIKE '%".$v."%'";
					break;
				case 'perduty':
					$wh .= " AND  mis_sales_project.name  LIKE '%".$v."%'";
					break;
				case 'begindate':
					$wh .= " AND mis_sales_project_user.begindate =".transTime($v);
					break;
				case 'enddate':
					$wh .= " AND mis_sales_project_user.enddate =".transTime($v);
					break;
				case 'iscondition':
					$wh .= " AND mis_sales_project_user.istransfer LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$data = $model->getReportProjectPersonnelExcel($page,$limit,$sidx,$sord,$wh);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'单个人员项目信息PDF');
		}
	}
	/**
	 * @Title: getReportProjectPersonExcel
	 * @Description: todo(项目人员汇总  导出excel/pdf)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author renling
	 * @date 2013-5-7 下午3:28:06
	 * @throws
	 */
	private function  getReportProjectPersonExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header=array(
				'proname'=>'项目名称',
				'dutyname'=>'项目职位',
				'pername'=>'员工姓名',
				'perduty'=>'职位',
				'perdep'=>'部门',
				'persex'=>'性别',
				'peredu'=>'学历',
				'proindate'=>'进入时间',
				'proenddate'=>'离开时间',
				'proistran'=>'当前状态'

		);
		$wh="";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'proname':
					$wh .= " AND mis_sales_project.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_sales_project_usertype.name LIKE '%".$v."%'";
					break;
				case 'pername':
					$wh .= " AND user.name LIKE '%".$v."%'";
					break;
				case 'perduty':
					$wh .= " AND  duty.name   LIKE '%".$v."%'";
					break;
				case 'perdep':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'persex':
					if($v=='男'){
						$wh .=" AND user.sex =1";
					}else{
						$wh .=" AND user.sex =0";
					}
					break;
				case 'proindate':
					$wh .= " AND mis_sales_project_user.begindate =".transTime($v);
					break;
				case 'proenddate':
					$wh .= " AND mis_sales_project_user.enddate LIKE =".transTime($v);
					break;
				case 'proistran':
					$wh .= " AND mis_sales_project_user.istransfer=".$v;
					break;
				default:
					break;
			}
		}
		$data = $model->getReportProjectPersonExcel($page,$limit,$sidx,$sord,$wh);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'项目人员汇总表PDF');
		}
	}
	/**
	 * @Title: getSalesOrderDetailExcel
	 * @Description: todo(销售订单明细 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-5-4
	 * @throws
	 */
	private function getSalesOrderDetailExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'orderno'=>'订单编号',
				'cusname'=>'客户名称',
				'orderdate'=>'下单日期',
				'ddate'=>'预出日期',
				'pdtypename'=>'产品类别',
				'pdstyle'=>'产品样式',
				'pdtextrue'=>'产品材质',
				'pdsize'=>'产品规格',
				'packspeci'=>'装包规格',
				'unite'=>'单位',
				'weight'=>'重量',
				'length'=>'长度',
				'wide'=>'宽度',
				'high'=>'高度',
				'pdcolor'=>'产品颜色',
				'qty'=>'数量',
				'amount'=>'金额',
				'outstatus'=>'出货状态'
		);
		$data = $model->getSalesOrderDetailExcelExcel($page,$limit,$sidx,$sord);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'客户增值分析PDF');
		}
	}

	/**
	 * @Title: getReportStandcropExcel
	 * @Description: todo(客户增值分析 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-5-4
	 * @throws
	 */
	private function getSaleSvalueAnalysisExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'id'=>'序号',
				'code'=>'客户编码',
				'name'=>'客户名称',
				'type'=>'客户类型',
				'level'=>'客户级别',
				'area'=>'地区',
				'industry'=>'行业'
		);
		$wh="";
		$data = $model->getSaleSvalueAnalysisExcel($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'客户增值分析PDF');
		}
	}


	/**
	 * @Title: getReportStandcropExcel
	 * @Description: todo(现存量查询 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-5-4
	 * @throws
	 */
	private function getReportStandcropExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'standwarehouseno'=>'仓库编码',
				'standwarehousename'=>'仓库名称',
				'standprono'=>'存货编码',
				'standproname'=>'存货名称',
				'standprodsize'=>'规格型号',
				'standtypecode'=>'存货分类代码',
				'standtypename'=>'存货分类名称',
				'standunitid'=>'主计量单位',
				'standqty'=>'现存数量',
				'standqtycount'=>'现存件数',
				'standintoqtycount'=>'待入库数量',
				'standoutoqtycount'=>'待出库数量',
				'standallqtycount'=>'可用数量'
		);
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'standwarehouseno':
					$wh .= " AND mis_inventory_warehouse.code LIKE '%".$v."%'";
					break;
				case 'standwarehousename':
					$wh .= " AND mis_inventory_warehouse.name   LIKE '%".$v."%'";
					break;
				case 'standprono':
					$wh .= " AND mis_product_code.code LIKE '%".$v."%'";
					break;
				case 'standproname':
					$wh .= " AND mis_product_code.name LIKE '%".$v."%'";
					break;
				case 'standtypecode':
					$wh .= " AND mis_product_type.code   LIKE '%".$v."%'";
					break;
				case 'standtypename':
					$wh .= " AND mis_product_type.name  LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$data = $model->getReportStandcropExcelList($page,$limit,$sidx,$sord,$wh);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'出库流水账PDF');
		}
	}

	/**
	 * @Title: getReportOutAccountExcel
	 * @Description: todo(出库流水账 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-5-4
	 * @throws
	 */
	private function getReportOutAccountExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'outdate'=>'日期',
				'outreceiptstype'=>'单据类型',
				'outreceiptsno'=>'单据号',
				'outwarehouse'=>'仓库',
				'outreceivetype'=>'收发类别',
				'outdepname'=>'部门',
				'outclerk'=>'业务员',
				'outsuppname'=>'供货单位',
				'outcustomname'=>'客户',
				'outremark'=>'备注',
				'outcreatename'=>'制单人',
				'outupdatename'=>'审核人',
				'outupdatetime'=>'审核时间',
				'outprodno'=>'存货编码',
				'outprodname'=>'存货名称',
				'outprodsize'=>'规格型号',
				'outunitid'=>'主计量单位',
				'outoqty'=>'出库数量',
				'outounitprice'=>'出库单价',
				'outoamount'=>'出库金额'
		);
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'outreceiptsno':
					$wh .= " AND mis_inventory_out_mas.orderno LIKE '%".$v."%'";
					break;
				case 'outwarehouse':
					$wh .= " AND mis_inventory_warehouse.name   LIKE '%".$v."%'";
					break;
				case 'outdepname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'outclerk':
					$wh .= " AND USER.name LIKE '%".$v."%'";
					break;
				case 'outsuppname':
					$wh .= " AND mis_purchase_supplier.name  LIKE '%".$v."%'";
					break;
				case 'outprodno':
					$wh .= " AND mis_product_code.code  LIKE '%".$v."%'";
					break;
				case 'outprodname':
					$wh .= " AND mis_product_code.name LIKE '%".$v."%'";
					break;
				case 'outprodsize':
					$wh .= " AND mis_product_code.prodsize LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$data = $model->getReportOutAccountExcelList($page,$limit,$sidx,$sord,$wh);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'出库流水账PDF');
		}
	}
	/**
	 * @Title: getReportIntoAccountExcel
	 * @Description: todo(入库流水账 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-5-4
	 * @throws
	 */
	private function getReportIntoAccountExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'indate'=>'日期',
				'inreceiptstype'=>'单据类型',
				'inreceiptsno'=>'单据号',
				'inwarehouse'=>'仓库',
				'inreceivetype'=>'收发类别',
				'indepname'=>'部门',
				'inclerk'=>'业务员',
				'insuppname'=>'供货单位',
				'incustomname'=>'客户',
				'inremark'=>'备注',
				'increatename'=>'制单人',
				'inupdatename'=>'审核人',
				'inupdatetime'=>'审核时间',
				'inprodno'=>'存货编码',
				'inprodname'=>'存货名称',
				'inprodsize'=>'规格型号',
				'primary'=>'主单位',
				'primarycount'=>'主计量数量',
				'inunitid'=>'采购单位',
				'intoqty'=>'入库数量',
				'intounitprice'=>'入库单价',
				'intoamount'=>'入库金额'
		);
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'inreceiptsno':
					$wh .= " AND mis_inventory_into_mas.orderno LIKE '%".$v."%'";
					break;
				case 'inwarehouse':
					$wh .= " AND mis_inventory_warehouse.name   LIKE '%".$v."%'";
					break;
				case 'indepname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'inclerk':
					$wh .= " AND USER.name LIKE '%".$v."%'";
					break;
				case 'insuppname':
					$wh .= " AND mis_purchase_supplier.name  LIKE '%".$v."%'";
					break;
				case 'inprodno':
					$wh .= " AND mis_product_code.code  LIKE '%".$v."%'";
					break;
				case 'inprodname':
					$wh .= " AND mis_product_code.name LIKE '%".$v."%'";
					break;
				case 'inprodsize':
					$wh .= " AND mis_product_code.prodsize LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$data = $model->getReportIntoAccountExcelList($page,$limit,$sidx,$sord,$wh);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'入库流水账PDF');
		}
	}

	/**
	 * @Title: getMaterialStrackingExcel
	 * @Description: todo(物资申请跟踪表 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-4-25
	 * @throws
	 */
	private function getMaterialStrackingExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'id'=>'申请ID',
				'orderno'=>'编号',
				'projectname'=>'项目名称',
				'subgoods'=>'主要产品',
				'ptype'=>'单位',
				'subpsize'=>'规格',
				'subappnumber'=>'申请数量',
				'auditState'=>'状态'
		);
		$data = $model->getMaterialStrackingExcelList($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'物资申请跟踪表PDF');
		}
	}

	/**
	 * @Title: getReportPurchaseOrderExcel
	 * @Description: todo(采购订单统计表 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-4-26
	 * @throws
	 */
	private function getReportPurchaseOrderExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'reorid'=>'订单ID',
				'reororderno'=>'订单编号',
				'contractmasorderno'=>'采购合同编号',
				'suppliername'=>'供应商名称',
				'reorprojectname'=>'项目名称',
				'productcodename'=>'主要产品',
				'reorqty'=>'数量',
				'subunitprice'=>'单价',
				'subamount'=>'金额',
				'subtaxunitprice'=>'含税单价',
				'subtaxamount'=>'含税金额',
				'status'=>'状态'
		);
		$data = $model->getReportPurchaseOrderExcelList($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'采购订单统计表PDF');
		}
	}


	/**
	 * @Title: getReportPurchaseOrderTrackingExcel
	 * @Description: todo(采购订单跟踪表 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-5-7
	 * @throws
	 */
	private function getReportPurchaseOrderTrackingExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'mpcid'=>'订单编号',
				'ordernotname'=>'采购合同编号',
				'username'=>'采购员名称',
				'cusname'=>'供应商名称',
				'pjname'=>'项目名称',
				'salecontact'=>'销售合同',
				'purstatus'=>'采购订单状态',
				'purstatustime'=>'采购订单审核时间',
				'purmountall'=>'不含税总金额',
				'purtaxmountall'=>'含税总金额',
				'salecode'=>'主要产品',
				'purcount'=>'数量',
				'purprice'=>'单价',
				'purmount'=>'金额',
				'purtaxprice'=>'含税单价',
				'purtaxmount'=>'含税金额',
				'purinqty'=>'入库数量'
		);
		$data = $model->getReportPurchaseOrderTrackingExcel($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'采购订单跟踪表PDF');
		}
	}

	/**
	 * @Title: getMaterialApplicationNotPurchaseExcel
	 * @Description: todo(物资申请未采购表 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-4-27
	 * @throws
	 */
	private function getMaterialApplicationNotPurchaseExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'noid'=>'申请ID',
				'noorderno'=>'申请编号',
				'noprojectname'=>'项目名称',
				'nosuppname'=>'供应商名称',
				'nopcodecode'=>'商品编码',
				'nopcodename'=>'商品名称',
				'nosubpsize'=>'商品规格',
				'nopunitname'=>'单位',
				'nosubappnumber'=>'申请数量',
				'ispurchase'=>'已采购数量',
				'nopurchase'=>'未采购数量',
				'Inventorysum'=>'库存仓数量',
				'noauditState'=>'状态'
		);
		$data = $model->getMaterialApplicationNotPurchaseExcelList($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'物资申请未采购表PDF');
		}
	}

	/**
	 * @Title: getPurchaseOrderReceiptExcel
	 * @Description: todo(采购订收货统计表 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-4-28
	 * @throws
	 */
	private function getPurchaseOrderReceiptExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'receiptid'=>'订单ID',
				'receiptprojectcode'=>'项目编码',
				'receiptprojectname'=>'项目名称',
				'receiptsuupcode'=>'供应商编码',
				'receiptsuupname'=>'供应商名称',
				'receiptproducttypecode'=>'存货分类编码',
				'receiptproducttypename'=>'存货分类名称',
				'receiptproductcode'=>'存货编码',
				'receiptproductname'=>'存货名称',
				'receiptproductprodsize'=>'规格型号',
				'receiptsubunit'=>'单位名称',
				'receiptsubqty'=>'订单数量',
				'receiptintosubqty'=>'入库数量',
				'receiptreturnsubqty'=>'退库数量'
		);
		$data = $model->getPurchaseOrderReceiptExcelList($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'采购订收货统计表PDF');
		}
	}

	/**
	 * @Title: getProcureMentExecutionExcel
	 * @Description: todo(采购执行状况表 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-4-28
	 * @throws
	 */
	private function getProcureMentExecutionExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'productcode'=>'物资编码',
				'productname'=>'物资名称',
				'prodsize'=>'规格',
				'apqty'=>'请购数量',
				'notorderqty'=>'请购未执行数量',
				'notintoqty'=>'订货未执行数量',
				'infoqty'=>'现存量',
				'notorderunitprice'=>'请购未执行金额',
				'notordertaxunitprice'=>'请购未执行价税合计',
				'notintounitprice'=>'订货未执行金额',
				'notintotaxunitprice'=>'订货未执行价税合计'
		);
		$data = $model->getProcureMentExecutionExcelList($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'采购执行状况表PDF');
		}
	}

	/**
	 * @Title: getMonthOutCollectExcel
	 * @Description: todo(月苗出库汇总表 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-5-02
	 * @throws
	 */
	private function getMonthOutCollectExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'collmasid'=>'序号',
				'collprojectname'=>'项目名称',
				'collproductcode'=>'物资编号',
				'collproductname'=>'物资名称',
				'collproductprodsize'=>'规格',
				'collunit'=>'单位',
				'collqty'=>'数量',
				'colltaxunitprice'=>'单价(元)',
				'colltaxamount'=>'总价(元)',
				'collorderno'=>'出仓编号',
				'collhandledate'=>'出仓日期',
				'collremark'=>'备注'
		);
		$data = $model->getMonthOutCollectExcelList($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'月苗出库汇总表PDF');
		}
	}

	/**
	 * @Title: getSeedlingInventoryExcel
	 * @Description: todo(苗木库存表 导出Excel/PDF)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * * @param int $gettype 导出类型(Excel/PDF)
	 * @author jiangx
	 * @date 2013-5-03
	 * @throws
	 */
	private function getSeedlingInventoryExcel($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'invproductcode'=>'物资编码',
				'invprotypename'=>'物资名称',
				'invproductname'=>'科系',
				'invprodindex'=>'类别',
				'invqty'=>'数量',
				'invunit'=>'单位',
				'invsameqty'=>'同类数量'
		);
		$data = $model->getSeedlingInventoryExcelList($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'苗木库存表PDF');
		}
	}

	/**
	 * @Title: getOrderProgressDetailed
	 * @Description: todo()
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $wh
	 * @author liminggang
	 * @date 2013-6-3 上午9:58:52
	 * @throws
	 */
	private function getOrderProgressDetailed($sidx,$sord,$wh){
		$model = D("ReportExcel");
		$header = array('id'=>'序号',
				'orderno'=>'订单编号',
				'customer'=>'客户名称',
				'project'=>'项目名称',
				'qty'=>'数量',
				'currency'=>'币别',
				'ioamount'=>'订单金额',
				'oamount'=>'含税金额',
				'createtime'=>'下单日期',
				'ddate'=>'预交日期',
				'outtime'=>'出货日期',
				'status'=>'状态',
				'ptype'=>'产品类别',
				'remark'=>'备注');
		$data = $model->getOrderProgressDetailed($sidx,$sord,$wh);
		$this->export_excel2($header,array(),$data);
	}
	/**
	 * @Title: getSalesOrderStatistics
	 * @Description: todo()
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $wh
	 * @author liminggang
	 * @date 2013-6-3 上午9:58:03
	 * @throws
	 */

	private function getSalesOrderStatistics($sidx,$sord,$wh) {
		$model = D("ReportExcel");
		$header = array('id'=>'序号',
				'orderno'=>'订单编号',
				'customer'=>'客户名称',
				'project'=>'项目名称',
				'ptype'=>'主要产品',
				'qty'=>'数量',
				'ioamount'=>'订单金额',
				'oamount'=>'含税金额',
				'status'=>'出货状态');
		$data = $model->getSalesOrderStatistics($sidx,$sord,$wh);
		$this->export_excel2($header,array(),$data);
	}

	/**
	 * @Title: getHrIntroducerInfoEport
	 * @Description: todo(这里用一句话描述这个方法的作用)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author liminggang
	 * @date 2013-5-8 上午8:55:45
	 * @throws
	 */
	private function getHrIntroducerInfoEport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'nd'=>'序号',
				'name'=>'姓名',
				'deptname'=>'部门',
				'dutyname'=>'职位',
				'indate'=>'入职日期',
				'mis_hr_personnel_introducer_info_name'=>'介绍人姓名',
				'jsdeptname'=>'介绍人部门',
				'jsdutyname'=>'介绍人职务'
		);
		$data = $model->getHrIntroducerInfoEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'内部介绍PDF');
		}
	}

	/**
	 * @Title: getHrPersonContractEport
	 * @Description: todo(合同情况)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author liminggang
	 * @date 2013-5-8 上午8:55:45
	 * @throws
	 */
	private function getHrPersonContractEport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'nd'=>'序号',
				'name'=>'姓名',
				'deptname'=>'部门',
				'dutyname'=>'职位',
				'counts'=>'签订次数',
				'mis_hr_personnel_person_contract_enddate'=>'上次终止日期',
				'mis_hr_personnel_person_contract_remark'=>'备注'
		);
		$data = $model->getHrPersonContractEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'人事合同PDF');
		}
	}

	/**
	 * @Title: getHrProjectRecordsEport
	 * @Description: todo(所在项目)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author renling
	 * @date 2013-5-9 下午5:37:50
	 * @throws
	 */
	private function getHrProjectRecordsEport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'name'=>'姓名',
				'deptname'=>'部门',
				'dutyname'=>'岗位',
				'indate'=>'入职日期',
				'mis_hr_personnel_project_records_projectname'=>'所在项目',
				'mis_hr_personnel_project_records_pjposition'=>'项目职位',
				'mis_hr_personnel_project_records_begindate'=>'开始时间',
				'mis_hr_personnel_project_records_enddate'=>'结束时间',
				'mis_hr_personnel_project_records_iscondition'=>'是否可调动',
				'mis_hr_personnel_project_records_remark'=>'备注',
		);
		$data = $model->getHrProjectRecordsEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'所在项目PDF');
		}
	}

	/**
	 * @Title: getHrPersonEducationEport
	 * @Description: todo(培训教育经历 导出excel/PDF)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author renling
	 * @date 2013-5-10 下午2:07:34
	 * @throws
	 */
	private function getHrPersonEducationEport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'name'=>'姓名',
				'deptid'=>'部门',
				'dutyname'=>'岗位',
				'indate'=>'入职日期',
				'mis_hr_personnel_education_info_school'=>'培训机构',
				'mis_hr_personnel_education_info_skillAndCertificate'=>'专业与技能',
				'mis_hr_personnel_education_info_startDate'=>'开始时间',
				'mis_hr_personnel_education_info_finishDate'=>'结束时间',
				'mis_hr_personnel_experience_info_remark'=>'备注',
		);
		$data = $model->getHrPersonEducationEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'培训教育经历PDF');
		}
	}
	/**
	 * @Title: PersonExperienceEport
	 * @Description: todo(工作经验报表 导出PDF/EXCEL)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author renling
	 * @date 2013-5-10 下午3:03:27
	 * @throws
	 */
	private function getHrPersonExperienceEport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'name'=>'姓名',
				'deptname'=>'部门',
				'dutyname'=>'职务',
				'indate'=>'入职日期',
				'mis_hr_personnel_experience_info_company'=>'工作单位',
				'mis_hr_personnel_experience_info_position'=>'职业',
				'mis_hr_personnel_experience_info_startdate'=>'开始时间',
				'mis_hr_personnel_experience_info_finishdate'=>'结束时间',
				'mis_hr_personnel_experience_info_remark'=>'备注',
		);
		$data = $model->getHrPersonExperienceEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'工作经验报表PDF');
		}
	}
	/**
	 * @Title: getHrPersonFamilyEport
	 * @Description: todo(家庭成员报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author renling
	 * @date 2013-5-10 下午3:53:31
	 * @throws
	 */
	private function getHrPersonFamilyEport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'name'=>'姓名',
				'deptname'=>'部门',
				'dutyname'=>'职务',
				'indate'=>'入职日期',
				'mis_hr_personnel_family_info_name'=>'家属姓名',
				'mis_hr_personnel_family_info_relation'=>'家属关系',
				'mis_hr_personnel_family_info_company'=>'工作单位',
				'mis_hr_personnel_family_info_telephone'=>'联系电话',
		);
		$data = $model->getHrPersonFamilyEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'工作经验报表PDF');
		}
	}
	/**
	 * @Title: getHrPersonnelBasisEport
	 * @Description: todo(人事基本信息)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @param unknown_type $gettype
	 * @author renling
	 * @date 2013-5-14 下午1:45:03
	 * @throws
	 */
	private function getHrPersonnelBasisEport($page,$limit,$sidx,$sord,$sarr,$gettype){
		$model = D("ReportExcel");
		$header = array(
				'orderno'=>'员工编号',
				'sex'=>'性别',
				'workkind'=>'工种',
				'itemid'=>'内部编号',
				'name'=>'姓名',
				'deptid'=>'部门',
				'dutyname'=>'职务',
				'dutylevelid'=>'职级',
				'indate'=>'入职日期',
				'transferprobationdate'=>'转试用日期',
				'transferdate'=>'转正日期',
				'positivestatus'=>'是否转正',
				'leavedate'=>'离职日期',
				'staffcheck'=>'员工考核',
				'working'=>'职位状态',
				'school'=>'毕业学院',
				'chinaid'=>'身份证',
				'phone'=>'联系电话',
				'mis_hr_personnel_education_info_school'=>'培训机构',
				'mis_hr_personnel_education_info_skillAndCertificate'=>'专业与技能',
				'mis_hr_personnel_education_info_startDate'=>'开始时间',
				'mis_hr_personnel_education_info_finishDate'=>'结束时间',
				'mis_hr_personnel_experience_info_company'=>'工作单位',
				'mis_hr_personnel_experience_info_position'=>'职业',
				'mis_hr_personnel_experience_info_telephone'=>'联系电话',
				'mis_hr_personnel_experience_info_startdate'=>'开始时间',
				'mis_hr_personnel_experience_info_finishdate'=>'结束时间',
				'mis_hr_personnel_family_info_relation'=>'家属关系',
				'mis_hr_personnel_family_info_name'=>'家属姓名',
				'mis_hr_personnel_family_info_company'=>'家属工作单位',
				'mis_hr_personnel_education_info_startDate'=>'开始时间',
				'mis_hr_personnel_education_info_finishDate'=>'结束时间',
				'mis_hr_personnel_experience_info_company'=>'工作单位',
				'mis_hr_personnel_family_info_telephone'=>'联系电话',
				'mis_hr_personnel_introducer_info_name'=>'介绍人',
				'mis_hr_personnel_introducer_info_relation'=>'关系',
				'mis_hr_personnel_introducer_info_telephone'=>'联系电话',
				'mis_hr_personnel_project_records_projectname'=>'所在项目',
				'mis_hr_personnel_project_records_pjposition'=>'项目职位',
				'mis_hr_personnel_project_records_begindate'=>'开始时间',
				'mis_hr_personnel_project_records_enddate'=>'结束时间',
				'mis_hr_personnel_project_records_iscondition'=>'是否可调动',
				'mis_hr_personnel_project_records_remark'=>'备注',
				'mis_hr_personnel_person_contract_agencyperson'=>'代办人',
				'mis_hr_personnel_person_contract_signdate'=>'签订时间',
				'mis_hr_personnel_person_contract_enddate'=>'结束时间',
				'mis_hr_personnel_person_contract_remark'=>'备注',
		);
		$data = $model->getHrPersonnelBasisEport($page,$limit,$sidx,$sord,$sarr);
		if ($gettype == 1) {
			//导出Excel
			$this->export_excel2($header,array(),$data);
		} elseif ($gettype == 2) {
			//导出PDF
			$this->getByTCPDF($header,$data,'人事基本信息报表PDF');
		}
	}
}
?>