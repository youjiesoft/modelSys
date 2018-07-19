<?php
class ReportExcelModel extends CommonModel{
	/**
	 * @Title: getReportAlarm 
	 * @Description: todo(技防联网报警合同报表哦) 
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $wh
	 * @return Ambigous <string, mixed>  
	 * @author yuansl 
	 * @date 2013-12-20 上午11:15:46 
	 * @throws
	 */
	function getReportAlarm($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		count(*) as 'count'
		FROM mis_finance_business_invoice
		LEFT JOIN mis_business_invoice_manager
		ON mis_finance_business_invoice.appid = mis_business_invoice_manager.id
		LEFT JOIN mis_business_contract_alarm
		ON mis_business_contract_alarm.id = mis_business_invoice_manager.objid
		WHERE mis_finance_business_invoice.depttype = 1
		AND mis_finance_business_invoice.objmodelname = 'MisBusinessContractAlarm'
		AND mis_finance_business_invoice.financestatus = 1 $wh ";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT
		objid                                                AS 'contractID',
		mis_finance_business_invoice.amount                  AS 'amount',
		mis_finance_business_invoice.id                      AS 'fbid',
		mis_business_contract_alarm.effectdate           AS 'starttime',
		mis_business_contract_alarm.expirydate           AS 'expirydate',
		mis_business_contract_alarm.linkman              AS 'linkman',
		mis_business_contract_alarm.linktel              AS 'linkmantel',
		mis_business_contract_alarm.customerid           AS 'customerid',
		mis_business_contract_alarm.customername         AS 'customername',
		mis_business_contract_alarm.caddr                AS 'address',
		mis_business_contract_alarm.remark               AS 'remark',
		mis_finance_business_invoice.id                      AS 'ktid'
		FROM mis_finance_business_invoice
		LEFT JOIN mis_business_invoice_manager
		ON mis_finance_business_invoice.appid = mis_business_invoice_manager.id
		LEFT JOIN mis_business_contract_alarm
		ON mis_business_contract_alarm.id = mis_business_invoice_manager.objid
		WHERE mis_finance_business_invoice.depttype = 1
		AND mis_finance_business_invoice.objmodelname = 'MisBusinessContractAlarm'
		AND mis_finance_business_invoice.financestatus = 1 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		//客户model
		$MisSalesCustomerModel=D('MisSalesCustomer');
		//联网报警
		$MisBusinessContractAlarModel=D('MisBusinessContractAlarm');
		//客户行业model
		$MisSalesCustomerIndustryModel=D('MisSalesCustomerIndustry');
		foreach($list1 as $key => $val) {
			$list1[$key]['customtypeid']=getFieldBy($list1[$key]['customerid'], 'id', 'intype', 'mis_sales_customer');
			$list1[$key]['customtypename']=getFieldBy($list1[$key]['customtypeid'], 'id', 'name', 'mis_sales_customer_industry');
			//首次服务时间
			$MisBusinessContractCityalarList=$MisBusinessContractCityalarModel->where("status=1 and customerid=".$list1[$key]['customerid']." and auditState=3")->find();
			$list1[$key]['onceservedate']=transTime($MisBusinessContractCityalarList['effectdate']);
			$list1[$key]['contractdate']="    ".transTime($list1[$key]['starttime'])." ~   ".transTime($list1[$key]['expirydate']); //合同期
		}
		if(count($list1)>1){
			//数组最后一行加入合计
			$ItemIndex=count($list1);
			$list1[$ItemIndex]['customername']="合计";
			$list1[$ItemIndex]['amount']=number_format($sumamount);
		}
		return $list1;
	}
	/**
	 * @Title: getReportCityalarm 
	 * @Description: todo(城市联网报警合同报表) 
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $wh
	 * @return Ambigous <string, mixed>  
	 * @author yuansl 
	 * @date 2013-12-20 上午11:13:26 
	 * @throws
	 */
	function getReportCityalarm($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		count(*) as 'count'
		FROM mis_finance_business_invoice
		LEFT JOIN mis_business_invoice_manager
		ON mis_finance_business_invoice.appid = mis_business_invoice_manager.id
		LEFT JOIN mis_business_contract_cityalarm
		ON mis_business_contract_cityalarm.id = mis_business_invoice_manager.objid
		WHERE mis_finance_business_invoice.depttype = 2
		AND mis_finance_business_invoice.objmodelname = 'MisBusinessContractCityalarm'
		AND mis_finance_business_invoice.financestatus = 1 $wh ";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT
		objid                                                AS 'contractID',
		mis_finance_business_invoice.amount                  AS 'amount',
		mis_finance_business_invoice.id                      AS 'fbid',
		mis_business_contract_cityalarm.effectdate           AS 'starttime',
		mis_business_contract_cityalarm.expirydate           AS 'expirydate',
		mis_business_contract_cityalarm.linkman              AS 'linkman',
		mis_business_contract_cityalarm.linktel              AS 'linkmantel',
		mis_business_contract_cityalarm.customerid           AS 'customerid',
		mis_business_contract_cityalarm.customername         AS 'customername',
		mis_business_contract_cityalarm.caddr                AS 'address',
		mis_business_contract_cityalarm.remark               AS 'remark',
		mis_finance_business_invoice.id                      AS 'ktid'
		FROM mis_finance_business_invoice
		LEFT JOIN mis_business_invoice_manager
		ON mis_finance_business_invoice.appid = mis_business_invoice_manager.id
		LEFT JOIN mis_business_contract_cityalarm
		ON mis_business_contract_cityalarm.id = mis_business_invoice_manager.objid
		WHERE mis_finance_business_invoice.depttype = 2
		AND mis_finance_business_invoice.objmodelname = 'MisBusinessContractCityalarm'
		AND mis_finance_business_invoice.financestatus = 1 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		//客户model
		$MisSalesCustomerModel=D('MisSalesCustomer');
		//临时勤务
		$MisBusinessContractCityalarModel=D('MisBusinessContractCityalarm');
		//客户行业model
		$MisSalesCustomerIndustryModel=D('MisSalesCustomerIndustry');
		$sumamount=0;
		foreach ($list1 as $key => $val) {
			$sumamount=$sumamount+$list1[$key]['amount'];
			$list1[$key]['customtypeid']=getFieldBy($list1[$key]['customerid'], 'id', 'intype', 'mis_sales_customer');
			$list1[$key]['customtypename']=getFieldBy($list1[$key]['customtypeid'], 'id', 'name', 'mis_sales_customer_industry');
			$list1[$key]['amount']=number_format($list1[$key]['amount']);
			//首次服务时间
			$MisBusinessContractCityalarList=$MisBusinessContractCityalarModel->where("status=1 and customerid=".$list1[$key]['customerid']." and auditState=3")->find();
			$list1[$key]['onceservedate']=transTime($MisBusinessContractCityalarList['effectdate']);
			$list1[$key]['contractdate']="    ".transTime($list1[$key]['starttime'])." ~   ".transTime($list1[$key]['expirydate']); //合同期
		}
		if(count($list1)>1){
			//数组最后一行加入合计
			$ItemIndex=count($list1);
			$list1[$ItemIndex]['customername']="合计";
			$list1[$ItemIndex]['amount']=number_format($sumamount);
		}
		return $list1;
	}

	/**
	 * @Title: getReportFixationReport 
	 * @Description: todo(人防固定业务合同报表) 
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $wh
	 * @return unknown  
	 * @author yuansl 
	 * @date 2013-12-20 上午11:14:22 
	 * @throws
	 */
	function getReportFixationReport($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		COUNT(DISTINCT mis_finance_business_invoice.id)
		FROM mis_finance_business_invoice
		LEFT JOIN mis_business_invoice_manager
		ON mis_finance_business_invoice.appid = mis_business_invoice_manager.id
		LEFT JOIN mis_business_contract_fixation
		ON mis_business_contract_fixation.id = mis_business_invoice_manager.objid
		WHERE mis_finance_business_invoice.depttype = 1
		AND mis_finance_business_invoice.objmodelname = 'MisBusinessContractFixation'
		AND mis_finance_business_invoice.financestatus = 1 $wh";
		  $row = $this->query($sqlcount);
		  $count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT
		mis_finance_business_invoice.id                      AS 'fbid',
		mis_business_contract_fixation.caddr           	     AS 'caddr',
		mis_business_contract_fixation.customerid            AS 'customerid',
		mis_business_contract_fixation.customername          AS 'customername',
		mis_business_contract_fixation.linkman               AS 'linkman',
		mis_business_contract_fixation.linkmantel            AS 'linkmantel',
		mis_business_contract_fixation.expirydate            AS 'expirydate',
		mis_business_contract_fixation.effectdate			 AS 'effectdate',
		mis_finance_business_invoice.amount                  AS 'amount',
		mis_business_contract_fixation.accreditpenum         AS 'accreditpenum',
		mis_business_contract_fixation.realityaccreditpenum  AS 'realityaccreditpenum',
		mis_business_contract_fixation.remark                AS 'remark'
		FROM mis_finance_business_invoice
		LEFT JOIN mis_business_invoice_manager
		ON mis_finance_business_invoice.appid = mis_business_invoice_manager.id
		LEFT JOIN mis_business_contract_fixation
		ON mis_business_contract_fixation.id = mis_business_invoice_manager.objid
		WHERE mis_finance_business_invoice.depttype = 1
		AND mis_finance_business_invoice.objmodelname = 'MisBusinessContractFixation'
		AND mis_finance_business_invoice.financestatus = 1 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		//处理数据,组装数据
		//客户model
		$MisSalesCustomerModel=D('MisSalesCustomer');
		//固定业务模型
		$MisBusinessContractFixationModel=D('MisBusinessContractFixation');
		//创建客户行业模型
		$MisSalesCustomerIndustryModel=D('MisSalesCustomerIndustry');
		//设置合计,初始为零
		$sumamount=0;
		$sumaccreditpenum=0;
		$sumrealityaccreditpenum=0;
		foreach ($list1 as $key => $val) {
			//根据客户的id,在客户表,取到客户类别typeid,再根据typeid,在客户类别表中读取到客户类别名称.
			$list1[$key]['customtypeid']=getFieldBy($list1[$key]['customerid'], 'id', 'intype', 'mis_sales_customer');
			//客户类别名称
			$list1[$key]['customtypename']=getFieldBy($list1[$key]['customtypeid'], 'id', 'name', 'mis_sales_customer_industry');
			$list1[$key]['linkmanandtel']=$list1[$key]['linkman']." "+$list1[$key]['linkmantel']; //联系人电话
			//首次服务时间
			$firstservice=$MisBusinessContractFixationModel->where("'customtypeid='.$list1[$key]['customtypeid']")->order('effectdate asc')->field('effectdate');
			//首次服务时间
			$MisBusinessContractFixationList=$MisBusinessContractFixationModel->where("status=1 and customerid=".$list1[$key]['customerid']." and auditState=3")->order('id asc')->find();
			$list1[$key]['firstservice']=transTime($MisBusinessContractFixationList['effectdate']);
			//合同期
			$list1[$key]['contractdate']="    ".transTime($list1[$key]['effectdate'])." ~   ".transTime($list1[$key]['expirydate']); //合同期
		}
		$ItemIndex=count($list1);
		$list1[$ItemIndex]['customername']="合计";
		$list1[$ItemIndex]['amount']=number_format($sumamount);
		$list1[$ItemIndex]['accreditpenum']=number_format($sumaccreditpenum);
		$list1[$ItemIndex]['realityaccreditpenum']=number_format($sumrealityaccreditpenum);
		return $list1;
	}
	function getReportTemporaryReport($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		COUNT(DISTINCT   mis_finance_business_invoice.id )
		FROM mis_finance_business_invoice
		LEFT JOIN mis_business_invoice_manager
		ON mis_finance_business_invoice.appid = mis_business_invoice_manager.id
		LEFT JOIN mis_business_contract_temporary
		ON mis_business_contract_temporary.id = mis_business_invoice_manager.objid
		WHERE mis_finance_business_invoice.depttype = 1
		AND mis_finance_business_invoice.objmodelname = 'MisBusinessContractTemporary'
		AND mis_finance_business_invoice.financestatus = 1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT
		objid                                                AS 'contractID',
		mis_finance_business_invoice.amount                  AS 'amount',
		mis_finance_business_invoice.id                      AS 'fbid',
		mis_business_contract_temporary.effectdate           AS 'starttime',
		mis_business_contract_temporary.expirydate           AS 'expirydate',
		mis_business_contract_temporary.linkman              AS 'linkman',
		mis_business_contract_temporary.linkmantel           AS 'linkmantel',
		mis_business_contract_temporary.sumservicecharge	   AS 'sumservicecharge',
		mis_business_contract_temporary.temporarytype        AS 'temporarytype',
		mis_business_contract_temporary.customerid           AS 'customerid',
		mis_business_contract_temporary.customername         AS 'customername',
		mis_business_contract_temporary.address              AS 'address',
		mis_business_contract_temporary.accreditpenum        AS 'accreditpenum',
		mis_business_contract_temporary.realityaccreditpenum AS 'realityaccreditpenum',
		mis_business_contract_temporary.remark               AS 'remark',
		mis_finance_business_invoice.id AS 'ktid'
		FROM mis_finance_business_invoice
		LEFT JOIN mis_business_invoice_manager
		ON mis_finance_business_invoice.appid = mis_business_invoice_manager.id
		LEFT JOIN mis_business_contract_temporary
		ON mis_business_contract_temporary.id = mis_business_invoice_manager.objid
		WHERE mis_finance_business_invoice.depttype = 1
		AND mis_finance_business_invoice.objmodelname = 'MisBusinessContractTemporary'
		AND mis_finance_business_invoice.financestatus = 1 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		//客户model
		$MisSalesCustomerModel=D('MisSalesCustomer');
		//临时勤务
		$MisBusinessContractTemporaryModel=D('MisBusinessContractTemporary');
		//客户行业model
		$MisSalesCustomerIndustryModel=D('MisSalesCustomerIndustry');
		$sumamount=0;
		$sumaccreditpenum=0;
		$sumrealityaccreditpenum=0;
		foreach ($list1 as $key => $val) {
			$sumamount=$sumamount+$list1[$key]['amount'];//服务费总额
			$sumaccreditpenum=$sumaccreditpenum+$list1[$key]['accreditpenum']; //合同人数
			$sumrealityaccreditpenum=$sumrealityaccreditpenum+$list1[$key]['realityaccreditpenum']; 	//实际人数
			$list1[$key]['amount']=number_format($list1[$key]['amount']);
			$list1[$key]['accreditpenum']=getDigits($list1[$key]['accreditpenum']);
			$list1[$key]['realityaccreditpenum']=getDigits($list1[$key]['realityaccreditpenum']);
			$list1[$key]['temporaryname']=getSelectByName('servicetype', $list1[$key]['temporarytype']);
			$list1[$key]['customtypeid']=getFieldBy($list1[$key]['customerid'], 'id', 'intype', 'mis_sales_customer');
			$list1[$key]['customtypename']=getFieldBy($list1[$key]['customtypeid'], 'id', 'name', 'mis_sales_customer_industry');
			//首次服务时间
			$MisBusinessContractTemporaryList=$MisBusinessContractTemporaryModel->where("status=1 and customerid=".$list1[$key]['customerid']." and auditState=3")->find();
			$list1[$key]['onceservedate']=transTime($MisBusinessContractTemporaryList['effectdate']);
			$list1[$key]['contractdate']="    ".transTime($list1[$key]['starttime'])." ~   ".transTime($list1[$key]['expirydate']); //合同期
		}
		if(count($list1)>1){
			//数组最后一行加入合计
			$ItemIndex=count($list1);
			$list1[$ItemIndex]['customername']="合计";
			$list1[$ItemIndex]['amount']=number_format($sumamount);
			$list1[$ItemIndex]['accreditpenum']=number_format($sumaccreditpenum);
			$list1[$ItemIndex]['realityaccreditpenum']=number_format($sumrealityaccreditpenum);
		}
		return $list1;
	}
	function getReportPurchaseNurseryExcel($page,$limit,$sidx,$sord,$sarr){
	$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'materialapplyordernoNur':
					$wh.=" and mis_purchase_applymas.orderno LIKE '%".$v."%'";
					break;
				case 'materialapplyprojectnameNur':
					$wh.=" and mis_sales_project.name  LIKE '%".$v."%'";
					break;
				case 'materialapplycodenameNur':
					$wh .= " AND mis_product_code.name LIKE '%".$v."%'";
					break;
				case 'materialapplycodesizeNur':
					$wh .= " AND mis_product_code.prodsize  LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT
		mis_sales_project.name        AS 'projectname',
		mis_purchase_applymas.orderno AS 'orderno',
		mis_product_code.name         AS 'proname',
		mis_product_code.prodsize     AS 'prosize',
		mis_product_code.expend04     AS 'prodbh',
		mis_product_type.name     	  AS 'prodtypename',
		mis_product_code.expend01     AS 'prodheight',
		mis_product_code.expend03     AS 'prodcanopy',
		mis_purchase_applysub.id      AS 'id',
		mis_product_code.name         AS 'prodename',
		mis_product_code.baseunitid   AS 'unitname',
		mis_purchase_applysub.qty     AS 'applyqty',
		mis_purchase_applymas.dmdate  AS 'applydmdate',
		mis_purchase_applymas.apdate  AS 'applyapdate',
		mis_purchase_applymas.remark  AS 'applyremark',
		user.name                     AS 'applyname'
		FROM mis_purchase_applysub
		LEFT JOIN mis_purchase_applymas
		ON mis_purchase_applysub.masid = mis_purchase_applymas.id
		LEFT JOIN mis_product_code
		ON mis_purchase_applysub.prodid = mis_product_code.id
		LEFT JOIN mis_product_type
		ON mis_product_code.typeid = mis_product_type.id
		LEFT JOIN mis_sales_project
		ON mis_purchase_applysub.projectid = mis_sales_project.id
		LEFT JOIN mis_purchase_assignsub
		ON mis_purchase_applysub.id = mis_purchase_assignsub.asubid
		LEFT JOIN USER
		ON mis_purchase_applymas.userid = user.id
		WHERE mis_product_type.typeid = 2
		$wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT
		mis_sales_project.name        AS 'projectname',
		mis_purchase_applymas.orderno AS 'orderno',
		mis_product_code.name         AS 'proname',
		mis_product_code.prodsize     AS 'prosize',
		mis_product_code.expend04     AS 'prodbh',
		mis_product_type.name     	  AS 'prodtypename',
		mis_product_code.expend01     AS 'prodheight',
		mis_product_code.expend03     AS 'prodcanopy',
		mis_purchase_applysub.id      AS 'id',
		mis_product_code.name         AS 'prodename',
		mis_product_code.baseunitid   AS 'unitname',
		mis_purchase_applysub.qty     AS 'applyqty',
		mis_purchase_applymas.dmdate  AS 'applydmdate',
		mis_purchase_applymas.apdate  AS 'applyapdate',
		mis_purchase_applymas.remark  AS 'applyremark',
		user.name                     AS 'applyname'
		FROM mis_purchase_applysub
		LEFT JOIN mis_purchase_applymas
		ON mis_purchase_applysub.masid = mis_purchase_applymas.id
		LEFT JOIN mis_product_code
		ON mis_purchase_applysub.prodid = mis_product_code.id
		LEFT JOIN mis_product_type
		ON mis_product_code.typeid = mis_product_type.id
		LEFT JOIN mis_sales_project
		ON mis_purchase_applysub.projectid = mis_sales_project.id
		LEFT JOIN mis_purchase_assignsub
		ON mis_purchase_applysub.id = mis_purchase_assignsub.asubid
		LEFT JOIN USER
		ON mis_purchase_applymas.userid = user.id
		WHERE mis_product_type.typeid = 2
		$wh";
		if($sidx) {
			$sql .= "ORDER BY  $sidx $sord";
		}
		$list1 = $this->query($sql);
		$misInventoryIntoSubModel=D('MisInventoryIntoSub');
		$usermodel=D('User');
		$userlist=$usermodel->where('status=1')->getField('id,name');
		//采购分派模型
		$MisPurchaseAssignsubModel=D('MisPurchaseAssignsub');
		//采购订单模型
		$misPurchaseOrdersubModel=D('MisPurchaseOrdersub');
		//入库模型
		$MisInventoryIntoSubModel=D('MisInventoryIntoSub');
		//产品模型
		$MisProductCodeModel=D('MisProductCode');
		//基本单位
		$productunitmodel = D('MisProductUnit');
		$productunitlist =$productunitmodel->where('status=1')->getField('id,name');
		//供应商模型
		$misPurchaseSupplierModel=D('MisPurchaseSupplier');
		$misPurchaseSupplierList =$misPurchaseSupplierModel->where('status=1')->getField('id,name');
		//入库mas模型
		$MisInventoryIntoMasModel=D('MisInventoryIntoMas');
		//财务Mas模型
		$misInventoryIntoFmasModel=D('MisInventoryIntoFmas');
		//运费凭证单模型
		$misDeliveryIntoMasModel=D('MisDeliveryIntoMas');
		foreach ($list1 as $key => $value) {
			//申请日期
			if($value['applyapdate']){
				$list1[$key]['applyapdate']=date('Y-m-d',$value['applyapdate']);
			}else{
				$list1[$key]['applyapdate']='';
			}
			//需求日期
			if($value['applydmdate']){
				$list1[$key]['applydmdate']=date('Y-m-d',$value['applydmdate']);
			}else{
				$list1[$key]['applydmdate']='';
			}
			//转换基本单位
			if ($value['unitname']) {
				//单位为基本单位
				$list1[$key]['unitname'] =$productunitlist[$value['unitname']];
			}else{
				$list1[$key]['unitname'] ="";
			}
			//采购订单
			$misPurchaseOrdersubList=$misPurchaseOrdersubModel->where(' asubid='.$value['id'])->find();
			if($misPurchaseOrdersubList){
				$list1[$key]['orderqty']=$misPurchaseOrdersubList['qty'];//数量
				$list1[$key]['orderunitprice']=$misPurchaseOrdersubList['unitprice']; //单价
				$list1[$key]['orderamount']=$misPurchaseOrdersubList['amount'];  //不含税总金额
				$list1[$key]['ordersupname']=$misPurchaseSupplierList[$misPurchaseOrdersubList['supplierid']];  //供应商名称
				$MisInventoryIntoSubList=$MisInventoryIntoSubModel->where(' status=1  and ordersubid='.$misPurchaseOrdersubList['id'])->find(); //入库
			}
			if($misPurchaseOrdersubList){  //是否建单
				$list1[$key]['isOrder']='是';
			}else{
				$list1[$key]['isOrder']='否';
				$list1[$key]['color'] ='red';
			}
			$MisPurchaseAssignsubList=$MisPurchaseAssignsubModel->where('status=1  and asubid='.$value['id'])->find();
			if($MisPurchaseAssignsubList){
				$list1[$key]['AssignTime']=date('Y-m-d',$MisPurchaseAssignsubList['adate']);//接单日期 （采购分派日期）
				$list1[$key]['AssignUserName']=$userlist[$MisPurchaseAssignsubList['proposer']];//采购人
			}
			if($MisPurchaseAssignsubList==""){ //是否分派
				$list1[$key]['isAssign']='否';
			}else{
				$list1[$key]['isAssign']='是';
			}
			if($MisInventoryIntoSubList){
				$MisProductCodeList=$MisProductCodeModel->where(" status=1 and id=".$MisInventoryIntoSubList['prodid'])->find();
				$list1[$key]['intoproexpend04']=$MisProductCodeList['expend04']; // 验收胸径
				$list1[$key]['intoproexpend01']=$MisProductCodeList['expend01']; // 验收高度
				$list1[$key]['intoproexpend03']=$MisProductCodeList['expend03']; // 验收冠幅
				$list1[$key]['intoproname']=$MisProductCodeList['name']; // 验收产品名称
				$MisInventoryIntoSubList['masid']|getFieldBy('id','orderno','mis_inventory_into_mas');//验收单号
				$MisInventoryIntoMasList=$MisInventoryIntoMasModel->where('id='.$MisInventoryIntoSubList['masid'])->find();
				//此处运费凭证
				$misDeliveryIntoMasList=$misDeliveryIntoMasModel->where("  status=1 and  intomasid=".$MisInventoryIntoMasList['id'])->select();
				$list1[$key]['DeliveryAmount'] = 0;
				foreach($misDeliveryIntoMasList as $k => $v){
					if($v['amount']){
						$list1[$key]['DeliveryAmount'] += floatval($v['amount']);  //运费凭证总金额
					}
				}
				//是否移交单至财务
				$misInventoryIntoFmasList=$misInventoryIntoFmasModel->where(" status=1 and intomasid=".$MisInventoryIntoMasList['id'])->find();
				if($misInventoryIntoFmasList){
					$list1[$key]['color'] ='black';
				}
				$list1[$key]['intototime']= date('Y-m-d',$MisInventoryIntoMasList['handledate']);  //到货日期
				$list1[$key]['intoorderno']=$MisInventoryIntoMasList['orderno'];
				$list1[$key]['intocreatetime']=date('Y-m-d',$MisInventoryIntoMasList['createtime']);   //输单日期
			}
		}
		return $list1;
	}
	/**
	 * @Title: getReportPurchaseOrderTracking
	 * @Description: todo(邮费报表导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-4-25
	 * @throws
	 */
	function getReportGetCarOilReport($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'startTime':
					$wh .= " AND mis_car_add_oil_info.add_time >= ".strtotime($v);
					break;
				case  'stopTime':
					$wh .= " AND mis_car_add_oil_info.add_time  <= ".strtotime($v);
					break;
				case 'oilID':
					$wh.=" and mis_car_add_oil_info.oil_id LIKE '%".$v."%'";
					break;
				case 'departmentname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'carno':
					$wh .= " AND mis_system_car.carno LIKE '%".$v."%'";
					break;
				case 'useNameID':
					$wh .= " AND mis_system_car.useNameID LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT
					  mis_system_department.name  deptname
					FROM mis_car_add_oil_info mis_car_add_oil_info
					  LEFT JOIN mis_system_car AS mis_system_car
					    ON mis_car_add_oil_info.oil_id = mis_system_car.oilID
					  LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
					    ON mis_hr_personnel_person_info.id = mis_system_car.useNameID
					  LEFT JOIN mis_system_department mis_system_department
					    ON mis_system_department.id = mis_system_car.departmentID
					WHERE mis_car_add_oil_info.status = 1
					GROUP BY mis_car_add_oil_info.oil_id  $wh";
		
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql= "SELECT
				mis_car_add_oil_info.id id,
			  mis_system_department.name deptname,
			  mis_system_car.carno carno,
			  mis_system_car.name carname,
			  mis_hr_personnel_person_info.name name,
			  mis_car_add_oil_info.oil_id oil_id,
			  SUM(mis_car_add_oil_info.amount)     AS countamount,
			  mis_car_add_oil_info.oil_balance AS oil_balance,
			  mis_car_add_oil_info.amount amount,
			  mis_car_add_oil_info.remark
			FROM mis_car_add_oil_info mis_car_add_oil_info
			  LEFT JOIN mis_system_car AS mis_system_car
			    ON mis_car_add_oil_info.oil_id = mis_system_car.oilID
			  LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
			    ON mis_hr_personnel_person_info.id = mis_system_car.useNameID
			  LEFT JOIN mis_system_department mis_system_department
			    ON mis_system_department.id = mis_system_car.departmentID
			WHERE mis_car_add_oil_info.status = 1
			GROUP BY mis_car_add_oil_info.oil_id $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$val['nd'] = $key+1;
			$arr[$key]=$val;
		}
		return $arr;
	}
	
	
	function getReportPurchaseMaterialExcel($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'materialapplyorderno':
					$wh.=" and mis_purchase_applymas.orderno LIKE '%".$v."%'";
					break;
				case 'materialapplyprojectname':
					$wh.=" and mis_sales_project.name  LIKE '%".$v."%'";
					break;
				case 'materialapplycodename':
					$wh .= " AND mis_product_code.name LIKE '%".$v."%'";
					break;
				case 'materialapplycodesize':
					$wh .= " AND mis_product_code.prodsize  LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT
		mis_sales_project.name        AS 'projectname',
		mis_purchase_applymas.orderno AS 'orderno',
		mis_product_code.name         AS 'proname',
		mis_product_code.prodsize   AS 'prosize',
		mis_purchase_applysub.id   	  AS 'id',
		mis_product_code.name         AS 'prodename',
		mis_product_code.baseunitid  AS 'unitname',
		mis_purchase_applysub.qty     AS 'applyqty',
		mis_purchase_applymas.dmdate  AS 'applydmdate',
		mis_purchase_applymas.apdate  AS 'applyapdate',
		mis_purchase_applymas.remark  AS 'applyremark',
		user.name  AS 'applyname'
		FROM mis_purchase_applysub
		LEFT JOIN mis_purchase_applymas
		ON mis_purchase_applysub.masid = mis_purchase_applymas.id
		LEFT JOIN mis_product_code
		ON mis_purchase_applysub.prodid = mis_product_code.id
		LEFT JOIN mis_product_type
		ON mis_product_code.typeid = mis_product_type.id
		LEFT JOIN mis_sales_project
		ON mis_purchase_applysub.projectid = mis_sales_project.id
		LEFT JOIN mis_purchase_assignsub
		ON mis_purchase_applysub.id = mis_purchase_assignsub.asubid
		LEFT JOIN USER
		ON mis_purchase_applymas.userid= user.id
		WHERE mis_product_type.typeid = 1
		$wh ";
		if($sord) {
			$sql .= "ORDER BY  $sidx $sord";
		}
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT
		mis_sales_project.name        AS 'projectname',
		mis_purchase_applymas.orderno AS 'orderno',
		mis_product_code.name         AS 'proname',
		mis_product_code.prodsize   AS 'prosize',
		mis_purchase_applysub.id   	  AS 'id',
		mis_product_code.name         AS 'prodename',
		mis_product_code.baseunitid  AS 'unitname',
		mis_purchase_applysub.qty     AS 'applyqty',
		mis_purchase_applymas.dmdate  AS 'applydmdate',
		mis_purchase_applymas.apdate  AS 'applyapdate',
		mis_purchase_applymas.remark  AS 'applyremark',
		user.name  AS 'applyname'
		FROM mis_purchase_applysub
		LEFT JOIN mis_purchase_applymas
		ON mis_purchase_applysub.masid = mis_purchase_applymas.id
		LEFT JOIN mis_product_code
		ON mis_purchase_applysub.prodid = mis_product_code.id
		LEFT JOIN mis_product_type
		ON mis_product_code.typeid = mis_product_type.id
		LEFT JOIN mis_sales_project
		ON mis_purchase_applysub.projectid = mis_sales_project.id
		LEFT JOIN mis_purchase_assignsub
		ON mis_purchase_applysub.id = mis_purchase_assignsub.asubid
		LEFT JOIN USER
		ON mis_purchase_applymas.userid= user.id
		WHERE mis_product_type.typeid = 1
		$wh ";
		if($sidx) {
			$sql .= "ORDER BY  $sidx $sord";
		}
		$list1 = $this->query($sql);
		$misInventoryIntoSubModel=D('MisInventoryIntoSub');
		$usermodel=D('User');
		$userlist=$usermodel->where('status=1')->getField('id,name');
		//采购分派模型
		$MisPurchaseAssignsubModel=D('MisPurchaseAssignsub');
		//采购订单模型
		$misPurchaseOrdersubModel=D('MisPurchaseOrdersub');
		//入库模型
		$MisInventoryIntoSubModel=D('MisInventoryIntoSub');
		//产品模型
		$MisProductCodeModel=D('MisProductCode');
		//基本单位
		$productunitmodel = D('MisProductUnit');
		$productunitlist =$productunitmodel->where('status=1')->getField('id,name');
		//供应商模型
		$misPurchaseSupplierModel=D('MisPurchaseSupplier');
		$misPurchaseSupplierList =$misPurchaseSupplierModel->where('status=1')->getField('id,name');
		//入库mas模型
		$MisInventoryIntoMasModel=D('MisInventoryIntoMas');
		//财务Mas模型
		$misInventoryIntoFmasModel=D('MisInventoryIntoFmas');
		foreach ($list1 as $key => $value) {
			//申请日期
			if($value['applyapdate']){
				$list1[$key]['applyapdate']=date('Y-m-d',$value['applyapdate']);
			}else{
				$list1[$key]['applyapdate']='';
			}
			//需求日期
			if($value['applydmdate']){
				$list1[$key]['applydmdate']=date('Y-m-d',$value['applydmdate']);
			}else{
				$list1[$key]['applydmdate']='';
			}
			//转换基本单位
			if ($value['unitname']) {
				//单位为基本单位
				$list1[$key]['unitname'] =$productunitlist[$value['unitname']];
			}else{
				$list1[$key]['unitname'] ="";
			}
			//采购订单
			$misPurchaseOrdersubList=$misPurchaseOrdersubModel->where(' asubid='.$value['id'])->find();
			if($misPurchaseOrdersubList){
				$list1[$key]['orderqty']=$misPurchaseOrdersubList['qty'];//数量
				$list1[$key]['orderunitprice']=$misPurchaseOrdersubList['unitprice']; //单价
				$list1[$key]['orderamount']=$misPurchaseOrdersubList['amount'];  //不含税总金额
				$list1[$key]['ordersupname']=$misPurchaseSupplierList[$misPurchaseOrdersubList['supplierid']];  //供应商名称
				$MisInventoryIntoSubList=$MisInventoryIntoSubModel->where(' status=1  and ordersubid='.$misPurchaseOrdersubList['id'])->find(); //入库
			}
			if($misPurchaseOrdersubList){  //是否建单
				$list1[$key]['isOrder']='是';
			}else{
				$list1[$key]['isOrder']='否';
				$list1[$key]['color'] ='red';
			}
			$list1[$key]['intoForderno']="";
			$list1[$key]['intopaymoney']="";

			$MisPurchaseAssignsubList=$MisPurchaseAssignsubModel->where('status=1  and asubid='.$value['id'])->find();
			if($MisPurchaseAssignsubList){
				$list1[$key]['AssignTime']=date('Y-m-d',$MisPurchaseAssignsubList['adate']);//接单日期 （采购分派日期）
				$list1[$key]['AssignUserName']=$userlist[$MisPurchaseAssignsubList['proposer']];//采购人
			}
			if($MisPurchaseAssignsubList==""){ //是否分派
				$list1[$key]['isAssign']='否';
			}else{
				$list1[$key]['isAssign']='是';
			}
			if($MisInventoryIntoSubList){
				$MisProductCodeList=$MisProductCodeModel->where(" status=1 and id=".$MisInventoryIntoSubList['prodid'])->find();
				$list1[$key]['intoprosize']=$MisProductCodeList['prodsize']; // 验收规格
				$list1[$key]['intoproname']=$MisProductCodeList['name']; // 验收产品名称
				$MisInventoryIntoSubList['masid']|getFieldBy('id','orderno','mis_inventory_into_mas');//验收单号
				$MisInventoryIntoMasList=$MisInventoryIntoMasModel->where('id='.$MisInventoryIntoSubList['masid'])->find();
				//是否移交单至财务
				$misInventoryIntoFmasList=$misInventoryIntoFmasModel->where(" status=1 and intomasid=".$MisInventoryIntoMasList['id'])->find();
				if($misInventoryIntoFmasList){
					$list1[$key]['color'] ='black';
				}
				$list1[$key]['intototime']= date('Y-m-d',$MisInventoryIntoMasList['handledate']);  //到货日期
				$list1[$key]['intoorderno']=$MisInventoryIntoMasList['orderno'];
				$list1[$key]['intocreatetime']=date('Y-m-d',$MisInventoryIntoMasList['createtime']);   //输单日期
			}
		}
		return $list1;
	}
	function getOrderProgressDetailed($sidx,$sord,$wh) {
		$sql = "SELECT DISTINCT od.id AS 'id',
		od.orderno AS 'orderno',
		customer.name AS 'customer',
		project.code AS 'project',
		currency.code AS 'currency',
		od.ioamount AS 'ioamount',
		od.oamount AS 'oamount',
		od.createtime AS 'createtime',
		od.ddate AS 'ddate',
		od.remark AS 'remark'
		FROM mis_sales_ordermas AS od
		LEFT JOIN mis_sales_customer customer ON od.customerid = customer.id
		LEFT JOIN mis_sales_project project ON od.projectid = project.id
		LEFT JOIN mis_finance_currency currency ON od.currencyid = currency.id
		LEFT JOIN mis_sales_ordersub sub ON od.id = sub.masid
		WHERE 1=1 $wh";
		if($sidx) {
			$sql .= "ORDER BY $sidx $sord";
		}
		$list1 = $this->query($sql);
		$outMas = D('MisInventoryOutMas');
		$salesSub = D('MisSalesOrdersub');
		$format = "Y-m-d";
		$totalIoamount = 0;
		$totalOamount = 0;
		foreach ($list1 as $key => $value) {
			$list1[$key]['createtime'] = date($format,$list1[$key]['createtime']);
			$list1[$key]['ddate'] = date($format,$list1[$key]['ddate']);
			$list1[$key]['qty'] = $salesSub->where('masid='.$value['id'])->sum('qty');
			$list1[$key]['outtime'] = date($format,$outMas->where('sorderid='.$value['id'])->order('createtime asc')->getField('createtime'));
			$list1[$key]['status'] = getTraceStatus($salesSub->where('masid='.$value['id'])->order('ostatus asc')->getField('ostatus'));
			$sql = "SELECT ptype.name AS 'ptype' FROM mis_sales_ordermas od
					LEFT JOIN mis_sales_ordersub sub ON od.id = sub.masid
					JOIN mis_product_code product ON sub.prodid = product.id
					JOIN mis_product_type ptype ON product.typeid = ptype.id
					WHERE od.id =".$value["id"];
			$list3 = $this->query($sql);
			for ($i = 0, $length = count($list3); $i < $length; $i++) {
				$list1[$key]["ptype"] = $list3[$i]["ptype"];
				if($i < $length - 1) {
					$list1[$key]["ptype"] .= "|";
				}
			}
			$totalIoamount += $list1[$key]['ioamount'];
			$totalOamount += $list1[$key]['oamount'];
		}
		$userText = array();
		$userText['currency'] = "Totals:";
		$userText['ioamount'] = $totalIoamount;
		$userText['oamount'] = $totalOamount;
		$list1[] = $userText;
		return $list1;
	}


	function getSalesOrderStatistics($sidx,$sord,$wh) {
		$sql = "SELECT DISTINCT od.id AS 'id',
		od.orderno AS 'orderno',
		customer.name AS 'customer',
		project.code AS 'project',
		od.ioamount AS 'ioamount',
		od.oamount AS 'oamount'
		FROM mis_sales_ordermas AS od
		LEFT JOIN mis_sales_customer customer ON od.customerid = customer.id
		LEFT JOIN mis_sales_project project ON od.projectid = project.id
		LEFT JOIN mis_sales_ordersub sub ON od.id = sub.masid
		WHERE 1=1 $wh";
		if($sidx) {
			$sql .= " ORDER BY $sidx $sord ";
		}
		$list1 = $this->query($sql);
		$salesSub = D('MisSalesOrdersub');
		foreach ($list1 as $key => $value) {
			$list1[$key]['qty'] = $salesSub->where('masid='.$value['id'])->sum('qty');
			$list1[$key]['status'] = getTraceStatus($salesSub->where('masid='.$value['id'])->order('ostatus asc')->getField('ostatus'));
			$sql = "SELECT ptype.name AS 'ptype' FROM mis_sales_ordermas od
					LEFT JOIN mis_sales_ordersub sub ON od.id = sub.masid
					JOIN mis_product_code product ON sub.prodid = product.id
					JOIN mis_product_type ptype ON product.typeid = ptype.id
					WHERE od.id =".$value["id"];
			$list3 = $this->query($sql);
			for ($i = 0, $length = count($list3); $i < $length; $i++) {
				$list1[$key]["ptype"] = $list3[$i]["ptype"];
				if($i < $length - 1) {
					$list1[$key]["ptype"] .= "|";
				}
			}
			$totalIoamount += $list1[$key]['ioamount'];
			$totalOamount += $list1[$key]['oamount'];
		}
		$userText = array();
		$userText['qty'] = "Totals:";
		$userText['ioamount'] = $totalIoamount;
		$userText['oamount'] = $totalOamount;
		$list1[] = $userText;
		return $list1;
	}

	/**
	 * @Title: getReportPurchaseOrderTracking
	 * @Description: todo(物资申请跟踪表导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-4-25
	 * @throws
	 */
	function getMaterialStrackingExcelList($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'id':
				case 'orderno':
					$wh.=" and mis_project_material_application_mas.".$k." LIKE '%".$v."%'";
					break;
				case 'projectname':
					$wh .= " AND mis_sales_project.name LIKE '%".$v."%'";
					break;
				case 'subgoods':
					$wh .= " AND mis_project_material_application_sub.goods LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT  COUNT(mis_project_material_application_sub.id) AS 'count'
		FROM mis_project_material_application_mas AS mis_project_material_application_mas
		LEFT JOIN mis_sales_project mis_sales_project ON mis_project_material_application_mas.projectid = mis_sales_project.id
		LEFT JOIN mis_project_material_application_sub mis_project_material_application_sub ON mis_project_material_application_mas.id = mis_project_material_application_sub.masid
		WHERE 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT DISTINCT
		mis_project_material_application_mas.id AS 'id',
		mis_project_material_application_mas.orderno AS 'orderno',
		mis_sales_project.name AS 'projectname',
		mis_project_material_application_sub.psize AS 'subpsize',
		mis_project_material_application_sub.goods AS 'subgoods',
		mis_project_material_application_mas.auditState AS 'auditState',
		mis_project_material_application_sub.appnumber as 'subappnumber'
		FROM mis_project_material_application_mas AS mis_project_material_application_mas
		LEFT JOIN mis_sales_project mis_sales_project ON mis_project_material_application_mas.projectid = mis_sales_project.id
		LEFT JOIN mis_project_material_application_sub mis_project_material_application_sub ON mis_project_material_application_mas.id = mis_project_material_application_sub.masid
		WHERE 1=1  $wh
		ORDER BY $sidx $sord ";
		// LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$materialSub = D('MisProjectMaterialApplicationSub');
		foreach ($list1 as $key => $value) {
			$list1[$key]['subappnumber'] = (int)$value['subappnumber'];
			$sql = "SELECT unit.name AS 'ptype' FROM mis_project_material_application_mas od
					LEFT JOIN mis_project_material_application_sub sub ON od.id = sub.masid
					JOIN mis_product_unit unit ON sub.baseunitid = unit.id
					WHERE od.id =".$value["id"];
			$list3 = $this->query($sql);
			$length = count($list3);
			for ($i = 0; $i < $length; $i++) {
				$list1[$key]["ptype"] = $list3[$i]["ptype"];
			}
			//申请状态
			$list1[$key]['auditState'] = getAuditState($value['auditState']);
		}
		return $list1;
	}

	/**
	 * @Title: getReportPurchaseOrderExcelList
	 * @Description: todo(采购订单统计表导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-4-25
	 * @throws
	 */
	function getReportPurchaseOrderExcelList($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'reorid':
					$wh.=" and mis_purchase_ordermas.id LIKE '%".$v."%'";
					break;
				case 'reororderno':
					$wh.=" and mis_purchase_ordermas.orderno LIKE '%".$v."%'";
					break;
				case 'contractmasorderno':
					$wh .= " AND mis_purchase_contractmas.orderno LIKE '%".$v."%'";
					break;
				case 'suppliername':
					$wh .= " AND mis_purchase_supplier.name LIKE '%".$v."%'";
					break;
				case 'reorprojectname':
					$wh .= " AND mis_sales_project.name LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT  COUNT(DISTINCT mis_purchase_ordersub.id) AS 'count'
		FROM mis_purchase_ordermas AS mis_purchase_ordermas
		LEFT JOIN mis_purchase_contractmas mis_purchase_contractmas ON mis_purchase_ordermas.prcnoid = mis_purchase_contractmas.id
		LEFT JOIN mis_purchase_supplier mis_purchase_supplier ON mis_purchase_ordermas.supplierid = mis_purchase_supplier.id
		LEFT JOIN mis_sales_project mis_sales_project ON mis_purchase_ordermas.projectid = mis_sales_project.id
		LEFT JOIN mis_purchase_ordersub mis_purchase_ordersub ON mis_purchase_ordermas.id = mis_purchase_ordersub.masid
		LEFT JOIN mis_product_code AS mis_product_code ON mis_product_code.id = mis_purchase_ordersub.prodid
		WHERE 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) {
			$page=$total_pages;
		}
		$start = $limit*$page - $limit;
		if ($start<0) {
			$start = 0;
		}
		$sql = "SELECT DISTINCT
		mis_purchase_ordermas.id            AS 'reorid',
		mis_purchase_ordermas.orderno       AS 'reororderno',
		mis_purchase_contractmas.orderno    AS 'contractmasorderno',
		mis_purchase_supplier.name          AS 'suppliername',
		mis_sales_project.name              AS 'reorprojectname',
		mis_product_code.name               AS 'productcodename',
		mis_purchase_ordersub.qty           AS 'reorqty',
		mis_purchase_ordersub.unitprice     AS 'subunitprice',
		mis_purchase_ordersub.amount        AS 'subamount',
		mis_purchase_ordersub.taxunitprice  AS 'subtaxunitprice',
		mis_purchase_ordersub.taxamount     AS 'subtaxamount',
		mis_purchase_ordermas.auditState    AS 'auditState'
		FROM  mis_purchase_ordersub AS mis_purchase_ordersub
		LEFT JOIN mis_purchase_ordermas AS mis_purchase_ordermas  ON mis_purchase_ordermas.id = mis_purchase_ordersub.masid
		LEFT JOIN mis_purchase_contractmas mis_purchase_contractmas ON mis_purchase_ordermas.prcnoid = mis_purchase_contractmas.id
		LEFT JOIN mis_purchase_supplier mis_purchase_supplier ON mis_purchase_ordermas.supplierid = mis_purchase_supplier.id
		LEFT JOIN mis_sales_project mis_sales_project ON mis_purchase_ordermas.projectid = mis_sales_project.id
		LEFT JOIN mis_product_code AS mis_product_code ON mis_product_code.id = mis_purchase_ordersub.prodid
		WHERE 1=1  $wh
		ORDER BY $sidx $sord ";
		//LIMIT $start , $limit";
		$list1 = $this->query($sql);
		foreach ($list1 as $key => $value) {
			$list1[$key]['status'] = getAuditState($value['auditState']);
		}
		return $list1;
	}

	/**
	 * @Title: getMaterialApplicationNotPurchaseExcelList
	 * @Description: todo(物资申请未采购表导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-4-27
	 * @throws
	 */
	function getMaterialApplicationNotPurchaseExcelList($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'noorderno':
					$wh.=" and mis_project_material_application_mas.orderno LIKE '%".$v."%'";
					break;
				case 'nopcodecode':
					$wh .= " AND mis_product_code.code LIKE '%".$v."%'";
					break;
				case 'noprojectname':
					$wh .= " AND mis_sales_project.name LIKE '%".$v."%'";
					break;
				case 'nopcodename':
					$wh .= " AND mis_product_code.name LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT  COUNT(DISTINCT mis_project_material_application_sub.id) AS 'count'
		FROM mis_project_material_application_mas AS mis_project_material_application_mas
		LEFT JOIN mis_sales_project mis_sales_project ON mis_project_material_application_mas.projectid = mis_sales_project.id
		LEFT JOIN mis_project_material_application_sub mis_project_material_application_sub ON mis_project_material_application_mas.id = mis_project_material_application_sub.masid
		LEFT JOIN mis_product_code mis_product_code ON  mis_project_material_application_sub.prodid = mis_product_code.id
		LEFT JOIN mis_product_unit mis_product_unit ON mis_project_material_application_sub.baseunitid = mis_product_unit.id
		WHERE 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT DISTINCT
		mis_project_material_application_mas.id AS 'noid',
		mis_project_material_application_mas.orderno AS 'noorderno',
		mis_sales_project.name AS 'noprojectname',
		mis_product_code.code AS 'nopcodecode',
		mis_product_code.name AS 'nopcodename',
		mis_product_unit.name AS 'nopunitname',
		mis_project_material_application_sub.appnumber AS 'nosubappnumber',
		mis_project_material_application_sub.qty AS 'nosubqty',
		mis_project_material_application_sub.prodid AS 'nosubprodid',
		mis_product_unit.id AS 'nopunitid',
		mis_project_material_application_sub.psize AS 'nosubpsize',
		mis_project_material_application_mas.auditState AS 'noauditState'
		FROM mis_project_material_application_mas AS mis_project_material_application_mas
		LEFT JOIN mis_sales_project mis_sales_project ON mis_project_material_application_mas.projectid = mis_sales_project.id
		LEFT JOIN mis_project_material_application_sub mis_project_material_application_sub ON mis_project_material_application_mas.id = mis_project_material_application_sub.masid
		LEFT JOIN mis_product_code mis_product_code ON  mis_project_material_application_sub.prodid = mis_product_code.id
		LEFT JOIN mis_product_unit mis_product_unit ON mis_project_material_application_sub.baseunitid = mis_product_unit.id
		WHERE 1=1  $wh
		ORDER BY no$sidx $sord ";
		//   LIMIT $start , $limit";
		$list1 = $this->query($sql);
		//获取项目物资对应的mis_order_types的id
		$typemodel = D("MisOrderTypes");
		$materialid = $typemodel->where('name="项目物资" and status=1 ')->Field('id')->find();
		//获取已采购数量
		foreach ($list1 as $key => $val) {
			$list1[$key]['nosubappnumber'] = (int)$val['nosubappnumber'];
			//初始化已采购数量
			$list1[$key]['ispurchase'] = 0;
			//初始化未采购数量
			$list1[$key]['nopurchase'] = (int)$val['subappnumber'];
			//订单状态
			$list1[$key]['noauditState'] = getAuditState($val['noauditState']);
			$sql2 = "SELECT
					mis_purchase_applysub.qty AS 'qty',
					mis_purchase_applysub.id AS 'subid',
					mis_purchase_applysub.prodid AS 'prodid',
					mis_purchase_supplier.name  AS 'nosuppname'
					FROM mis_purchase_applymas AS mis_purchase_applymas
					LEFT JOIN mis_purchase_applysub AS mis_purchase_applysub ON mis_purchase_applymas.id=mis_purchase_applysub.masid
					LEFT JOIN mis_purchase_ordersub AS mis_purchase_ordersub  ON mis_purchase_ordersub.asubid = mis_purchase_applysub.id
					LEFT JOIN mis_purchase_supplier AS mis_purchase_supplier ON mis_purchase_supplier.id = mis_purchase_ordersub.customerid
					WHERE mis_purchase_applymas.typeid = ".$materialid['id']."  AND mis_purchase_applymas.id =".$val['noid'];
			$list2 =$this->query($sql2);
			//变动已采购数量,未采购数量
			foreach ($list2 as $key2 => $val2) {
				if ($val['subprodid'] == $val2['prodid']) {
					$list1[$key]['ispurchase'] += (int)$val2['qty'];
					$list1[$key]['nopurchase'] = 0;
					$list1[$key]['nosuppname'] = $val2['nosuppname'];
				}
			}
			//获取库存仓数量
			$inventorymodel = D("MisInventoryRealinfo");
			$listresult = $inventorymodel->where("prodid =".$val['nosubprodid']." and status =1 ")->select();
			$Inventorysum = 0;
			if ($listresult) {
				foreach ($listresult as $valresult) {
					//处理单位
					if((!$listresult) && $valresult['unitid'] == $val['nosubprodid']){
						$Inventorysum += $valresult['qty'];
					}else{
						$Inventorysum += getAfterExchangeQty($valresult['unitid'],(int)$valresult['qty']);
					}
				}
			}
			$list1[$key]['Inventorysum'] =$Inventorysum;
		}
		//格式化
		foreach ($list1 as $key => $val) {
			$list1[$key]['nosubappnumber'] = number_format($val['nosubappnumber']);
			$list1[$key]['ispurchase'] = number_format($val['ispurchase']);
			$list1[$key]['nopurchase'] = number_format($val['nopurchase']);
			$list1[$key]['Inventorysum'] = number_format($val['Inventorysum']);
		}
		return $list1;
	}

	/**
	 * @Title: getPurchaseOrderReceiptExcelList
	 * @Description: todo(采购订收货统计表导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-4-28
	 * @throws
	 */
	function getPurchaseOrderReceiptExcelList($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'receiptid':
					$wh.=" and mis_purchase_ordermas.id LIKE '%".$v."%'";
					break;
				case 'receiptprojectcode':
					$wh.=" and mis_sales_project.code LIKE '%".$v."%'";
					break;
				case 'receiptprojectname':
					$wh .= " AND mis_sales_project.name LIKE '%".$v."%'";
					break;
				case 'receiptsuupcode':
					$wh .= " AND mis_purchase_supplier.code LIKE '%".$v."%'";
					break;
				case 'receiptsuupname':
					$wh .= " AND mis_sales_project.name LIKE '%".$v."%'";
					break;
				case 'receiptproducttypecode':
					$wh .= " AND mis_product_type.code LIKE '%".$v."%'";
					break;
				case 'receiptproducttypecode':
					$wh .= " AND mis_product_type.code LIKE '%".$v."%'";
					break;
				case 'receiptproductcode':
					$wh .= " AND mis_product_code.code LIKE '%".$v."%'";
					break;
				case 'receiptproductname':
					$wh .= " AND mis_product_code.name LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT  COUNT(DISTINCT mis_purchase_ordersub.id) AS 'count'
		FROM mis_purchase_ordermas AS mis_purchase_ordermas
		LEFT JOIN mis_purchase_ordersub AS mis_purchase_ordersub ON mis_purchase_ordermas.id = mis_purchase_ordersub.masid
		LEFT JOIN mis_sales_project AS mis_sales_project ON mis_purchase_ordermas.projectid = mis_sales_project.id
		LEFT JOIN mis_purchase_supplier AS mis_purchase_supplier ON mis_purchase_ordermas.supplierid = mis_purchase_supplier.id
		LEFT JOIN mis_inventory_into_sub  AS mis_inventory_into_sub ON mis_inventory_into_sub.ordersubid =mis_purchase_ordersub.id
		LEFT JOIN mis_purchase_returnsub AS  mis_purchase_returnsub ON mis_purchase_returnsub.pordersubid =mis_purchase_ordersub.id
		LEFT JOIN mis_product_code AS mis_product_code ON mis_product_code.id=mis_purchase_ordersub.prodid
		LEFT JOIN mis_product_type AS mis_product_type ON mis_product_code.typeid = mis_product_type.id
		WHERE 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		/*
		 sub.id AS 	'receiptid',
		project.code AS '项目编码',receiptprojectcode
		project.name AS '项目名称',receiptprojectname
		suup.code    AS '供应商编码',receiptsuupcode
		suup.name    AS '供应商名称',receiptsuupname
		sub.prodid   AS '物质id',receiptsubprodid
		product.code AS '物质编码',receiptproductcode
		product.name AS '物质名称',receiptproductname
		product.prodsize AS '物质规格',receiptproductprodsize
		sub.unitid AS '单位id',receiptsubunitid
		producttype.code AS '物质分类编码',receiptproducttypecode
		producttype.name AS '物质分类名称',receiptproducttypename
		sub.qty AS '订单数量',receiptsubqty
		intosub.qty AS '入库数量',receiptintosubqty
		returnsub.qty AS '退库量',receiptreturnsubqty
		product.baseunitid AS '基本单位'receiptproductbaseunitid
		*/
		//所有字段加一个前缀“receipt”避免重复
		$sql = "SELECT DISTINCT
		mis_purchase_ordersub.id       AS  'subid',
		mis_purchase_ordermas.id       AS 'receiptid',
		mis_sales_project.code         AS 'receiptprojectcode',
		mis_sales_project.name         AS 'receiptprojectname',
		mis_purchase_supplier.code     AS 'receiptsuupcode',
		mis_purchase_supplier.name     AS 'receiptsuupname',
		mis_purchase_ordersub.prodid   AS 'receiptsubprodid',
		mis_product_code.code          AS 'receiptproductcode',
		mis_product_code.name          AS 'receiptproductname',
		mis_product_code.prodsize      AS 'receiptproductprodsize',
		mis_purchase_ordersub.unitid   AS 'receiptsubunitid',
		mis_product_type.code          AS 'receiptproducttypecode',
		mis_product_type.name          AS 'receiptproducttypename',
		mis_purchase_ordersub.qty      AS 'receiptsubqty',
		mis_inventory_into_sub.qty     AS 'receiptintosubqty',
		mis_purchase_returnsub.qty     AS 'receiptreturnsubqty',
		mis_product_code.baseunitid    AS 'receiptproductbaseunitid'
		FROM mis_purchase_ordermas AS mis_purchase_ordermas
		LEFT JOIN mis_purchase_ordersub AS mis_purchase_ordersub ON mis_purchase_ordermas.id = mis_purchase_ordersub.masid
		LEFT JOIN mis_sales_project AS mis_sales_project ON mis_purchase_ordermas.projectid = mis_sales_project.id
		LEFT JOIN mis_purchase_supplier AS mis_purchase_supplier ON mis_purchase_ordermas.supplierid = mis_purchase_supplier.id
		LEFT JOIN mis_inventory_into_sub  AS mis_inventory_into_sub ON mis_inventory_into_sub.ordersubid =mis_purchase_ordersub.id
		LEFT JOIN mis_purchase_returnsub AS  mis_purchase_returnsub ON mis_purchase_returnsub.pordersubid =mis_purchase_ordersub.id
		LEFT JOIN mis_product_code AS mis_product_code ON mis_product_code.id=mis_purchase_ordersub.prodid
		LEFT JOIN mis_product_type AS mis_product_type ON mis_product_code.typeid = mis_product_type.id
		WHERE 1=1  $wh
		ORDER BY $sidx $sord ";
		//	LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$productunitmodel = D('MisProductUnit');
		$productunitlist =$productunitmodel->where('status=1')->getField('id,name');
		foreach ($list1 as $key => $value) {
			$list1[$key]['receiptreturnsubqty'] = (int)$value['receiptreturnsubqty'];
			$list1[$key]['receiptsubqty'] = (int)$value['receiptsubqty'];
			$list1[$key]['receiptintosubqty'] = (int)$value['receiptintosubqty'];
			if ($value['receiptsubunitid'] == 0) {
				//单位为基本单位
				$list1[$key]['receiptsubunit'] = $productunitlist[$value['receiptproductbaseunitid']];
			}
		}
		return $list1;
	}

	/**
	 * @Title: getProcureMentExecutionExcelList
	 * @Description: todo(采购执行状况表导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-4-28
	 * @throws
	 */
	function getProcureMentExecutionExcelList($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'productname':
					$wh.=" and mis_product_code.name LIKE '%".$v."%'";
					break;
				case 'prodsize':
					$wh.=" and mis_product_code.prodsize LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT  COUNT(DISTINCT sub.id) AS 'count'
		FROM mis_purchase_applymas AS mas
		LEFT JOIN mis_purchase_applysub  AS sub ON mas.id = sub.masid
		LEFT JOIN mis_purchase_ordersub AS ordersub ON ordersub.asubid = sub.id
		LEFT JOIN mis_inventory_into_sub AS intosub ON intosub.ordersubid = ordersub.id
		LEFT JOIN mis_inventory_realinfo AS info ON info.prodid = sub.prodid
		LEFT JOIN mis_product_code AS product ON product.id =sub.prodid
		WHERE mas.auditState =3  $wh ";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) {
			$page=$total_pages;
		}
		$start = $limit*$page - $limit;
		if ($start<0) {
			$start = 0;
		}
		//申请数据
		$sql = "SELECT
		mis_purchase_applysub.id           AS 'apsubid',
		mis_product_code.id                AS 'productid',
		mis_product_code.code              AS 'productcode',
		mis_product_code.name              AS 'productname',
		mis_product_code.prodsize          AS 'prodsize',
		mis_purchase_applysub.unitid       AS 'unitid',
		mis_purchase_applysub.qty          AS 'apqty',
		mis_purchase_applysub.unitprice    AS 'apunitprice',
		mis_purchase_applysub.taxunitprice AS 'aptaxunitprice'
		FROM
		mis_purchase_applysub AS mis_purchase_applysub
		LEFT JOIN mis_purchase_applymas AS  mis_purchase_applymas ON mis_purchase_applymas.id = mis_purchase_applysub.masid
		JOIN mis_product_code AS mis_product_code ON mis_purchase_applysub.prodid = mis_product_code.id
		WHERE mis_purchase_applymas.auditState = 3 $wh ";

		$list1 = $this->query($sql);
		$apsubidlist = array();
		$orsubidlist = array();
		$productidlist = array();
		$listinfo = array();
		foreach ($list1 as $key =>$val) {
			$apsubidlist[] = $val['apsubid'];
			$productidlist[] = $val['productid'];
		}

		if ($apsubidlist) {
			//订购数据
			$apsubid = implode($apsubidlist,',');
			$sql2 ="SELECT
					mis_purchase_ordersub.asubid AS 'orasubid',
					mis_purchase_ordersub.id AS 'orsubid',
					mis_purchase_ordersub.qty AS 'orqty',
					mis_purchase_ordersub.unitid AS 'orunitid',
					mis_purchase_ordersub.unitprice AS 'orunitprice',
					mis_purchase_ordersub.taxunitprice AS 'ortaxunitprice'
					FROM mis_purchase_ordersub AS  mis_purchase_ordersub
					LEFT JOIN mis_purchase_ordermas AS mis_purchase_ordermas ON mis_purchase_ordermas.id = mis_purchase_ordersub.masid
					WHERE mis_purchase_ordermas.auditState = 3 and mis_purchase_ordersub.asubid in (".$apsubid.")";
			$list2 = $this->query($sql2);
			foreach ($list2 as $key => $val) {
				$orsubidlist[] = $val['orsubid'];
			}
			//库存量
			$productid = implode($productidlist,',');
			$sql4 = "SELECT prodid,qty,unitid FROM mis_inventory_realinfo WHERE prodid IN (".$productid.") AND STATUS = 1 ";
			$sql4 = "SELECT prodid,qty,unitid FROM mis_inventory_realinfo WHERE prodid IN (415,434,457,428,14,394) AND STATUS = 1 ";
			$list4 = $this->query($sql4);
			//转换单位并把相同的物资合并
			foreach ($list4 as $key => $val) {
				if (isset($val['qty']) && isset($val['unitid'])) {
					$list4[$key]['qty'] = getAfterExchangeQty($val['unitid'],$val['qty']);
				}
				$listinfo[$val['prodid']] += $list4[$key]['qty'];
			}
		}
		//入库数据
		if ($orsubidlist) {
			$orsubid = implode($orsubidlist,',');
			$sql3 = "SELECT
					mis_inventory_into_sub.ordersubid AS 'intoordersubid',
					mis_inventory_into_sub.qty          AS 'intoqty',
					mis_inventory_into_sub.unitid       AS 'intounitid',
					mis_inventory_into_sub.unitprice    AS 'intounitprice',
					mis_inventory_into_sub.taxunitprice AS 'intotaxunitprice'
					FROM
					mis_inventory_into_sub AS mis_inventory_into_sub
					LEFT JOIN mis_inventory_into_mas AS mis_inventory_into_mas ON mis_inventory_into_mas.id = mis_inventory_into_sub.masid
					WHERE mis_inventory_into_mas.auditState =3 and mis_inventory_into_sub.ordersubid in (".$orsubid.")";
			$list3 = $this->query($sql3);
		}
		foreach ($list3 as $key =>$val) {
			foreach ($list2 as $k => $v) {
				if($val['intoordersubid'] == $v['orsubid']) {
					$list2[$k] = array_merge($val,$v);
				}
			}
		}
		foreach ($list2 as $key =>$val) {
			foreach ($list1 as $k => $v) {
				if($val['orasubid'] == $v['apsubid']) {
					$list1[$k] = array_merge($val,$v);
				}
			}
		}
		//所有数量转成基本单位
		foreach ($list1 as $key =>$val) {
			//申请数量转换
			if (isset($val['unitid']) && isset($val['apqty'])) {
				$list1[$key]['apqty'] = getAfterExchangeQty($val['unitid'],$val['apqty']);
			}
			//订单数量转换
			if (isset($val['orunitid']) && isset($val['orqty'])) {
				$list1[$key]['orqty'] = getAfterExchangeQty($val['orunitid'],$val['orqty']);
			}
			//入库数量转换
			if (isset($val['intounitid']) && isset($val['intoqty'])) {
				$list1[$key]['intoqty'] = getAfterExchangeQty($val['intounitid'],$val['intoqty']);
			}
		}
		foreach ($list1 as $key => $val) {
			//申请数量格式化
			$list1[$key]['apqty'] = getDigits($val['apqty']);
			//加入库存数据
			if (isset($listinfo[$val['productid']])) {
				$list1[$key]['infoqty'] = getDigits($listinfo[$val['productid']]);
			} else {
				$list1[$key]['infoqty'] = 0;
			}
			//请购未执行数量 = 申请数量 - 订购数量
			$list1[$key]['notorderqty'] = getDigits($val['apqty'] - $val['orqty']);
			//请购未执行金额 = 请购未执行数量 * 订购不含税单价
			$list1[$key]['notorderunitprice'] = getDigits($list1[$key]['notorderqty'] * $val['orunitprice']);
			//请购未执行价税合计 = 请购未执行数量 * 订购含税单价
			$list1[$key]['notordertaxunitprice'] = getDigits($list1[$key]['notorderqty'] * $val['ortaxunitprice']);
			//订货未执行数量 = 申请数量 - 入库数量
			$list1[$key]['notintoqty'] = getDigits($val['apqty'] - $val['intoqty']);
			//订货未执行金额 = 订货未执行数量 * 入库不含税单价
			$list1[$key]['notintounitprice'] = getDigits($list1[$key]['notintoqty'] * $val['intounitprice']);
			//订货未执行价税合计 = 订货未执行数量 * 入库含税单价
			$list1[$key]['notintotaxunitprice'] = getDigits($list1[$key]['notintoqty'] * $val['intotaxunitprice']);
		}
		return $list1;
	}
	/**
	 * @Title: getMonthOutCollectExcelList
	 * @Description: todo(月苗出库汇总表导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-4-28
	 * @throws
	 */
	function getMonthOutCollectExcelList($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$datestr = strtotime($v);
					$begindate = strtotime(date('Y-m',$datestr));
					$enddate = strtotime(date('Y-m',strtotime('next month',$datestr)));
					$wh .= " AND mis_inventory_out_mas.handledate >= ".$begindate." AND mis_inventory_out_mas.handledate < ".$enddate;
					break;
				case 'collprojectname':
					$wh.=" and mis_sales_project.name LIKE '%".$v."%'";
					break;
				case 'collproductcode':
					$wh.=" and mis_product_code.code LIKE '%".$v."%'";
					break;
				case 'collproductname':
					$wh.=" and mis_product_code.name LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT COUNT(DISTINCT mis_inventory_out_sub.id) AS 'count'
		FROM mis_inventory_out_mas AS mis_inventory_out_mas
		RIGHT JOIN  mis_inventory_out_sub AS mis_inventory_out_sub ON mis_inventory_out_mas.id = mis_inventory_out_sub.masid
		LEFT JOIN mis_product_code AS mis_product_code ON mis_product_code.id = mis_inventory_out_sub.prodid
		LEFT JOIN mis_domain_type11 AS mis_domain_type11 ON mis_inventory_out_sub.id = mis_domain_type11.typeobjid AND mis_domain_type11.types = 2
		LEFT JOIN mis_sales_project mis_sales_project ON mis_domain_type11.content=mis_sales_project.id
		WHERE mis_inventory_out_mas.auditState =3 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		//加前缀 coll
		$sql = "SELECT DISTINCT
		mis_inventory_out_mas.id           AS 'collmasid',
		mis_sales_project.name             AS 'collprojectname',
		mis_inventory_out_sub.id           AS 'collsubid',
		mis_inventory_out_sub.prodid       AS 'colloutsubprodid',
		mis_product_code.name              AS 'collproductname',
		mis_product_code.code              AS 'collproductcode',
		mis_product_code.prodsize          AS 'collproductprodsize',
		mis_inventory_out_sub.unitid 	   AS 'colloutsubunitid',
		mis_product_code.baseunitid 	   AS 'collbaseunitid',
		mis_inventory_out_sub.qty 		   AS 'collqty',
		mis_inventory_out_sub.taxunitprice AS 'colltaxunitprice',
		mis_inventory_out_sub.taxamount    AS 'colltaxamount',
		mis_inventory_out_mas.orderno      AS 'collorderno',
		mis_inventory_out_mas.handledate   AS 'collhandledate',
		mis_inventory_out_mas.remark 	   AS 'collremark'
		FROM mis_inventory_out_mas AS mis_inventory_out_mas
		RIGHT JOIN  mis_inventory_out_sub AS mis_inventory_out_sub ON mis_inventory_out_mas.id = mis_inventory_out_sub.masid
		LEFT JOIN mis_product_code AS mis_product_code ON mis_product_code.id = mis_inventory_out_sub.prodid
		LEFT JOIN mis_domain_type11 AS mis_domain_type11 ON mis_inventory_out_sub.id = mis_domain_type11.typeobjid AND mis_domain_type11.types = 2
		LEFT JOIN mis_sales_project mis_sales_project ON mis_domain_type11.content=mis_sales_project.id
		WHERE mis_inventory_out_mas.auditState =3 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$model = D("MisProductUnit");
		$unitlist = $model->where('status=1')->getField('id,name');
		foreach ($list1 as $key => $val) {
			//如果单位id为0,则为基本单位
			if(!$val['colloutsubunitid']){
				$val['colloutsubunitid'] = $val['collbaseunitid'];
			}
			//获得单位名称
			$list1[$key]['collunit'] = $unitlist[$val['colloutsubunitid']];
			//转换出仓日期
			$list1[$key]['collhandledate'] = $val['collhandledate'] ? date('Y-m-d',$val['collhandledate']) : '';
		}
		return $list1;
	}


	/**
	 * @Title: getSeedlingInventoryExcelList
	 * @Description: todo(苗木库存表导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-5-03
	 * @throws
	 */
	function getSeedlingInventoryExcelList($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'invproductcode':
					$wh.=" and mis_product_code.code LIKE '%".$v."%'";
					break;
				case 'invproductname':
					$wh.=" and mis_product_code.name LIKE '%".$v."%'";
					break;
				case 'invprotypename':
					$wh.=" and mis_product_type.name LIKE '%".$v."%'";
					break;
				case 'invprodindex':
					$wh.=" and mis_product_code.prodindex LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT COUNT(DISTINCT mis_inventory_realinfo.id) AS 'count'
		FROM
		mis_inventory_realinfo AS mis_inventory_realinfo
		LEFT JOIN mis_product_code AS mis_product_code ON mis_inventory_realinfo.prodid = mis_product_code.id
		LEFT JOIN mis_product_type AS mis_product_type ON mis_product_code.typeid = mis_product_type.id
		LEFT JOIN mis_product_nursery AS mis_product_nursery ON mis_product_nursery.prodid = mis_inventory_realinfo.prodid AND mis_product_nursery.usestatus =1
		WHERE 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) {
			$page=$total_pages;
		}
		$start = $limit*$page - $limit;
		if ($start<0) {
			$start = 0;
		}
		//加前缀 inv
		$sql = "SELECT
		mis_inventory_realinfo.id      AS 'invid',
		mis_product_code.code          AS 'invproductcode',
		mis_product_type.name          AS 'invprotypename',
		mis_product_type.id            AS 'invprotypeid',
		mis_product_code.name          AS 'invproductname',
		mis_product_code.prodindex     AS 'invprodindex',
		mis_inventory_realinfo.qty     AS 'invqty',
		mis_inventory_realinfo.unitid  AS 'invunitid',
		mis_product_code.baseunitid    AS 'invbaseunitid',
		mis_product_nursery.dbhheight  AS 'invdbhheight',
		mis_product_nursery.height     AS 'invheight',
		mis_product_nursery.poleheight AS 'invpoleheight',
		mis_product_nursery.canopy     AS 'invcanopy'
		FROM
		mis_inventory_realinfo AS mis_inventory_realinfo
		LEFT JOIN mis_product_code AS mis_product_code ON mis_inventory_realinfo.prodid = mis_product_code.id
		LEFT JOIN mis_product_type AS mis_product_type ON mis_product_code.typeid = mis_product_type.id
		LEFT JOIN mis_product_nursery AS mis_product_nursery ON mis_product_nursery.prodid = mis_inventory_realinfo.prodid AND mis_product_nursery.usestatus =1
		WHERE 1=1 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$model = D("MisProductUnit");
		$unitlist = $model->where('status=1')->getField('id,name');
		foreach ($list1 as $key => $val) {
			$list1[$key]['invqty'] = intval($val['invqty']);
			if ($val['invunitid']) {
				//如果单位id不为0,数量转换成基本单位下的数量
				$list1[$key]['invqty'] = getAfterExchangeQty($val['invunitid'],$val['invqty']);
			}
			//单位全部转换成基本单位
			$list1[$key]['invunit'] = $unitlist[$val['invbaseunitid']];
			//计算同品种的数量,并存放于数组 list
			$list[$val['invproductname']] += $val['invqty'];
			//计算同胸径的数量,并存放于数组 listdbhheight
			if ($val['invdbhheight']) {
				$listdbhheight[$val['invdbhheight']] += $val['invqty'];
			} else {
				$listdbhheight['invid'.$val['invid']] += $val['invqty'];
			}
		}
		//print_r($list);die;
		foreach ($list1 as $key => $val) {
			//同品种的数量
			$list1[$key]['invsameqty'] = $list[$val['invproductname']];
			//同胸径的数量
			if ($val['invdbhheight']) {
				$list1[$key]['invsamedbhheightqty'] = $listdbhheight[$val['invdbhheight']];
			} else {
				$list1[$key]['invsamedbhheightqty'] = $listdbhheight['invid'.$val['invid']];
			}
		}
		return $list1;
	}



	/**
	 * @Title: getReportIntoAccountExcelList
	 * @Description: todo(入库流水账导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-5-03
	 * @throws
	 */
	function getReportIntoAccountExcelList($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		count(DISTINCT mis_inventory_into_sub.id) AS 'count'
		FROM mis_inventory_into_mas
		LEFT JOIN mis_inventory_into_sub
		ON mis_inventory_into_mas.id = mis_inventory_into_sub.masid
		LEFT JOIN mis_inventory_warehouse
		ON mis_inventory_into_sub.whid = mis_inventory_warehouse.id
		LEFT JOIN mis_inventory_order_types
		ON mis_inventory_order_types.id = mis_inventory_into_mas.typeid
		LEFT JOIN USER
		ON user.id = mis_inventory_into_mas.userid
		LEFT JOIN mis_system_department
		ON mis_system_department.id = user.dept_id
		LEFT JOIN mis_purchase_ordersub
		ON mis_inventory_into_sub.ordersubid = mis_purchase_ordersub.id
		LEFT JOIN mis_purchase_supplier
		ON mis_purchase_supplier.id = mis_purchase_ordersub.supplierid
		LEFT JOIN  mis_product_code
		ON mis_product_code.id = mis_inventory_into_sub.prodid
		where 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_inventory_into_mas.handledate AS 'indate',
		mis_inventory_into_mas.rtype      AS 'inreceiptstype',
		mis_inventory_into_mas.orderno       AS 'inreceiptsno',
		mis_inventory_warehouse.name      AS 'inwarehouse',
		mis_order_types.name    AS 'inreceivetype',
		mis_system_department.name        AS 'indepname',
		USER.name                         AS 'inclerk',
		mis_purchase_supplier.name        AS 'insuppname',
		mis_inventory_into_mas.remark     AS 'inremark',
		mis_inventory_into_sub.createid AS 'increatename',
		mis_inventory_into_sub.updateid AS 'inupdatename',
		mis_inventory_into_sub.updatetime AS 'inupdatetime',
		mis_inventory_into_sub.prodid  AS 'prodid',
		mis_inventory_into_sub.id AS 'intosubid',
		mis_product_code.code  		AS 'inprodno',
		mis_product_code.name 		 AS 'inprodname',
		mis_product_code.prodsize  		 AS 'inprodsize',
		mis_inventory_into_sub.unitid 	 AS 'inunitid',
		mis_inventory_into_sub.qty 	 	AS 'intoqty',
		mis_inventory_into_sub.unitprice 	 AS 'intounitprice',
		mis_inventory_into_sub.amount 	 AS 'intoamount',
		mis_product_code.baseunitid			 AS 'intoproductbaseunitid'
		FROM mis_inventory_into_sub
		LEFT JOIN mis_inventory_into_mas
		ON mis_inventory_into_mas.id = mis_inventory_into_sub.masid
		LEFT JOIN mis_inventory_warehouse
		ON mis_inventory_into_sub.whid = mis_inventory_warehouse.id
		LEFT JOIN mis_order_types
		ON mis_order_types.id = mis_inventory_into_mas.typeid
		LEFT JOIN USER
		ON user.id = mis_inventory_into_mas.userid
		LEFT JOIN mis_system_department
		ON mis_system_department.id = user.dept_id
		LEFT JOIN mis_purchase_ordersub
		ON mis_inventory_into_sub.ordersubid = mis_purchase_ordersub.id
		LEFT JOIN mis_purchase_supplier
		ON mis_purchase_supplier.id = mis_purchase_ordersub.supplierid
		LEFT JOIN  mis_product_code
		ON mis_product_code.id = mis_inventory_into_sub.prodid
		WHERE 1=1 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$productunitmodel = D('MisProductUnit');
		//$intoproductunitlist =$productunitmodel->where('status=1')->getField('id,name');
		$usermodel=D('User');
		$intouserlist =$usermodel->where('status=1')->getField('id,name');
		$customermodel=D('MisSalesCustomer');
		$customerlist =$customermodel->where('status=1')->getField('id,name');
		$MisInventoryDomainModel =  D("MisInventoryDomain");
		$intodomainresult = $MisInventoryDomainModel->where("valuefield ='customerid' AND refertable='mis_sales_customer' AND TYPE='01'")->getField('id');
		foreach ($list1 as $key => $value) {
			//incustomname 客户名称 increatename 制单人 inupdatename 审核人   inupdatetime 审核时间 inunitid 单位
			if($list1[$key]['inupdatetime']){
				$list1[$key]['inupdatetime'] = date('Y-m-d',$value['inupdatetime']); //审核时间
			}else{
				$list1[$key]['inupdatetime'] ="";
			}
			if($list1[$key]['indate']){
				$list1[$key]['indate'] = date('Y-m-d',$value['indate']); //审核时间
			}else{
				$list1[$key]['indate'] ="";
			}
			// 			if ($value['inunitid'] == 0) {
			// 				//单位为采购单位
			// 				$list1[$key]['inunitid'] = $intoproductunitlist[$value['intoproductbaseunitid']];
			// 			}
			//主单位
			$list1[$key]['primary']=getUnitsNames($value['prodid']);
			//主单位数量
			$list1[$key]['primarycount']=getAfterExchangeFormatQty($value['inunitid'],$value['intoqty']);
			//采购单位
			$list1[$key]['inunitid']=getUnitsNames2($value['prodid']);
			$list1[$key]['increatename'] =  $intouserlist[$value['increatename']]; //制单人
			$list1[$key]['inupdatename'] =  $intouserlist[$value['inupdatename']]; //审核人
			//客户根据维度取出
			$domainsql=" SELECT content FROM mis_domain_type".$intodomainresult." WHERE  typeobjid ='".$value['intosubid']."' AND types='4' and status=1";
			$customerid=$this->query($domainsql);
			$list1[$key]['incustomname'] =  $customerlist[$value['$customerid']]; //客户名称
			if($list1[$key]['inreceiptstype']=="MisPurchaseOrdermas"){
				$list1[$key]['inreceiptstype']="采购入库单";
			}else{
				$list1[$key]['inreceiptstype']="其他入库单";
			}
		}
		return $list1;
	}

	/**
	 * @Title: getReportOutAccountExcelList
	 * @Description: todo(出库流水账导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-5-03
	 * @throws
	 */
	function getReportOutAccountExcelList($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		count(DISTINCT mis_inventory_out_mas.id) AS 'count'
		FROM mis_inventory_out_mas
		LEFT JOIN mis_inventory_out_sub
		ON mis_inventory_out_mas.id = mis_inventory_out_sub.masid
		LEFT JOIN mis_inventory_warehouse
		ON mis_inventory_out_sub.whid = mis_inventory_warehouse.id
		LEFT JOIN mis_inventory_order_types
		ON mis_inventory_order_types.id = mis_inventory_out_mas.typeid
		LEFT JOIN USER
		ON user.id = mis_inventory_out_mas.userid
		LEFT JOIN mis_system_department
		ON mis_system_department.id = user.dept_id
		LEFT JOIN mis_purchase_ordersub
		ON mis_inventory_out_sub.ordersubid = mis_purchase_ordersub.id
		LEFT JOIN mis_purchase_supplier
		ON mis_purchase_supplier.id = mis_purchase_ordersub.supplierid
		LEFT JOIN  mis_product_code
		ON mis_product_code.id = mis_inventory_out_sub.prodid
		where 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_inventory_out_mas.handledate AS 'outdate',
		mis_inventory_out_mas.rtype      AS 'outreceiptstype',
		mis_inventory_out_mas.orderno       AS 'outreceiptsno',
		mis_inventory_warehouse.name      AS 'outwarehouse',
		mis_inventory_order_types.name    AS 'outreceivetype',
		mis_system_department.name        AS 'outdepname',
		USER.name                         AS 'outclerk',
		mis_purchase_supplier.name        AS 'outsuppname',
		mis_inventory_out_mas.remark     AS 'outremark',
		mis_inventory_out_sub.createid AS 'outcreatename',
		mis_inventory_out_sub.updateid AS 'outupdatename',
		mis_inventory_out_sub.updatetime AS 'outupdatetime',
		mis_inventory_out_sub.id AS 'outosubid',
		mis_product_code.code  		AS 'outprodno',
		mis_product_code.name 		 AS 'outprodname',
		mis_product_code.prodsize  		 AS 'outprodsize',
		mis_inventory_out_sub.unitid 	 AS 'outunitid',
		mis_inventory_out_sub.qty 	 	AS 'outoqty',
		mis_inventory_out_sub.unitprice 	 AS 'outounitprice',
		mis_inventory_out_sub.amount 	 AS 'outoamount',
		mis_product_code.baseunitid			 AS 'outoproductbaseunitid'
		FROM mis_inventory_out_mas
		LEFT JOIN mis_inventory_out_sub
		ON mis_inventory_out_mas.id = mis_inventory_out_sub.masid
		LEFT JOIN mis_inventory_warehouse
		ON mis_inventory_out_sub.whid = mis_inventory_warehouse.id
		LEFT JOIN mis_inventory_order_types
		ON mis_inventory_order_types.id = mis_inventory_out_mas.typeid
		LEFT JOIN USER
		ON user.id = mis_inventory_out_mas.userid
		LEFT JOIN mis_system_department
		ON mis_system_department.id = user.dept_id
		LEFT JOIN mis_purchase_ordersub
		ON mis_inventory_out_sub.ordersubid = mis_purchase_ordersub.id
		LEFT JOIN mis_purchase_supplier
		ON mis_purchase_supplier.id = mis_purchase_ordersub.supplierid
		LEFT JOIN  mis_product_code
		ON mis_product_code.id = mis_inventory_out_sub.prodid
		WHERE 1=1 $wh
		ORDER BY $sidx $sord ";
		//	LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$productunitmodel = D('MisProductUnit');
		$intoproductunitlist =$productunitmodel->where('status=1')->getField('id,name');
		$usermodel=D('User');
		$intouserlist =$usermodel->where('status=1')->getField('id,name');
		$customermodel=D('MisSalesCustomer');
		$customerlist =$customermodel->where('status=1')->getField('id,name');
		$MisInventoryDomainModel =  D("MisInventoryDomain");
		$intodomainresult = $MisInventoryDomainModel->where("valuefield ='customerid' AND refertable='mis_sales_customer' AND TYPE='01'")->getField('id');
		foreach ($list1 as $key => $value) {
			//incustomname 客户名称 increatename 制单人 inupdatename 审核人   inupdatetime 审核时间 inunitid 单位
			if($list1[$key]['outupdatetime']){
				$list1[$key]['outupdatetime'] = date('Y-m-d',$value['outupdatetime']); //审核时间
			}else{
				$list1[$key]['outupdatetime'] ="";
			}
			if($list1[$key]['outdate']){
				$list1[$key]['outdate'] = date('Y-m-d',$value['outdate']); //审核时间
			}else{
				$list1[$key]['outdate'] ="";
			}
			if ($value['outunitid'] == 0) {
				//单位为基本单位
				$list1[$key]['outunitid'] = $intoproductunitlist[$value['outoproductbaseunitid']];
			}
			$list1[$key]['outcreatename'] =  $intouserlist[$value['outcreatename']]; //制单人
			$list1[$key]['outupdatename'] =  $intouserlist[$value['outupdatename']]; //审核人
			//客户根据维度取出
			$domainsql=" SELECT content FROM mis_domain_type".$intodomainresult." WHERE  typeobjid ='".$value['outosubid']."' AND types='2' and status=1";
			$customerid=$this->query($domainsql);
			$list1[$key]['outcustomname'] =  $customerlist[$value['$customerid']]; //客户名称
			if($list1[$key]['outreceiptstype']=="MisSalesOrdermas"){
				$list1[$key]['outreceiptstype']="销售出库单";
			}else{
				$list1[$key]['outreceiptstype']="其他出库单";
			}
		}
		return $list1;
	}



	/**
	 * @Title: getReportStandcropExcelList
	 * @Description: todo(现存量查询导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-5-03
	 * @throws
	 */
	function getReportStandcropExcelList($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		count(DISTINCT mis_inventory_realinfo.id) AS 'count'
		FROM mis_inventory_realinfo
		LEFT JOIN mis_inventory_warehouse
		ON mis_inventory_realinfo.whid = mis_inventory_warehouse.id
		LEFT JOIN mis_product_code
		ON mis_inventory_realinfo.prodid = mis_product_code.id
		LEFT JOIN mis_product_type
		ON mis_product_code.typeid = mis_product_type.id
		WHERE 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_inventory_realinfo.id   AS 'standid',
		mis_inventory_realinfo.whid   AS 'standwhid',
		mis_inventory_warehouse.code   AS 'standwarehouseno',
		mis_inventory_warehouse.name   AS 'standwarehousename',
		mis_product_code.code          AS 'standprono',
		mis_product_code.id   AS 'standproid',
		mis_product_code.name          AS 'standproname',
		mis_product_code.prodsize      AS 'standprodsize',
		mis_product_type.code          AS 'standtypecode',
		mis_product_type.name          AS 'standtypename',
		mis_inventory_realinfo.unitid     AS 'standunitid',
		mis_product_code.baseunitid			 AS 'standproductbaseunitid',
		mis_inventory_realinfo.qty    AS 'standqtycount',
		mis_inventory_realinfo.areaid         AS 'standareaid',
		mis_inventory_realinfo.shelfid AS 'standshelfid'
		FROM mis_inventory_realinfo
		LEFT JOIN mis_inventory_warehouse
		ON mis_inventory_realinfo.whid = mis_inventory_warehouse.id
		LEFT JOIN mis_product_code
		ON mis_inventory_realinfo.prodid = mis_product_code.id
		LEFT JOIN mis_product_type
		ON mis_product_code.typeid = mis_product_type.id
		WHERE 1=1 $wh
		ORDER BY $sidx $sord ";
		//	LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$productunitmodel = D('MisProductUnit');
		$intoproductunitlist =$productunitmodel->where('status=1')->getField('id,name'); //基本单位数组
		$MisInventoryIntoSubModel=D('MisInventoryIntoSub');  //入库模型
		$MisInventoryOutSubModel=D('MisInventoryOutSub');	//出库模型
		foreach ($list1 as $key => $value) {
			if ($value['standunitid'] == 0) {
				//单位为基本单位
				$list1[$key]['standunitid'] = $intoproductunitlist[$value['standproductbaseunitid']];
			}
			$instansql="";
			if($value['standareaid']){
				$instansql.="  and mis_inventory_into_sub.areaid=".$value['standareaid']; //库区
			}
			if($value['standshelfid']){
				$instansql.="  and mis_inventory_into_sub.shelfid=".$value['standshelfid']; //库位
			}
			$instansql.=" and mis_inventory_into_sub.whid=".$value['standwhid']." and  mis_inventory_into_sub.prodid=".$value['standproid']; //仓库
			$outsql="";
			if($value['standareaid']){
				$outsql.="  and mis_inventory_out_sub.areaid=".$value['standareaid']; //库区
			}
			if($value['standshelfid']){
				$outsql.="  and mis_inventory_out_sub.shelfid=".$value['standshelfid']; //库位
			}
			$outsql.=" and mis_inventory_out_sub.whid=".$value['standwhid']." and  mis_inventory_out_sub.prodid=".$value['standproid']; //仓库
			//待入库数量
			$intosql="SELECT
					mis_inventory_into_sub.qty  as 'intoqty',
					mis_inventory_into_sub.id AS 'id'
					FROM mis_inventory_into_sub
					LEFT JOIN mis_inventory_into_mas
					ON mis_inventory_into_sub.masid = mis_inventory_into_mas.id
					WHERE mis_inventory_into_mas.auditState = 2  ".$instansql."  group by ('id') ";
			$intolist = $this->query($intosql);
			//待出库数量
			$outsql="SELECT
					mis_inventory_out_sub.qty AS 'outqty',
					mis_inventory_out_sub.id AS 'id'
					FROM mis_inventory_out_sub
					LEFT JOIN mis_inventory_out_mas
					ON mis_inventory_out_sub.masid = mis_inventory_out_mas.id
					LEFT JOIN mis_inventory_realinfo
					ON mis_inventory_realinfo.whid = mis_inventory_out_sub.whid
					WHERE mis_inventory_out_mas.auditState = 2  ".$outsql."  group by ('id') ";
			$outlist = $this->query($outsql);
			//人库数量累加
			$incount=0;
			foreach ($intolist as $key => $value){
				$incount+=$value['intoqty'];
			}
			//出库数量累加
			$outcount=0;
			foreach ($outlist as $key => $value){
				$outcount+=$value['outqty'];
			}
			// standqty 现存数量 （待入库数量 + 可用数量）   standqtycount 现存件数（qty字段） standareaid 库区   standshelfid 库位 standwhid 仓库
			// standintoqtycount 待入库数量（到货未入库数量+调拨未审核数量(调拨未完成  先取入库待审核数量)）
			// standoutoqtycount 待出库数量（销售发货单数量+调拨未审核的出库数量(先取出库待审核数量)）
			// standallqtycount  可用数量（现存件数-待出库数量）
			//可用数量
			$list1[$key]['standallqtycount']=$value['standqtycount']-$outcount;
			//现存数量
			$list1[$key]['standqty']=$incount+$value['standqtycount']-$outcount;
			// 待出库数量
			$list1[$key]['standoutoqtycount']=$outcount;
			// 待入库数量
			$list1[$key]['standintoqtycount']=$incount;
		}
		return $list1;
	}


	/**
	 * @Title: getSaleSvalueAnalysisExcel
	 * @Description: todo(客户增值分析导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-5-03
	 * @throws
	 */
	function getSaleSvalueAnalysisExcel($page,$limit,$sidx,$sord,$sarr){
		// 构造查询条件
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'id':
				case 'code':
				case 'name':
					$wh .= " AND msc.".$k." LIKE '%".$v."%'";
					break;
				case 'type':
					$wh .= " AND msct.name LIKE '%".$v."%'";
					break;
				case 'level':
					$wh .= " AND mcg.name LIKE '%".$v."%'";
					break;
				case 'area':
					$wh .= " AND mss.name LIKE '%".$v."%'";
					break;
				case 'industry':
					$wh .= " AND msc.intype LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT
		count('msc.id') AS 'count'
		FROM
		mis_sales_customer msc
		LEFT JOIN
		mis_sales_customertype msct ON msc.typeid = msct.id
		LEFT JOIN
		mis_customer_group mcg ON msc.groupid = mcg.id
		LEFT JOIN
		mis_sales_site mss ON msc.siteid = mss.id
		WHERE 1=1 $wh ";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql = "SELECT
		msc.id AS 'id',
		msc.code AS 'code',
		msc.name AS 'name',
		msct.name AS 'type',
		mcg.name AS 'level',
		mss.name AS 'area',
		msc.intype AS 'industry'
		FROM
		mis_sales_customer msc
		LEFT JOIN
		mis_sales_customertype msct ON msc.typeid = msct.id
		LEFT JOIN
		mis_customer_group mcg ON msc.groupid = mcg.id
		LEFT JOIN
		mis_sales_site mss ON msc.siteid = mss.id
		WHERE 1=1 $wh
		ORDER BY $sidx $sord ";
		//	LIMIT $start , $limit";
		$result = $this->query($sql);
		return $result;
	}

	/**
	 * @Title: getSalesOrderDetailExcelExcel
	 * @Description: todo(销售订单明细导出Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-5-03
	 * @throws
	 */
	function getSalesOrderDetailExcelExcel($page,$limit,$sidx,$sord){
		$sqlcount = "SELECT  count(msos.id) as counts
				FROM
				mis_sales_ordermas AS mso
				LEFT JOIN mis_sales_ordersub AS msos ON mso.id=msos.masid";
		$row = $this->query($sqlcount);
		$count = $row[0]['counts'];
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		msos.id AS id,mso.orderno AS orderno,msc.name AS cusname,FROM_UNIXTIME(mso.orderdate,'%Y-%m-%d') AS orderdate,FROM_UNIXTIME(mso.ddate,'%Y-%m-%d') ddate,
		mpt.name AS pdtypename,mpc.prodstyle AS pdstyle,mpc.prodtexture AS pdtextrue,mpc.prodsize AS pdsize,
		mpc.packspeci AS packspeci,mpu.name AS unite,mpc.weight AS weight,mpc.length AS length,mpc.wide AS wide,mpc.high AS high,
		mpc.prodcolor AS pdcolor,msos.qty AS qty,msos.amount AS amount, CASE msos.unoutqty WHEN '0' THEN '已出货'
		ELSE '未出货' END AS outstatus
		FROM
		mis_sales_ordermas AS mso
		LEFT JOIN mis_sales_ordersub AS msos ON mso.id=msos.masid
		LEFT JOIN mis_product_code AS mpc  ON msos.prodid = mpc.id
		LEFT JOIN mis_product_type AS mpt ON mpt.id=mpc.typeid
		LEFT JOIN mis_product_unit AS mpu ON  mpc.baseunitid=mpu.id
		LEFT JOIN mis_sales_customer AS msc ON msc.id=mso.customerid
		ORDER BY $sidx $sord ";
		//	LIMIT $start , $limit";
		$result = $this->query($sql);
		return $result;
	}

	/**
	 * @Title: getReportPurchaseOrderTrackingExcel
	 * @Description: todo(采购订单跟踪表Excel/PDF数据)
	 * @param int $page  当前页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param array $sarr 附加条件
	 * @return array
	 * @author jiangx
	 * @date 2013-5-07
	 * @throws
	 */
	function getReportPurchaseOrderTrackingExcel($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'mpcid':
					$wh .= " AND mis_purchase_ordermas.orderno LIKE '%".$v."%'";
					break;
				case 'ordernotname':
					$wh .= " AND mis_purchase_contractmas.orderno  LIKE '%".$v."%'";
					break;
				case 'cusname':
					$wh .= " AND mis_purchase_supplier.name LIKE '%".$v."%'";
					break;
				case 'pjname':
					$wh .= " AND mis_sales_project.name  LIKE '%".$v."%'";
					break;
				case 'salecontact':
					$wh .= " AND mis_sales_contractmas.code LIKE '%".$v."%'";
					break;
				case 'salecode':
					$wh .= " AND mis_product_code.name LIKE '%".$v."%'";
					break;
				case 'purcount':
					$wh .= " AND mis_purchase_ordersub.qty  =".$v;
					break;
				case 'purprice':
					$wh .= " AND mis_purchase_ordersub.unitprice  =".$v;
					break;
				case 'purmount':
					$wh .= " AND mis_purchase_ordersub.amount =".$v;
					break;
				case 'purtaxprice':
					$wh .= " AND mis_purchase_ordersub.taxunitprice =".$v;
					break;
				case 'purtaxmount':
					$wh .= " AND mis_purchase_ordersub.taxamount = ".$v;
					break;
				case 'purinqty':
					$wh .= " AND mis_purchase_ordersub.inqty LIKE =".$v;
					break;
				default:
					break;
			}
		}
		$sqlcount = " SELECT  count( mis_purchase_ordersub.id) AS 'count'
		FROM  mis_purchase_ordersub
		LEFT JOIN mis_purchase_ordermas
		ON mis_purchase_ordermas.id = mis_purchase_ordersub.masid
		LEFT JOIN mis_purchase_contractmas
		ON mis_purchase_ordermas.prcnoid = mis_purchase_contractmas.id
		LEFT JOIN mis_sales_customer
		ON mis_sales_customer.id = mis_purchase_ordersub.customerid
		LEFT JOIN mis_sales_project
		ON mis_sales_project.id = mis_purchase_ordersub.projectid
		LEFT JOIN mis_product_code
		ON mis_product_code.id = mis_purchase_ordersub.prodid
		LEFT JOIN mis_inventory_into_mas
		ON mis_inventory_into_mas.porderid = mis_purchase_ordermas.id
		LEFT JOIN mis_inventory_into_sub
		ON mis_inventory_into_sub.ordersubid = mis_purchase_ordersub.id
		LEFT JOIN mis_sales_contractmas
		ON mis_purchase_ordersub.sacnoid = mis_sales_contractmas.id
		WHERE 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT
		mis_purchase_ordermas.id           AS 'id',
		mis_purchase_ordermas.userid          AS 'uid',
		mis_purchase_ordermas.updatetime           AS 'purstatustime',
		mis_purchase_ordermas.orderno      AS 'mpcid',
		mis_purchase_contractmas.orderno   AS 'ordernotname',
		mis_sales_customer.name            AS 'cusname',
		mis_sales_project.name             AS 'pjname',
		mis_sales_contractmas.code			AS	'salecontact',
		mis_product_code.name              AS 'salecode',
		mis_purchase_ordersub.qty          AS 'purcount',
		mis_purchase_ordersub.inqty          AS 'purinqty',
		mis_purchase_ordersub.taxid          AS 'taxid',
		mis_purchase_ordersub.id          AS 'sibid',
		mis_purchase_ordersub.unitprice       AS 'purprice',
		mis_purchase_ordersub.amount       AS 'purmount',
		mis_purchase_ordersub.taxunitprice AS 'purtaxprice',
		mis_purchase_ordersub.taxamount       AS 'purtaxmount',
		mis_purchase_ordermas.auditState      AS 'purstatus',
		mis_purchase_ordersub.uninqty      AS 'uninqty',
		mis_purchase_ordersub.uninlockqty     AS 'uninlockqty'
		FROM  mis_purchase_ordersub
		LEFT JOIN mis_purchase_ordermas
		ON mis_purchase_ordermas.id = mis_purchase_ordersub.masid
		LEFT JOIN mis_purchase_contractmas
		ON mis_purchase_ordermas.prcnoid = mis_purchase_contractmas.id
		LEFT JOIN mis_sales_customer
		ON mis_sales_customer.id = mis_purchase_ordersub.customerid
		LEFT JOIN mis_sales_project
		ON mis_sales_project.id = mis_purchase_ordersub.projectid
		LEFT JOIN mis_product_code
		ON mis_product_code.id = mis_purchase_ordersub.prodid
		LEFT JOIN mis_sales_contractmas
		ON mis_purchase_ordersub.sacnoid = mis_sales_contractmas.id
		WHERE 1=1 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$usermodel=D('User');
		$userlist=$usermodel->where('status=1')->getField('id,name');
		$taxmodel=D('MisTaxGroup');
		$taxlist=$taxmodel->where('status=1')->getField('id,name');
		foreach ($list1 as $key => $value) {
			$list1[$key]['purstatus']=getAuditState($value['purstatus']);
			$list1[$key]['purintostatus']=getAuditState($value['purintostatus']);
			$list1[$key]['purintonocount']=$value['uninqty']-$value['uninlockqty'];
			$list1[$key]['username']=$userlist[$value['uid']];
			if($value['purstatustime']){
				$list1[$key]['purstatustime']= date('Y-m-d',$value['purstatustime']);
			}else{
				$list1[$key]['purstatustime']='';
			}
			if($value['taxid']){
				$list1[$key]['taxid']=$taxlist[$value['taxid']];
			}
			//含税金额总和放在$listtotal数组中
			$listtaxtotal[$value['mpcid']] += $value['purtaxmount'];
			//不含税含税金额总和放在$listtotal数组中
			$listtotal[$value['mpcid']] +=  $value['purmount'];
		}
		foreach ($list1 as $k => $row) {
			//含税金额总和
			$list1[$k]['purtaxmountall'] = $listtaxtotal[$row['mpcid']];
			$list1[$k]['purmountall'] = $listtotal[$row['mpcid']];
		}
		return $list1;
	}
	/**
	 * @Title: getReportProjectPersonExcel
	 * @Description: todo(项目人员汇总表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $wh
	 * @author renling
	 * @date 2013-5-7 下午3:54:21
	 * @throws
	 */
	public  function getReportProjectPersonExcel($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		count(DISTINCT mis_sales_project_user.id) AS 'count'
		FROM   mis_sales_project_user
		LEFT JOIN mis_sales_project
		ON mis_sales_project_user.projectid = mis_sales_project.id
		LEFT JOIN mis_sales_project_usertype
		ON mis_sales_project_usertype.id = mis_sales_project_user.typeid
		LEFT JOIN mis_hr_personnel_person_info
		ON mis_hr_personnel_person_info.id = mis_sales_project_user.uid
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id  where 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql = "SELECT
		mis_sales_project.name                 AS 'proname',
		mis_sales_project_usertype.name        AS 'dutyname',
		mis_hr_personnel_person_info.name      AS 'pername',
		mis_hr_personnel_person_info.dutyname  AS 'perduty',
		mis_system_department.name             AS 'perdep',
		mis_hr_personnel_person_info.id       AS 'perid',
		mis_hr_personnel_person_info.sex       AS 'persex',
		mis_hr_personnel_person_info.education AS 'peredu',
		mis_sales_project_user.begindate       AS 'proindate',
		mis_sales_project_user.enddate         AS 'proenddate',
		mis_sales_project_user.istransfer         AS 'proistran'
		FROM   mis_sales_project_user
		LEFT JOIN mis_sales_project
		ON mis_sales_project_user.projectid = mis_sales_project.id
		LEFT JOIN mis_sales_project_usertype
		ON mis_sales_project_usertype.id = mis_sales_project_user.typeid
		LEFT JOIN mis_hr_personnel_person_info
		ON mis_hr_personnel_person_info.id = mis_sales_project_user.uid
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE 1=1 $wh
		ORDER BY $sidx $sord
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		foreach ($list1 as $key => $value) {
			$list1[$key]['proindate'] = date('Y-m-d',$value['proindate']);
			if($value['proenddate']){
				$list1[$key]['proenddate'] = date('Y-m-d',$value['proenddate']);
			}else{
				$list1[$key]['proenddate']='';
			}
			$list1[$key]['persex']=$value['persex']==1?'男':'女';
			$list1[$key]['proistran']=$value['proistran']==0?"不可调动":$value['proistran']==1?"可调动":'已离开';
		}
		return $list1;

	}
	/**
	 * @Title: getReportProjectPersonnelExcel
	 * @Description: todo(单个人员信息表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $wh
	 * @author renling
	 * @date 2013-5-7 下午4:47:00
	 * @throws
	 */
	public  function getReportProjectPersonnelExcel($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT
		count(DISTINCT mis_sales_project_user.id) AS 'count'
		FROM   mis_sales_project_user
		LEFT JOIN mis_sales_project
		ON mis_sales_project_user.projectid = mis_sales_project.id
		LEFT JOIN mis_sales_project_usertype
		ON mis_sales_project_usertype.id = mis_sales_project_user.typeid
		LEFT JOIN mis_hr_personnel_person_info
		ON mis_hr_personnel_person_info.id = mis_sales_project_user.uid
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id  where 1=1 $wh";
		$row = $this->query($sqlcount);
		$count = $row[0]['count'];
		if( $count > 0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id       AS 'perid',
		mis_hr_personnel_person_info.name      AS 'personname',
		mis_sales_project.name                 AS 'perduty',
		mis_sales_project_usertype.name        AS 'dutyname',
		mis_sales_project_user.begindate       AS 'begindate',
		mis_sales_project_user.enddate         AS 'enddate',
		mis_sales_project_user.istransfer         AS 'iscondition'
		FROM   mis_sales_project_user
		LEFT JOIN mis_sales_project
		ON mis_sales_project_user.projectid = mis_sales_project.id
		LEFT JOIN mis_sales_project_usertype
		ON mis_sales_project_usertype.id = mis_sales_project_user.typeid
		LEFT JOIN mis_hr_personnel_person_info
		ON mis_hr_personnel_person_info.id = mis_sales_project_user.uid
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE 1=1 $wh
		LIMIT $start , $limit";
		$list1 = $this->query($sql);
		foreach ($list1 as $key => $value) {
			$list1[$key]['begindate'] = date('Y-m-d',$value['begindate']);
			if($value['enddate']){
				$list1[$key]['enddate'] = date('Y-m-d',$value['proenddate']);
			}else{
				$list1[$key]['enddate']='';
			}
			$list1[$key]['iscondition']=$value['iscondition']==0?"不可调动":$value['iscondition']==1?"可调动":'已离开';
		}
		return $list1;
	}
	/**
	 * @Title: getHrContractExtensionEport 
	 * @Description: todo(续约提醒报表导出) 
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author liminggang 
	 * @date 2013-7-24 下午12:02:37 
	 * @throws
	 */
	function getHrContractExtensionEport($page,$limit,$sidx,$sord,$sarr) {
		//部门表模型
		$MisSystemDepartmentModel=D('MisSystemDepartment');
		//查询提示状态为 0的部门ID 不提示
		$MisSystemDepartmentList=$MisSystemDepartmentModel->where(' isprompt=0 ')->getField('id,name');
		//获取一个月时间
		$time=time() + 2592000;
		//合同到期日期小于等于一个月
		$mapContract['delstatus']=1;
		$mapContract['status']=1;
		//人事合同模型
		$MisHrPersonnelPersonContractModel=D('MisHrPersonnelPersonContract');
		$MisHrPersonnelPersonContractList=$MisHrPersonnelPersonContractModel->where($mapContract)->group('personinfoid')->HAVING('MAX(enddate)<='.$time)->order('personinfoid')->getField('personinfoid,enddate,max(enddate)');
		//第一种情况，入职日期大于一个月，切没签合同的人员
		$MisHrPersonnelPersonInfoDAO=M('mis_hr_personnel_person_info');
		unset($map);
		//入职日期大于一个月
		$SignContract=$MisHrPersonnelPersonContractModel->where($mapContract)->getField('personinfoid,enddate');
		//$map['indate']=array('elt',$time);
		$map['working']=1; //职位状态 ：在职
		$map['id']=array('not in',array_unique(array_keys($SignContract)));
		$personidlist=$MisHrPersonnelPersonInfoDAO->where($map)->getField('id',true);
		$listarr=array_filter(array_merge(array_keys($MisHrPersonnelPersonContractList),$personidlist));
		unset($map);
		//第二种情况，签约合同人员合同到期时间小于一个月。
		if($MisHrPersonnelPersonContractList){
			$map['id']=array('in',$listarr);
		}
		//不在不提示部门的人员
		if($MisSystemDepartmentList!=null){
			$map['deptid']=array('not in',array_keys($MisSystemDepartmentList));
		}
		$idlist=implode(",",$listarr);
		$deptlist = implode(",",array_keys($MisSystemDepartmentList));
		$wh = " and mis_hr_personnel_person_info.id in (".$idlist.")";
		//不在不提示部门的人员
		if($MisSystemDepartmentList!=null){
			$wh .= " and mis_hr_personnel_person_info.deptid not in (".$deptlist.")";
		}
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id AS id
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		 $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id as id, orderno,mis_hr_personnel_person_info.name,
		deptid, dutyname,indate,
		mis_system_department.name   as deptname
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1 $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$val['nd'] = $key+1;
			$arr[$key]=$val;
			$arr[$key]['deptid'] = getFieldBy($val['deptid'],'id','name','mis_system_department');
			$arr[$key]['indate'] = transTime($val['indate']);
		}
		return $arr;
	}
	
	/**
	 * @Title: getReportPersonnelPositiveInfo 
	 * @Description: todo(转正提醒导出数据方法) 
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author liminggang 
	 * @date 2013-7-24 上午10:00:27 
	 * @throws
	 */
	function getHrPersonnelPositiveInfoEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		//转正模型
		$MisHrPersonnelPositiveInfoModel=D('MisHrPersonnelPositiveInfo');
		$positivestatusmap['status']=1;
		//查询已填写转正申请单人员
		$MisHrPersonnelPositiveInfoList=$MisHrPersonnelPositiveInfoModel->where($positivestatusmap)->getField('personid',true);
		//获取一个月时间
		$time=time() - 2592000;
		$polist=implode(",",$MisHrPersonnelPositiveInfoList);
		$wh = " and mis_hr_personnel_person_info.id not in (".$polist.") and mis_hr_personnel_person_info.indate <=".$time;
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate >= ".strtotime($v);
					break;
				case  'leavedate':
					$wh .= " AND mis_hr_personnel_person_info.indate  <= ".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id AS id
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_person_info.positivestatus = 0 $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id as id, orderno,mis_hr_personnel_person_info.name,
		deptid, dutyname,indate,
		mis_system_department.name   as deptname
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN  mis_system_department mis_system_department
		ON mis_hr_personnel_person_info.deptid=mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_person_info.positivestatus = 0  $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";

		$result = $this->query($sql);
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$val['nd'] = $key+1;
			$arr[$key]=$val;
			$arr[$key]['deptid'] = getFieldBy($val['deptid'],'id','name','mis_system_department');
			$arr[$key]['indate'] = transTime($val['indate']);
		}
		return $arr;
	}

	/**
	 * @Title: getHrIntroducerInfoEport
	 * @Description: todo(人事介绍人信息报表)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function getHrIntroducerInfoEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate =".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id AS id
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_introducer_info mis_hr_personnel_introducer_info
		ON mis_hr_personnel_introducer_info.personinfoid = mis_hr_personnel_person_info.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_introducer_info.status = 1  $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id as id, orderno,mis_hr_personnel_person_info.name,
		deptid, dutyname,indate,

		mis_hr_personnel_introducer_info.personinfoid               AS mis_hr_personnel_introducer_info_personid,
		mis_hr_personnel_introducer_info.name               AS mis_hr_personnel_introducer_info_name

		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_introducer_info mis_hr_personnel_introducer_info
		ON mis_hr_personnel_introducer_info.personinfoid = mis_hr_personnel_person_info.id
		WHERE mis_hr_personnel_person_info.working = 1 and mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_introducer_info.status = 1  $wh
		ORDER BY $sidx $sord LIMIT $start , $limit";

		$result = $this->query($sql);
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$val['nd'] = $key+1;
			$arr[$key]=$val;
			$arr[$key]['deptid'] = getFieldBy($val['deptid'],'id','name','mis_system_department');
			$arr[$key]['indate'] = transTime($val['indate']);
			//介绍人部门
			$arr[$key]['jsdeptname'] =getFieldBy(getFieldBy($val['mis_hr_personnel_introducer_info_personid'],'id','deptid','mis_hr_personnel_person_info'),'id','name','mis_system_department'); ;
			//介绍人职位
			$arr[$key]['jsdutyname'] = getFieldBy($val['mis_hr_personnel_introducer_info_personid'],'id','dutyname','mis_hr_personnel_person_info');
		}
		return $arr;
	}
	/**
	 * @Title: getHrPersonContractEport
	 * @Description: todo(合同签订情况报表)
	 * @param int $page  页数
	 * @param int $limit 每页显示条数
	 * @param string $sidx 排序字段
	 * @param menu(desc,asc) $sord  排序方式
	 * @param string $wh 附加查询条件
	 * @return string
	 * @author renlin
	 * @date 2013-4-22 下午9:40:14
	 * @throws
	 */
	function getHrPersonContractEport($page,$limit,$sidx,$sord,$sarr) {
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate =".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_person_contract mis_hr_personnel_person_contract
		ON mis_hr_personnel_person_contract.personinfoid = mis_hr_personnel_person_info.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_person_contract.delstatus = 1  $wh
		GROUP BY mis_hr_personnel_person_info.id";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id AS id, orderno,mis_hr_personnel_person_info.name,
		deptid,dutyname,indate,
		MAX(mis_hr_personnel_person_contract.enddate) AS mis_hr_personnel_person_contract_enddate,
		mis_hr_personnel_person_contract.remark AS mis_hr_personnel_person_contract_remark,
		mis_hr_personnel_person_contract.createtime AS mis_hr_personnel_person_contract_createtime,
		COUNT(*) AS counts
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_person_contract mis_hr_personnel_person_contract
		ON mis_hr_personnel_person_contract.personinfoid = mis_hr_personnel_person_info.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1
		and mis_hr_personnel_person_contract.delstatus = 1  $wh
		GROUP BY mis_hr_personnel_person_info.id
		ORDER BY $sidx $sord LIMIT $start , $limit";
		$result = $this->query($sql);
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$val['nd'] = $key+1;
			$arr[$key]=$val;
			$arr[$key]['deptid'] = getFieldBy($val['deptid'],'id','name','mis_system_department');
			$arr[$key]['indate'] = transTime($val['indate']);
			$arr[$key]['mis_hr_personnel_person_contract_enddate'] = transTime($val['mis_hr_personnel_person_contract_enddate']);
		}
		return $arr;
	}
	/**
	 * @Title: getHrinviteRereportExcel
	 * @Description: todo(人事招聘信息)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @author renling
	 * @date 2013-5-9 上午11:55:36
	 * @throws
	 */
	public function getHrinviteRereportExcel($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_invitere_form.name LIKE '%".$v."%'";
					break;
				case 'sex':
					if($v=='男'){
						$wh.=" and mis_hr_invitere_form.sex=1";
					}else{
						$wh.=" and mis_hr_invitere_form.sex=0";
					}
					break;
				case 'professional':
					$wh .= " AND mis_hr_invitere_form.professional LIKE '%".$v."%'";
					break;
				case 'nativeplace':
					$wh .= " AND mis_hr_invitere_form.nativeplace LIKE '%".$v."%'";
					break;
				case 'inviteresources':
					$wh .= " AND mis_hr_invitere_form.inviteresources =".$v;
					break;
				case 'interviewposition':
					$wh .= " AND mis_hr_invitere_form.interviewposition LIKE '%".$v."%'";
					break;
				case 'senioritypay':
					$wh .= " AND mis_hr_invitere_form.senioritypay LIKE '%".$v."%'";
					break;
				case 'contacttel':
					$wh .= " AND mis_hr_invitere_form.contacttel LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$model=D("MisHrInvitereForm");
		$count=$model->where("status=1 $wh")->count("*");
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT * FROM mis_hr_invitere_form WHERE status = 1 $wh  ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//重构数组
		$arr=array();
		foreach ($result as $ks=>$vs){
			$arr[$ks]=$vs;
			$arr[$ks]['sex']=$vs['sex']==1?'男':'女';
			$arr[$ks]['inviteresources']=getFieldBy($vs['inviteresources'], "id", "name", "mis_hr_typeinfo");
			$arr[$ks]['education']=getFieldBy($vs['education'], "id", "name", "mis_hr_typeinfo");
			$arr[$ks]['joinedtime']=transTime($vs['joinedtime']);
			$arr[$ks]['interviewtim']=transTime($vs['interviewtim']);
			$arr[$ks]['datetime']=transTime($vs['datetime']);
			if($vs['interviewagain']==0){
				$arr[$ks]['interviewagain']='不合格';
			}else if($vs['interviewagain']==1){
				$arr[$ks]['interviewagain']='合格';
			}else if($vs['interviewagain']==2){
				$arr[$ks]['interviewagain']='放入人才库';
			}else{
				$arr[$ks]['interviewagain']='待定';
			}
		}
		return $arr;
	}
	/**
	 * @Title: getHrProjectRecordsEport
	 * @Description: todo(所在项目)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @author renling
	 * @date 2013-5-9 下午5:41:31
	 * @throws
	 */
	public	function getHrProjectRecordsEport($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate =".strtotime($v);
					break;
				case 'mis_hr_personnel_project_records_projectname':
					$wh .= " AND mis_hr_personnel_project_records.projectname  LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_project_records_pjposition':
					$wh .= " AND mis_hr_personnel_project_records.pjposition LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_project_records_begindate':
					$wh .= " AND mis_hr_personnel_project_records.begindate =".strtotime($v);
					break;
				case 'mis_hr_personnel_project_records_enddate':
					$wh .= " AND mis_hr_personnel_project_records.enddate =".strtotime($v);
					break;
				case 'mis_hr_personnel_project_records_iscondition':
					if($v=="不可调动"){
						$wh .= " AND mis_hr_personnel_project_records.iscondition =0";
					}else if($v=="可调动"){
						$wh .= " AND mis_hr_personnel_project_records.iscondition =1";
					}else if($v=="已离开"){
						$wh .= " AND mis_hr_personnel_project_records.iscondition =2";
					}
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_project_records.id
		FROM mis_hr_personnel_project_records mis_hr_personnel_project_records
		LEFT JOIN   mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_project_records.uid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1
		AND mis_hr_personnel_person_info.status = 1    $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id              AS perid,
		mis_hr_personnel_person_info.name,
		dutyname,
		mis_hr_personnel_person_info.projectid,
		mis_hr_personnel_person_info.indate,
		mis_system_department.name                   AS deptid,
		mis_hr_personnel_project_records.projectid   AS mis_hr_personnel_project_records_projectid,
		mis_hr_personnel_project_records.projectname AS mis_hr_personnel_project_records_projectname,
		mis_hr_personnel_project_records.pjposition  AS mis_hr_personnel_project_records_pjposition,
		mis_hr_personnel_project_records.begindate   AS mis_hr_personnel_project_records_begindate,
		mis_hr_personnel_project_records.enddate     AS mis_hr_personnel_project_records_enddate,
		mis_hr_personnel_project_records.iscondition AS mis_hr_personnel_project_records_iscondition,
		mis_hr_personnel_project_records.remark      AS mis_hr_personnel_project_records_remark
		FROM mis_hr_personnel_project_records mis_hr_personnel_project_records
		LEFT JOIN   mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_project_records.uid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1
		AND mis_hr_personnel_person_info.status = 1    $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['mis_hr_personnel_project_records_begindate'] = transTime($val['mis_hr_personnel_project_records_begindate']);
			$arr[$key]['mis_hr_personnel_project_records_enddate'] = transTime($val['mis_hr_personnel_project_records_enddate']);
			$arr[$key]['mis_hr_personnel_project_records_iscondition'] = $select_config['iscondition']['iscondition'][$val['mis_hr_personnel_project_records_iscondition']];
			$arr[$key]['indate'] = transTime($val['indate']);
		}

		return $arr;
	}
	/**
	 * @Title: getHrPersonEducationEport
	 * @Description: todo(培训教育经历)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @author renling
	 * @date 2013-5-10 下午2:10:28
	 * @throws
	 */
	function getHrPersonEducationEport($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate =".strtotime($v);
					break;
				case 'mis_hr_personnel_education_info_school':
					$wh .= " AND mis_hr_personnel_education_info.school  LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_education_info_skillAndCertificate':
					$wh .= " AND mis_hr_personnel_education_info.skillAndCertificate LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_education_info_startDate':
					$wh .= " AND mis_hr_personnel_education_info.startDate =".strtotime($v);
					break;
				case 'mis_hr_personnel_education_info_finishDate':
					$wh .= " AND mis_hr_personnel_education_info_finishDate =".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_education_info.id
		FROM mis_hr_personnel_education_info mis_hr_personnel_education_info
		LEFT JOIN  mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_education_info.personinfoid = mis_hr_personnel_person_info.id

		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1  $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id AS perid,  mis_hr_personnel_person_info.name,dutyname, mis_hr_personnel_person_info.projectid, mis_hr_personnel_person_info.istransfer,
		mis_hr_personnel_person_info. indate,

		mis_system_department.name                   AS deptid,
		mis_hr_personnel_education_info.school              AS mis_hr_personnel_education_info_school,
		mis_hr_personnel_education_info.skillAndCertificate AS mis_hr_personnel_education_info_skillAndCertificate,
		mis_hr_personnel_education_info.startDate           AS mis_hr_personnel_education_info_startDate,
		mis_hr_personnel_education_info.finishDate          AS mis_hr_personnel_education_info_finishDate

		FROM mis_hr_personnel_education_info mis_hr_personnel_education_info
		LEFT JOIN  mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_education_info.personinfoid = mis_hr_personnel_person_info.id

		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1  $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['id']=$key+1;
			$arr[$key]['workkind'] = $select_config['workkind']['workkind'][$val['workkind']];
			$arr[$key]['positivestatus'] = $select_config['positivestatus']['positivestatus'][$val['positivestatus']];
			$arr[$key]['working'] = $select_config['working']['working'][$val['working']];
			$arr[$key]['indate'] = transTime($val['indate']);
			$arr[$key]['transferprobationdate'] = transTime($val['transferprobationdate']);
			$arr[$key]['transferdate'] = transTime($val['transferdate']);
			$arr[$key]['leavedate'] = transTime($val['leavedate']);
			$arr[$key]['dutylevelid'] = getFieldBy($val['dutylevelid'],'id','name','duty');
			$arr[$key]['mis_hr_personnel_education_info_startDate'] = transTime($val['mis_hr_personnel_education_info_startDate']);
			$arr[$key]['mis_hr_personnel_education_info_finishDate'] = transTime($val['mis_hr_personnel_education_info_finishDate']);
		}
		return $arr;
	}
	/**
	 * @Title: getHrPersonExperienceEport
	 * @Description: todo(工作经验)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @author renling
	 * @date 2013-5-10 下午3:11:00
	 * @throws
	 */
	function getHrPersonExperienceEport ($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate =".strtotime($v);
					break;
				case 'mis_hr_personnel_experience_info_company':
					$wh .= " AND mis_hr_personnel_experience_info.company  LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_experience_info_position':
					$wh .= " AND mis_hr_personnel_experience_info.position LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_experience_info_startdate':
					$wh .= " AND mis_hr_personnel_experience_info.startdate =".strtotime($v);
					break;
				case 'mis_hr_personnel_experience_info_finishdate':
					$wh .= " AND mis_hr_personnel_experience_info.finishdate =".strtotime($v);
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_experience_info.id
		FROM   mis_hr_personnel_experience_info mis_hr_personnel_experience_info
		LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_experience_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1  $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id AS perid,
		mis_hr_personnel_person_info.name,dutyname,   indate,
		mis_system_department.name as deptid,
		mis_hr_personnel_experience_info.company            AS mis_hr_personnel_experience_info_company,
		mis_hr_personnel_experience_info.position           AS mis_hr_personnel_experience_info_position,
		mis_hr_personnel_experience_info.startdate          AS mis_hr_personnel_experience_info_startdate,
		mis_hr_personnel_experience_info.finishdate         AS mis_hr_personnel_experience_info_finishdate,
		mis_hr_personnel_experience_info.remark             AS mis_hr_personnel_experience_info_remark

		FROM   mis_hr_personnel_experience_info mis_hr_personnel_experience_info
		LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_experience_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department
		ON mis_hr_personnel_person_info.deptid = mis_system_department.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1  $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['indate'] = transTime($val['indate']);
			$arr[$key]['mis_hr_personnel_experience_info_startdate'] = transTime($val['mis_hr_personnel_experience_info_startdate']);
			$arr[$key]['mis_hr_personnel_experience_info_finishdate'] = transTime($val['mis_hr_personnel_experience_info_finishdate']);
		}
		return $arr;
	}
	/**
	 * @Title: getHrPersonFamilyEport
	 * @Description: todo(家庭成员报表)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @author renling
	 * @date 2013-5-10 下午3:55:37
	 * @throws
	 */
	function getHrPersonFamilyEport($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'name':
					$wh.=" and mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname LIKE '%".$v."%'";
					break;
				case 'deptname':
					$wh .= " AND mis_system_department.name LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate =".strtotime($v);
					break;
				case 'mis_hr_personnel_family_info_name':
					$wh .= " AND mis_hr_personnel_family_info.name  LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_experience_info_position':
					$wh .= " AND mis_hr_personnel_experience_info.position LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_family_info_relation':
					$wh .= " AND mis_hr_personnel_family_info.relation LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_family_info_company':
					$wh .= " AND mis_hr_personnel_family_info.company   LIKE '%".$v."%'";
					break;
				case 'mis_hr_personnel_family_info_telephone':
					$wh .= " AND mis_hr_personnel_family_info.telephone  LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		mis_hr_personnel_person_info.id
		FROM   mis_hr_personnel_family_info mis_hr_personnel_family_info
		LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_family_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department mis_system_department
		ON mis_system_department.id = mis_hr_personnel_person_info.deptid
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1 $wh";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id AS perid, mis_hr_personnel_person_info.name,
		deptid, dutyname,   mis_hr_personnel_person_info.indate,
		mis_system_department.name                   AS deptname,
		mis_hr_personnel_family_info.relation               AS mis_hr_personnel_family_info_relation,
		mis_hr_personnel_family_info.name                   AS mis_hr_personnel_family_info_name,
		mis_hr_personnel_family_info.company                AS mis_hr_personnel_family_info_company,
		mis_hr_personnel_family_info.telephone              AS mis_hr_personnel_family_info_telephone
		FROM   mis_hr_personnel_family_info mis_hr_personnel_family_info
		LEFT JOIN mis_hr_personnel_person_info mis_hr_personnel_person_info
		ON mis_hr_personnel_family_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_system_department mis_system_department
		ON mis_system_department.id = mis_hr_personnel_person_info.deptid
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_info.status = 1 $wh
		ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			$arr[$key]['indate'] = transTime($val['indate']);
		}
		return $arr;
	}
	/**
	 * @Title: getHrPersonnelBasisEport
	 * @Description: todo(人事基本信息)
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @author renling
	 * @date 2013-5-14 下午2:14:10
	 * @throws
	 */
	function getHrPersonnelBasisEport($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'ordernoid':
					$wh.=" and mis_hr_personnel_person_info.id=".$v;
					break;
				case 'name':
					$wh .= " AND mis_hr_personnel_person_info.name LIKE '%".$v."%'";
					break;
				case 'deptid':
					$wh .= " AND mis_hr_personnel_person_info.deptid=".$v;
					break;
				case 'dutyname':
					$wh .= " AND mis_hr_personnel_person_info.dutyname ='".$v."'";
					break;
				case 'sex':
					$wh .= " AND mis_hr_personnel_person_info.sex=".$v;
					break;
				case 'workkid':
					$wh .= " AND mis_hr_personnel_person_info.workkind=".$v;
					break;
				case 'itemid':
					$wh .= " AND mis_hr_personnel_person_info.itemid LIKE '%".$v."%'";
					break;
				case 'indate':
					$wh .= " AND mis_hr_personnel_person_info.indate =".strtotime($v);
					break;
				case 'positivestatus':
					$wh .= " AND mis_hr_personnel_person_info.positivestatus =".$v;
					break;
				case 'phone':
					$wh .= " AND mis_hr_personnel_person_info.phone LIKE '%".$v."%'";
					break;
				default:
					break;
			}
		}
		$sqlcount ="SELECT
		COUNT(DISTINCT mis_hr_personnel_person_info.id)
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_education_info mis_hr_personnel_education_info
		ON mis_hr_personnel_education_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_experience_info mis_hr_personnel_experience_info
		ON mis_hr_personnel_experience_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_family_info mis_hr_personnel_family_info
		ON mis_hr_personnel_family_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_introducer_info mis_hr_personnel_introducer_info
		ON mis_hr_personnel_introducer_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_project_records mis_hr_personnel_project_records
		ON mis_hr_personnel_project_records.uid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_person_contract mis_hr_personnel_person_contract
		ON mis_hr_personnel_person_contract.personinfoid = mis_hr_personnel_person_info.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_contract.delstatus = 1
		AND mis_hr_personnel_person_contract.status = 1  $wh  GROUP  BY (mis_hr_personnel_person_info.id) ";
		$row = $this->query($sqlcount);
		$count = count($row);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT
		mis_hr_personnel_person_info.id, orderno,sex ,itemid, workkind, mis_hr_personnel_person_info.name,
		sex, birthday, native, politicsstatus, education, personcertificate, profession, dutylevelid,
		deptid, dutyname, mis_hr_personnel_person_info.projectid, mis_hr_personnel_person_info.istransfer,
		address, nativeaddress, mis_hr_personnel_person_info.school,
		email, chinaid, phone, indate, leavedate, transferprobationdate, transferdate, messagesource,
		infomationstatus, staffhandbook, staffcheck, working, positivestatus,
		mis_hr_personnel_education_info.school              AS mis_hr_personnel_education_info_school,
		mis_hr_personnel_education_info.skillAndCertificate AS mis_hr_personnel_education_info_skillAndCertificate,
		mis_hr_personnel_education_info.startDate           AS mis_hr_personnel_education_info_startDate,
		mis_hr_personnel_education_info.finishDate          AS mis_hr_personnel_education_info_finishDate,
		mis_hr_personnel_experience_info.company            AS mis_hr_personnel_experience_info_company,
		mis_hr_personnel_experience_info.position           AS mis_hr_personnel_experience_info_position,
		mis_hr_personnel_experience_info.telephone          AS mis_hr_personnel_experience_info_telephone,
		mis_hr_personnel_experience_info.startdate          AS mis_hr_personnel_experience_info_startdate,
		mis_hr_personnel_experience_info.finishdate         AS mis_hr_personnel_experience_info_finishdate,
		mis_hr_personnel_family_info.relation               AS mis_hr_personnel_family_info_relation,
		mis_hr_personnel_family_info.name                   AS mis_hr_personnel_family_info_name,
		mis_hr_personnel_family_info.company                AS mis_hr_personnel_family_info_company,
		mis_hr_personnel_family_info.telephone              AS mis_hr_personnel_family_info_telephone,
		mis_hr_personnel_introducer_info.name               AS mis_hr_personnel_introducer_info_name,
		mis_hr_personnel_introducer_info.relation           AS mis_hr_personnel_introducer_info_relation,
		mis_hr_personnel_introducer_info.telephone          AS mis_hr_personnel_introducer_info_telephone,

		mis_hr_personnel_project_records.projectid AS mis_hr_personnel_project_records_projectid,
		mis_hr_personnel_project_records.projectname AS mis_hr_personnel_project_records_projectname,

		mis_hr_personnel_project_records.pjposition AS mis_hr_personnel_project_records_pjposition,
		mis_hr_personnel_project_records.begindate AS mis_hr_personnel_project_records_begindate,
		mis_hr_personnel_project_records.enddate AS mis_hr_personnel_project_records_enddate,
		mis_hr_personnel_project_records.iscondition AS mis_hr_personnel_project_records_iscondition,
		mis_hr_personnel_project_records.remark AS mis_hr_personnel_project_records_remark,

		mis_hr_personnel_person_contract.agencyperson AS mis_hr_personnel_person_contract_agencyperson,
		mis_hr_personnel_person_contract.signdate AS mis_hr_personnel_person_contract_signdate,
		mis_hr_personnel_person_contract.enddate AS mis_hr_personnel_person_contract_enddate,
		mis_hr_personnel_person_contract.remark AS mis_hr_personnel_person_contract_remark,

		COUNT(DISTINCT mis_hr_personnel_person_info.id)
		FROM mis_hr_personnel_person_info mis_hr_personnel_person_info
		LEFT JOIN mis_hr_personnel_education_info mis_hr_personnel_education_info
		ON mis_hr_personnel_education_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_experience_info mis_hr_personnel_experience_info
		ON mis_hr_personnel_experience_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_family_info mis_hr_personnel_family_info
		ON mis_hr_personnel_family_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_introducer_info mis_hr_personnel_introducer_info
		ON mis_hr_personnel_introducer_info.personinfoid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_project_records mis_hr_personnel_project_records
		ON mis_hr_personnel_project_records.uid = mis_hr_personnel_person_info.id
		LEFT JOIN mis_hr_personnel_person_contract mis_hr_personnel_person_contract
		ON mis_hr_personnel_person_contract.personinfoid = mis_hr_personnel_person_info.id
		WHERE mis_hr_personnel_person_info.working = 1 AND mis_hr_personnel_person_contract.delstatus = 1
		AND mis_hr_personnel_person_contract.status = 1  $wh  GROUP  BY (mis_hr_personnel_person_info.id) ORDER BY $sidx $sord  LIMIT $start , $limit";
		$result = $this->query($sql);
		//重构数组
		$arr=array();
		//读取配置文件。
		$select_config = require DConfig_PATH."/System/selectlist.inc.php";
		//这里对数据进行转换。
		foreach($result as $key=>$val){
			$arr[$key]=$val;
			// 			$arr[$key]['sex'] = $select_config['sex'][$val['sex']];
			$arr[$key]['sex']=$val['sex']==1?'男':'女';
			$arr[$key]['workkind'] = $select_config['workkind']['workkind'][$val['workkind']];
			$arr[$key]['positivestatus'] = $select_config['positivestatus']['positivestatus'][$val['positivestatus']];
			$arr[$key]['mis_hr_personnel_project_records_iscondition'] = $select_config['iscondition']['iscondition'][$val['mis_hr_personnel_project_records_iscondition']];
			$arr[$key]['working'] = $select_config['working']['working'][$val['working']];
			$arr[$key]['deptid'] = getFieldBy($val['deptid'],'id','name','mis_system_department');
			$arr[$key]['indate'] = transTime($val['indate']);
			$arr[$key]['transferprobationdate'] = transTime($val['transferprobationdate']);
			$arr[$key]['transferdate'] = transTime($val['transferdate']);
			$arr[$key]['leavedate'] = transTime($val['leavedate']);
			$arr[$key]['mis_hr_personnel_education_info_startDate'] = transTime($val['mis_hr_personnel_education_info_startDate']);
			$arr[$key]['mis_hr_personnel_education_info_finishDate'] = transTime($val['mis_hr_personnel_education_info_finishDate']);
			$arr[$key]['mis_hr_personnel_experience_info_startdate'] = transTime($val['mis_hr_personnel_experience_info_startdate']);
			$arr[$key]['mis_hr_personnel_experience_info_finishdate'] = transTime($val['mis_hr_personnel_experience_info_finishdate']);
			$arr[$key]['mis_hr_personnel_project_records_begindate'] = transTime($val['mis_hr_personnel_project_records_begindate']);
			$arr[$key]['mis_hr_personnel_project_records_enddate'] = transTime($val['mis_hr_personnel_project_records_enddate']);
			$arr[$key]['mis_hr_personnel_person_contract_signdate'] = transTime($val['mis_hr_personnel_person_contract_signdate']);
			$arr[$key]['mis_hr_personnel_person_contract_enddate'] = transTime($val['mis_hr_personnel_person_contract_enddate']);
			$arr[$key]['dutylevelid'] = getFieldBy($val['dutylevelid'],'id','name','duty');
			$arr[$key]['mis_hr_personnel_person_contract_agencyperson'] = getFieldBy($val['mis_hr_personnel_person_contract_agencyperson'],'id','name','mis_hr_personnel_person_info');
		}
		return  $arr;
	}
}
?>