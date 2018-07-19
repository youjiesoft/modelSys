<?php
//Version 1.0
/**
 * 报表中心控制器
 * @author 杨东
 * @date 2012-10-26
 */
class ReportCenterAction extends CommonAction{
	public function index(){
		$reporttype = $_REQUEST['reporttype'];
		if(!$reporttype){
			$reporttype = 1;
		}
		$this->assign("reporttype",$reporttype);
		if ($_REQUEST['listtype']) {
			$m = D('ReportSQL');
			$page = $_REQUEST['page']; // get the requested page
			$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
			$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
			$sord = $_REQUEST['sord'];
			$sarr = $_REQUEST;
			if(!$sidx) $sidx =1;
		} else {
			$m = $this;
		}
		switch ($reporttype) {
			case 1:
				//产品销售排名
				$this->getSalePaiMing();
				$this->display("salepm");
				break;
			case 2:
				// 客户增值分析
				if ($_REQUEST['listtype']) {
					echo $m->getCustomerValueAnalysis($page,$limit,$sidx,$sord,$sarr);
				} else {
					$m->getCustomerValueAnalysis();
					$m->display('general');//普通列表模板
				}
				break;
			case 3:
				// 订单进度明细表
				if ($_REQUEST['listtype']) {
					echo $m->getOrderProgressDetailed($page,$limit,$sidx,$sord,$wh);
				} else {
					$m->getOrderProgressDetailed();
					$m->display('foottotal');
				}
				break;
			case 5:
				//销售区域统计表
				$this->getSaleSiteStatistics();
				$this->display("saleSetname");
				break;
			case 7:
				//销售订单明细
				$this->getSalesOrderBOM();
				$this->display("index");
				break;
			case 8:
				//销售订单明细
				if ($_REQUEST['listtype']) {
					echo $m->getSalesOrderDeliveryStatistical($page,$limit,$sidx,$sord,$sarr);
				} else {
					$m->getSalesOrderDeliveryStatistical();
					$m->display("foottotal");//脚部汇总页面
				}
				break;
			case 9:
				//销售订单统计表
				if ($_REQUEST['listtype']) {
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
					echo $m->getSalesOrderStatistics($page,$limit,$sidx,$sord,$wh);
				} else {
					$m->getSalesOrderStatistics();
					$m->display('foottotal');
				}
				break;
			case 10:
				//销售未采购明细表
				if ($_REQUEST['listtype']) {
					echo $m->getSalesNotpurchaseList($page,$limit,$sidx,$sord,$sarr);
				} else {
					$m->getSalesNotpurchaseList();
					$m->display("foottotal");//脚部汇总页面
				}
				break;
			case 16:
				//人事招聘表
				if ($_REQUEST['listtype']) {
					echo $m->getHrpersonnelInvitere($page,$limit,$sidx,$sord,$sarr);
				} else {
					$m->getHrpersonnelInvitere();
					$m->display("foottotal");//脚部汇总页面
				}
				break;
				
		}
	}
	
	public function hrInviteRereport(){
		 $_REQUEST['reporttype']=16;
		$reporttype = $_REQUEST['reporttype'];
		$this->assign("reporttype",$reporttype);
		if ($_REQUEST['listtype']) {
			$m = D('ReportSQL');
			$page = $_REQUEST['page']; // get the requested page
			$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
			$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
			$sord = $_REQUEST['sord'];
			$sarr = $_REQUEST;
			if(!$sidx) $sidx =1;
		} else {
			$m = $this;
		}
		 
		if ($_REQUEST['listtype']) {
			echo $m->getHrpersonnelInvitere($page,$limit,$sidx,$sord,$sarr);
		} else {
			$m->getHrpersonnelInvitere();
			$m->display("foottotal");//脚部汇总页面
		}
	}
	
	/**
	 * 获取人事招聘信息
	 */
	public function getHrpersonnelInvitere(){
		$colNames = array(
				'编号','姓名','性别','年龄','学历','专业','籍贯','招聘渠道','预约时间','应聘岗位','工作年限','联系方式','面试时间','初试结果','复式结果','待入职时间'
		);
		$colModel = array(
				array('name'=>'id','index'=>'id','align'=>'center'),
				array('name'=>'name','index'=>'name','align'=>'center'),
				array('name'=>'sex','index'=>'sex','align'=>'center'),
				array('name'=>'age','index'=>'age','align'=>'center'),
				array('name'=>'education','index'=>'education','align'=>'center'),
				array('name'=>'professional','index'=>'professional','align'=>'center'),
				array('name'=>'nativeplace','index'=>'nativeplace','align'=>'center'),
				array('name'=>'inviteresources','index'=>'inviteresources','align'=>'center'),
				array('name'=>'datetime','index'=>'datetime','align'=>'center','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
				array('name'=>'interviewposition','index'=>'interviewposition','align'=>'center'),
				array('name'=>'senioritypay','index'=>'senioritypay','align'=>'center'),
				array('name'=>'contacttel','index'=>'contacttel','align'=>'center'),
				array('name'=>'interviewtim','index'=>'interviewtim','align'=>'center','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
				array('name'=>'accidentplace','index'=>'accidentplace','align'=>'center'),
				array('name'=>'interviewagain','index'=>'interviewagain','align'=>'center'),
				array('name'=>'joinedtime','index'=>'joinedtime','align'=>'center','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
		);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
// 		print_r($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}
	
	
	public function getReportList(){
		$model = D('ReportSQL');
		$page = $_REQUEST['page']; // get the requested page
		$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
		$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
		$sord = $_REQUEST['sord'];
		// 		echo '111111---->'.$_POST['listtype'];
		if(!$sidx) $sidx =1;
		switch ($_REQUEST['reporttype']) {
			case 1:
				echo $model->salePaiMing($page,$limit,$sidx,$sord);
				break;
			case 2:
				$wh = "";
				$sarr = $_REQUEST;
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
				echo $model->getCustomerValueAnalysis($page,$limit,$sidx,$sord,$wh);
				break;
			case 3:
				echo $model->getOrderProgressDetailed($page,$limit,$sidx,$sord);
				break;
			case 5:
				echo $model->saleSiteStatistics($page,$limit,$sidx,$sord);
				break;
			case 7:
				echo $model->salesOrderBOM($page,$limit,$sidx,$sord);
				break;
			case 8:
				// 销售订单出货统计表
				echo $model->getSalesOrderDeliveryStatistical($page,$limit,$sidx,$sord);
				break;
// 			case 16:
// 				// 销售订单出货统计表
// 				echo $model->getHrpersonnelInvitere($page,$limit,$sidx,$sord);
// 				break;
		}
	}
	// 客户增值分析
	public function getCustomerValueAnalysis(){
		$colNames = array('序号','客户编码', '客户名称', '客户类型','客户级别','地区','行业');
		$colModel = array(
				array('name'=>'id','index'=>'id','width'=>'45'),
				array('name'=>'code','index'=>'code'),
				array('name'=>'name','index'=>'name'),
				array('name'=>'type','index'=>'type'),
				array('name'=>'level','index'=>'level'),
				array('name'=>'area','index'=>'area'),
				array('name'=>'industry','index'=>'industry'),
		);
		$this->assign("colnamelist",$colNames);
		$this->assign("colmodellist",$colModel);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}
	// 销售订单出货统计表
	public function getSalesOrderDeliveryStatistical(){
		$colNames = array('序号','订单编号','客户名称','币别','金额','含税金额','下单日期','预交日期','出货日期','状态');
		$colModel = array(
				array('name'=>'id','index'=>'id','width'=>'45'),
				array('name'=>'orderno','index'=>'orderno'),
				array('name'=>'customer','index'=>'customer'),
				array('name'=>'currency','index'=>'currency'),
				array('name'=>'ioamount','index'=>'ioamount','width'=>110,'align'=>'right','formatter'=>'number'),
				array('name'=>'oamount','index'=>'oamount','width'=>110,'align'=>'right','formatter'=>'number'),
				array('name'=>'orderdate','index'=>'orderdate','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
				array('name'=>'ddate','index'=>'ddate','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
				array('name'=>'outtime','index'=>'outtime','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
				array('name'=>'status','index'=>'status'),
		);
		$this->assign("colnamelist",$colNames);
		$this->assign("colmodellist",$colModel);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}
	// 销售未采购明细表
	public function getSalesNotpurchaseList(){
		$colNames = array('序号','销售订单号','采购订单号','产品编码','产品名称','产品规格','单位','销售数量','已采购数量','未采购数量','库存仓数量','状态');
		$colModel = array(
				array('name'=>'id','index'=>'id','width'=>'45'),
				array('name'=>'orderno','index'=>'orderno'),
				array('name'=>'porderno','index'=>'porderno','sortable'=>false),
				array('name'=>'pcode','index'=>'pcode'),
				array('name'=>'pname','index'=>'pname'),
				array('name'=>'prodsize','index'=>'prodsize'),
				array('name'=>'unit','index'=>'unit'),
				array('name'=>'qty','index'=>'qty','width'=>110,'align'=>'right','formatter'=>'number'),
				array('name'=>'pqty','index'=>'pqty','width'=>110,'align'=>'right','formatter'=>'number','sortable'=>false),
				array('name'=>'nqty','index'=>'nqty','width'=>110,'align'=>'right','formatter'=>'number','sortable'=>false),
				array('name'=>'sqty','index'=>'sqty','width'=>110,'align'=>'right','formatter'=>'number','sortable'=>false),
				array('name'=>'status','index'=>'status'),
		);
// 		$this->assign("colnamelist",$colNames);
// 		$this->assign("colmodellist",$colModel);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}
/**
	 * 订单进度明细表
	 * 谢哲超
	 */
	public function getOrderProgressDetailed() {
		$colNames = array('序号','订单编号','客户名称','项目名称','数量','币别','订单金额','含税金额','下单日期','预交日期','出货日期','状态','产品类别','备注');
		$colModel = array(
			array('name'=>'id','index'=>'id','width'=>'45'),
			array('name'=>'orderno','index'=>'orderno'),
			array('name'=>'customer','index'=>'customer'),
			array('name'=>'project','index'=>'project'),
			array('name'=>'qty','index'=>'qty'),
			array('name'=>'currency','index'=>'currency'),
			array('name'=>'ioamount','index'=>'ioamount','align'=>'right','formatter'=>'number'),
			array('name'=>'oamount','index'=>'oamount','align'=>'right','formatter'=>'number'),
			array('name'=>'createtime','index'=>'createtime','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
			array('name'=>'ddate','index'=>'ddate','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
			array('name'=>'outtime','index'=>'outtime','formatter'=>"date",'formatoptions'=>array('srcformat'=>'u','newformat'=>'Y-m-d')),
			array('name'=>'status','index'=>'status'),
			array('name'=>'ptype','index'=>'ptype'),
			array('name'=>'remark','index'=>'remark')
		);
		$this->assign("colnamelist",$colNames);
		$this->assign("colmodellist",$colModel);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}

	/**
	 * 销售订单统计表
	 * 谢哲超
	 */
	public function getSalesOrderStatistics() {
		$colNames = array('序号','订单编号','客户名称','项目名称','主要产品','数量','订单金额','含税金额','出货状态');
		$colModel = array(
		array('name'=>'id','index'=>'id','width'=>'45'),
		array('name'=>'orderno','index'=>'orderno'),
		array('name'=>'customer','index'=>'customer'),
		array('name'=>'project','index'=>'project'),
		array('name'=>'ptype','index'=>'ptype'),
		array('name'=>'qty','index'=>'qty'),
		array('name'=>'ioamount','index'=>'ioamount','align'=>'right','formatter'=>'number'),
		array('name'=>'oamount','index'=>'oamount','align'=>'right','formatter'=>'number'),
		array('name'=>'status','index'=>'status')
		);
		$this->assign("colnamelist",$colNames);
		$this->assign("colmodellist",$colModel);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}


	public function test() {
		$page = $_GET['page']; // get the requested page
		$limit = $_GET['rows']; // get how many rows we want to have into the grid
		$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
		$sord = $_GET['sord']; // get the direction
		if(!$sidx) $sidx =1;
		// connect to the database
		$count = 3;
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		$list[] = array(
				'id'=>1,
				'invdate'=>'2012-10-26',
				'name'=>'test1',
				'amount'=>'1000',
				'tax'=>'10',
				'total'=>'1010',
				'note'=>'note1'
		);
		$list[] = array(
				'id'=>2,
				'invdate'=>'2012-10-26',
				'name'=>'test2',
				'amount'=>'2000',
				'tax'=>'20',
				'total'=>'2020',
				'note'=>'note2'
		);
		$list[] = array(
				'id'=>3,
				'invdate'=>'2012-10-26',
				'name'=>'test3',
				'amount'=>'3000',
				'tax'=>'30',
				'total'=>'3030',
				'note'=>'note3'
		);
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows=$list;
		echo json_encode($responce);
	}
	
	/**
	 * 产品销售排名
	 * @author 黎明刚
	 */
	public function getSalePaiMing(){
		//构造行标题
		$colNames = array(
				'产品编号','客户名称','WCP订单数量','WCP订单金额','客户名称1'
		);
		$colModel = array(
				array('name'=>'mpcid','align'=>'center','hidden'=>true),
				array('name'=>'ordernotname','align'=>'center'),
				array('name'=>'pname','align'=>'center','summaryType'=>'count', 'summaryTpl' => '订单数 ：{0} '),
				array('name'=>'oamount','align'=>'center','formatter'=>'number','summaryType'=>'sum', 'summaryTpl' => '订单金额 ：{0} '),
				array('name'=>'cusname','hidden'=>true),
		);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}
	/**
	 * 销售订单明细
	 * @author 黎明刚
	 */
	public function getSalesOrderBOM(){
		//构造行标题
		$colNames = array(
				'订单详情编号','订单编号','客户名称','下单日期','预出日期','产品类别','产品样式',
				'产品材质','产品规格','装包规格','单位','重量','长度','宽度','高度',
				'产品颜色','数量','金额','出货状态'
		);
		$colModel = array(
				array('name'=>'id','hidden'=>true),
				array('name'=>'msoid','width'=>'120'),
				array('name'=>'cusname'),
				array('name'=>'orderdate'),
				array('name'=>'ddate'),
				array('name'=>'pdtypename'),
				array('name'=>'pdstyle'),
				array('name'=>'pdtextrue'),
				array('name'=>'pdsize','formatter'=>'number'),
				array('name'=>'packspeci'),
				array('name'=>'unite'),
				array('name'=>'weight','formatter'=>'number'),
				array('name'=>'length','formatter'=>'number'),
				array('name'=>'wide','formatter'=>'number'),
				array('name'=>'high','formatter'=>'number'),
				array('name'=>'pdcolor'),
				array('name'=>'qty','formatter'=>'number'),
				array('name'=>'amount','formatter'=>'number'),
				array('name'=>'outstatus'),
		);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}
	/**
	 * 销售订单明细
	 * @author 黎明刚
	 */
	public function getSaleSiteStatistics(){
		//构造行标题
		$colNames = array(
				'订单编号','客户名称','WCP订单数量','WCP订单金额','销售区域'
		);
		$colModel = array(
				array('name'=>'id','align'=>'center','hidden'=>true),
				array('name'=>'codename','align'=>'center'),
				array('name'=>'num','align'=>'center','formatter'=>'int','summaryType'=>'sum', 'summaryTpl' => '订单数 ：{0} '),
				array('name'=>'oamount','align'=>'center','formatter'=>'number','summaryType'=>'sum', 'summaryTpl' => '订单金额 ：{0} '),
				array('name'=>'setname','hidden'=>true),
		);
		$colNames = json_encode($colNames);
		$colModel = json_encode($colModel);
		$this->assign("colNames",$colNames);
		$this->assign("colModel",$colModel);
	}
}
?>
