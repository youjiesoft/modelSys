<?php
/**
 * @Title: file_name 
 * @Package package_name 
 * @Description: todo(报表SQL集合类) 
 * @author 杨东 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2012-10-23 下午9:38:56 
 * @version V1.0
 */
class ReportSQLModel extends CommonModel{
	/**
	 * 人事招聘统计报表
	 * @param int $page
	 * @param int $limit
	 * @param cloums $sidx
	 * @param unknown_type $sord
	 */
	function getHrpersonnelInvitere($page,$limit,$sidx,$sord,$sarr) {
		$model=D("MisHrInvitereForm");
		$count=$model->where("status=1")->count("*");
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start<0) $start = 0;
		$sql="SELECT * FROM mis_hr_invitere_form WHERE status=1 LIMIT $start , $limit";
		$result = $this->query($sql);
		//重构数组
		$arr=array();
		foreach ($result as $ks=>$vs){
			$arr[$ks]=$vs;
			$arr[$ks]['sex']=$vs['sex']==1?'男':'女';
			$arr[$ks]['inviteresources']=getFieldBy($vs['inviteresources'], "id", "name", "mis_hr_typeinfo");
			$arr[$ks]['education']=getFieldBy($vs['education'], "id", "name", "mis_hr_typeinfo");
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[id],$row[name],$row[sex],$row[age],$row[education],$row[professional],$row[nativeplace],$row[inviteresources],$row[datetime],$row[interviewposition],$row[senioritypay],$row[contacttel],$row[interviewtim],$row[accidentplace],$row[interviewagain],$row[joinedtime]);
				$i++;
		}
		return json_encode($responce);
	}
	/**
	 * 销售区域统计表
	 * UNIX_TIMESTAMP 时间戳函数，如果需要查询时间段，请传入时间参数
	 * @param int $page
	 * @param int $limit
	 * @param cloums $sidx
	 * @param unknown_type $sord
	 * @return unknown 以json格式的数据返回
	 * @author 黎明刚
	 */
	function  saleSiteStatistics($page,$limit,$sidx,$sord){
		$sqlcount ="SELECT mso.id AS id FROM mis_sales_ordermas AS mso
				LEFT JOIN mis_sales_customer AS msc ON mso.customerid=msc.id
				LEFT JOIN mis_sales_site AS mss ON mso.siteid=mss.id 
				GROUP BY mso.siteid , msc.code";
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
		$sql="SELECT mso.id AS id, msc.code AS code,msc.name AS name, 
				COUNT(msc.name) AS num, mso.orderno AS orderno, mso.ddate AS ddate,
				SUM(mso.oamount) AS oamount, mss.name AS setname FROM mis_sales_ordermas AS mso
				LEFT JOIN mis_sales_customer AS msc ON mso.customerid=msc.id
				LEFT JOIN mis_sales_site AS mss ON mso.siteid=mss.id GROUP BY mso.siteid , msc.code ORDER BY id LIMIT $start , $limit";
		$result = $this->query($sql);
		$arr=array();
		foreach($result as $k=>$v){
			$arr[$k]['id']=$v['id'];
			$arr[$k]['codename']=$v['code']."[".$v['name'];
			$arr[$k]['num']=$v['num'];
			$arr[$k]['oamount']=$v['oamount'];
			$arr[$k]['setname']=$v['setname'];
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $result;
		$i=0;
		foreach ($arr as $k => $row) {
			$responce->rows[$i]=$responce->rows[$i]['cell'] =
			array($row[id],$row[codename],$row[num],$row[oamount],$row[setname]);
			$i++;
		}
		return json_encode($responce);
	}
	/**
	 * 销售排名表（按销售类型）	
	 * UNIX_TIMESTAMP 时间戳函数，如果需要查询时间段，请传入时间参数
	 * @param int $page
	 * @param int $limit
	 * @param unknown_type $sidx 排序的字段
	 * @param unknown_type $sord 排序方式
	 * @return 以json格式的数据返回
	 * @author 黎明刚
	 */
	function  salePaiMing($page,$limit,$sidx,$sord){
		$sqlcount="SELECT  count(mso.id) AS count FROM  mis_sales_ordermas AS mso,mis_sales_ordersub AS msos, mis_product_code AS mpc,mis_sales_customer AS msc, mis_order_types AS mot
				 WHERE mso.id=msos.masid AND msos.prodid=mpc.id AND msc.id=mso.customerid AND mot.id=mso.typeid
					   ORDER BY mso.oamount DESC";
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
		$sql1="SELECT  
				 msos.id AS mpcid,mso.id AS id ,mso.orderno AS orderno , mso.percent AS percent,mso.oamount AS oamount,
				 mpc.name AS pname,  msc.id AS cusid,msc.name AS cusname, mot.name AS tname
			 FROM  mis_sales_ordermas AS mso,mis_sales_ordersub AS msos, mis_product_code AS mpc,mis_sales_customer AS msc, mis_order_types AS mot
			 WHERE
				 mso.id=msos.masid AND msos.prodid=mpc.id AND msc.id=mso.customerid AND mot.id=mso.typeid 
				 ORDER BY mso.oamount $sord 
				 LIMIT $start , $limit";
		$resut1=$this->query($sql1);
		$res=array();
		foreach($resut1 as $k=>$v){
			$res[$k]['mpcid'] =$v['mpcid'];
			$res[$k]['ordernotname']=$v['orderno']."[".$v['tname']."]";
			$res[$k]['oamount'] =$v['oamount'];
			$res[$k]['pname'] =$v['pname'];
			$res[$k]['cusid'] =$v['cusid'];
			$res[$k]['cusname'] =$v['cusname'];
		}
		$responce->page = $page; 
		$responce->total = $total_pages; 
		$responce->records = $count; 
		$i=0; $amttot=0; $taxtot=0; $total=0; 
		foreach ($res as $key => $row) {
			$responce->rows[$i]=$responce->rows[$i]['cell']=array(
				$row[mpcid],$row[ordernotname],$row[pname],$row[oamount],$row[cusname]
			);
			$i++;
		} 
		return json_encode($responce);
	}
	/**
	 * 销售订单产品明细表
	 * UNIX_TIMESTAMP 时间戳函数，如果需要查询时间段，请传入时间参数
	 * @param int $page  分页
	 * @param int $limit 已每页多少条显示
	 * @param unknown_type $sidx 字段名称
	 * @param unknown_type $sord 排序方式   DESC ASC
	 * @return 以json格式返回查询出来的数据
	 * @author 黎明刚
	 */
	function salesOrderBOM($page,$limit,$sidx,$sord){
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
				ORDER BY $sidx $sord
				LIMIT $start , $limit";
		$result = $this->query($sql);
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0;
	//	print_r($result);die;
		foreach ($result as $k => $row) {
			$responce->rows[$i]=$responce->rows[$i]['cell'] =
			array($row[id],$row[orderno],$row[cusname],$row[orderdate],$row[ddate],$row[pdtypename],$row[pdstyle],$row[pdtextrue],$row[pdsize]
					,$row[packspeci],$row[unite],$row[weight],$row[length],$row[wide],$row[high],$row[pdcolor],$row[qty],$row[amount],$row[outstatus]);
			$i++;
		}
		return json_encode($responce);
	}
	/**
	 * 产品分类统计表
	 * UNIX_TIMESTAMP 时间戳函数，如果需要查询时间段，请传入时间参数
	 * @param int $page  分页
	 * @param int $limit 已每页多少条显示
	 * @param unknown_type $sidx 字段名称
	 * @param unknown_type $sord 排序方式   DESC ASC
	 * @return 以json格式返回查询出来的数据
	 * @author 黎明刚
	 */
	function productClassification(){
		$sql="SELECT 
				mpt.id AS '类别编号',
				mpt.name AS '产品类别名称',	
				SUM(IFNULL(mpuex.exchange,1)*msos.qty) AS qty,
				ROUND(SUM(IFNULL(mpuex.exchange,1)*msos.amount*msos.subpercent/100),6) AS '折前金额',
				ROUND(SUM(IFNULL(mpuex.exchange,1)*msos.amount),6) AS '实际金额',
				ROUND(SUM(IFNULL(mpuex.exchange,1)*msos.amount)/SUM(IFNULL(mpuex.exchange,1)*msos.qty),2) AS '单价'	
			FROM 
				mis_sales_ordermas AS mso 
				LEFT JOIN mis_sales_ordersub AS msos ON  mso.id=msos.masid
				LEFT JOIN mis_product_unitexchange AS mpuex ON msos.unitid=mpuex.id
				LEFT JOIN mis_product_code AS mpc ON msos.prodid=mpc.id
				LEFT JOIN mis_product_type AS mpt ON mpc.typeid=mpt.id
			WHERE 
				mso.createtime BETWEEN UNIX_TIMESTAMP('2012-07-08') AND UNIX_TIMESTAMP()
				GROUP BY mpc.typeid";
		
		$result = $this->query($sql);
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$responce->rows = $result;
		return json_encode($responce);
	}
	
	/**
	 * 客户增值分析
	 * 杨东
	 * 2012-10-23
	 * */
	public function getCustomerValueAnalysis($page,$limit,$sidx,$sord,$sarr){
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
				ORDER BY $sidx $sord 
				LIMIT $start , $limit";
		$result = $this->query($sql);
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
// 		$i=0;
// 		foreach ($result as $k => $row) {
// 			$responce->rows[$i]['id']=$row[id];
// 			$responce->rows[$i]=$responce->rows[$i]['cell']=array($row[id],$row[code],$row[name],$row[type],$row[level],$row[area],$row[industry]);
// 			$i++;
// 		}
		$responce->rows = $result;
		return json_encode($responce);
	}
	/**
	 * 销售订单出货统计表
	 * 杨东
	 * 2012-10-23
	 * */
	public function getSalesOrderDeliveryStatistical($page,$limit,$sidx,$sord,$sarr){
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
						count(DISTINCT msom.id) AS 'count'
					FROM 
						mis_sales_ordermas msom
					LEFT JOIN 
						mis_inventory_out_mas miom ON msom.id = miom.sorderid AND miom.typeid = 6 
					LEFT JOIN 
						mis_sales_ordersub msos ON msos.`masid` = msom.`id` 
					LEFT JOIN 
						mis_sales_customer msc ON msom.customerid = msc.id 
					LEFT JOIN 
						mis_finance_currency mfc ON msom.currencyid = mfc.id
					WHERE miom.createtime IS NOT NULL $wh ";
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
					msom.id AS 'id',
					msom.orderno AS 'orderno',
					msc.name AS 'customer',
					mfc.code AS 'currency',
					msom.ioamount AS 'ioamount',
					msom.oamount AS 'oamount',
					msom.orderdate AS 'orderdate',
					msom.ddate AS 'ddate',
					miom.`createtime` AS 'outtime',
					msos.`ostatus` AS 'status'
				FROM 
					mis_sales_ordermas msom
				LEFT JOIN 
					mis_inventory_out_mas miom ON msom.id = miom.sorderid AND miom.typeid = 6 
				LEFT JOIN 
					mis_sales_ordersub msos ON msos.`masid` = msom.`id` 
				LEFT JOIN 
					mis_sales_customer msc ON msom.customerid = msc.id 
				LEFT JOIN 
					mis_finance_currency mfc ON msom.currencyid = mfc.id
				WHERE miom.createtime IS NOT NULL $wh 
				GROUP BY msom.id,msom.orderno,msc.name,mfc.code,msom.oamount,msom.orderdate,msom.ddate 
				ORDER BY $sidx $sord 
				LIMIT $start , $limit";
		$result = $this->query($sql);
		$outMas = D('MisInventoryOutMas');
		$salesSub = D('MisSalesOrdersub');
// 		foreach ($result as $k => $v) {
// 			//$result[$k]['outtime'] = $outMas->where('sorderid='.$v['id'])->order('createtime asc')->getField('createtime');
// 			$result[$k]['status'] = getTraceStatus($salesSub->where('masid='.$v['id'])->order('ostatus asc')->getField('ostatus'));
// 		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0; $ioamount=0;$oamount=0;
		foreach ($result as $k => $row) {
			$ioamount += $row[ioamount];
			$oamount += $row[oamount];
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] = 
			array($row[id],$row[orderno],$row[customer],$row[currency],$row[ioamount],$row[oamount],$row[orderdate],$row[ddate],$row[outtime],getTraceStatus($row[status]));
			$i++;
		}
		$responce->userdata['ioamount'] = $ioamount;
		$responce->userdata['oamount'] = $oamount;
		$responce->userdata['currency'] = 'Totals:';
		return json_encode($responce);
	}
	/**
	 * 销售未采购明细表
	 * 杨东
	 * 2012-10-25
	 * */
	public function getSalesNotpurchaseList($page,$limit,$sidx,$sord,$sarr) {
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
						count(msos.id) AS 'count'
					FROM 
						mis_sales_ordersub msos 
					LEFT JOIN 
						mis_sales_ordermas msom ON msos.masid = msom.id 
					LEFT JOIN 
						mis_product_code mpc ON msos.prodid = mpc.id 
					LEFT JOIN
						mis_product_unit AS mpu ON mpu.id = mpc.baseunitid 
					LEFT JOIN 
						mis_product_unitexchange mpuc ON mpuc.id = msos.unitid 
					WHERE 
						msom.ipapply = 1 AND msos.ostatus < 2 ";
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
					msom.id AS 'id',
					msom.orderno AS 'orderno',
					msom.sacnoid AS 'sacnoid',
					msom.customerid AS 'customerid',
					msom.projectid AS 'projectid',
					msos.prodid AS 'prodid',
					mpc.name AS 'pname',
					mpc.code AS 'pcode',
					mpc.prodsize AS 'prodsize',
					mpu.name AS 'unit',
					IFNULL(mpuc.exchange,1) * msos.qty AS 'qty',
					msos.ostatus AS 'status'
				FROM 
					mis_sales_ordersub msos 
				LEFT JOIN 
					mis_sales_ordermas msom ON msos.masid = msom.id 
				LEFT JOIN 
					mis_product_code mpc ON msos.prodid = mpc.id 
				LEFT JOIN
					mis_product_unit AS mpu ON mpu.id = mpc.baseunitid 
				LEFT JOIN 
					mis_product_unitexchange mpuc ON mpuc.id = msos.unitid 
				WHERE 
					msom.ipapply = 1 AND msos.ostatus < 2 
				ORDER BY $sidx $sord 
				LIMIT $start , $limit";
		$result = $this->query($sql);
		// 维度表
		$domainModel = D('MisInventoryDomain');
		//维度信息
		$domainMap['type']		= '01';
		$domainMap['status']	= '1';
		$domainMap['compare']	= '1'; // 是否比较
		$domainList		= $domainModel->where($domainMap)->select();
		// 默认仓库
		$whmodel = D('MisInventoryWarehouse');
		$whid = $whmodel->where('defaults = 1')->getField('id');
		$rivmap			= array();
		$action = A('Common');
		$rivmodel		= D("MisInventoryRealinfoView");
		$rivmodel->viewFields = $action->getDomainView("mis_inventory_realinfo",1,'01',array(),$rivmap);
		// 重新构造数据
		foreach ($result as $k => $v) {
			$sql2 = "SELECT 
						mpom.orderno AS 'porderno',
						IFNULL(mpuc.exchange,1) * mpom.qty AS 'pqty',
					FROM 
						mis_purchase_applysub mpas
					LEFT JOIN 
						mis_purchase_ordersub mpos ON mpas.id = mpos.asubid 
					LEFT JOIN 
						mis_purchase_ordermas mpom ON mpos.masid = mpom.id
					LEFT JOIN 
						mis_product_unitexchange mpuc ON mpuc.id = mpas.unitid 
					WHERE mpas.sordersubid = ".$v['id'];
			$result2 = $this->query($sql2);
			$pqty = 0;
			$arr = array();
			foreach ($result2 as $k2 => $v2) {
				$arr[] = $v2['porderno'];
				$pqty = $pqty+$v2['pqty'];
			}
			// 采购订单
			$result[$k]['porderno'] = implode(',', $arr);
			// 采购数量
			$result[$k]['pqty'] = $pqty;
			// 为采购数量
			$result[$k]['nqty'] = $v['qty'] - $pqty;
			// 获取默认仓库数量
			$rivmap['mis_inventory_realinfo.prodid'] = $v['prodid'];
			$rivmap['mis_inventory_realinfo.whid'] = $whid;
			foreach($domainList as $k2=>$v2 ){
				if ($v[$v2['valuefield']]) {
					$rivmap['d'.$v2['id'].'.content'] = $v[$v2['valuefield']];
				}
			}
			$doqty = $rivmodel->where($rivmap)->sum('doqty');
			if(!$doqty) $doqty = getDigits(0);
			$result[$k]['doqty'] = $doqty;
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0; $qty=0;$pqty=0;$nqty=0;
		foreach ($result as $k => $row) {
			$qty += $row[qty];
			$pqty += $row[pqty];
			$nqty += $row[nqty];
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] =
			array($row[id],$row[orderno],$row[porderno],$row[pcode],$row[pname],$row[prodsize],$row[unit],$row[qty],$row[pqty],$row[nqty],$row[doqty],getTraceStatus($row[status]));
			$i++;
		}
		$responce->userdata['qty'] = $qty;
		$responce->userdata['nqty'] = $nqty;
		$responce->userdata['pqty'] = $pqty;
		$responce->userdata['unit'] = 'Totals:';
		return $responce;
// 		return json_encode($responce);
	}
	
	/**
	 * 订单进度详细表
	 * 谢哲超
	 * 2012-10-23
	 * */
	public function getOrderProgressDetailed($page,$limit,$sidx,$sord,$wh) {
		$sqlcount = "SELECT  count(DISTINCT od.id) AS 'count'
						FROM mis_sales_ordermas AS od 
						LEFT JOIN mis_sales_customer customer ON od.customerid = customer.id 
						LEFT JOIN mis_finance_currency currency ON od.currencyid = currency.id
						LEFT JOIN mis_sales_ordersub sub ON od.id = sub.masid
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
						WHERE 1=1 $wh 
						ORDER BY $sidx $sord 
						LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$outMas = D('MisInventoryOutMas');
		$salesSub = D('MisSalesOrdersub');
		foreach ($list1 as $key => $value) {
			$list1[$key]['qty'] = $salesSub->where('masid='.$value['id'])->sum('qty');
			$list1[$key]['outtime'] = $outMas->where('sorderid='.$value['id'])->order('createtime asc')->getField('createtime');
			$list1[$key]['status'] = $salesSub->where('masid='.$value['id'])->order('ostatus asc')->getField('ostatus');
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
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0;
		foreach ($list1 as $k => $row) {
			$ioamount += $row[ioamount];
			$oamount += $row[oamount];
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] = 
				array($row[id],$row[orderno],$row[customer],$row[project],$row[qty],$row[currency],$row[ioamount],$row[oamount],$row[createtime],$row[ddate],$row[outtime],getTraceStatus($row[status]),$row[ptype],$row[remark]);
			$i++;
		}
		$responce->userdata['ioamount'] = $ioamount;
		$responce->userdata['oamount'] = $oamount;
		$responce->userdata['currency'] = 'Totals:';
		return json_encode($responce);
	}
	
	/**
	 * 销售订单统计表
	 * 谢哲超
	 * 2012-10-23
	 * */
	public function getSalesOrderStatistics($page,$limit,$sidx,$sord,$wh) {
		$sqlcount = "SELECT  count(DISTINCT od.id) AS 'count'
						FROM mis_sales_ordermas AS od 
						LEFT JOIN mis_sales_customer customer ON od.customerid = customer.id 
						LEFT JOIN mis_finance_currency currency ON od.currencyid = currency.id
						LEFT JOIN mis_sales_ordersub sub ON od.id = sub.masid
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
				WHERE 1=1 $wh 
				ORDER BY $sidx $sord 
				LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$salesSub = D('MisSalesOrdersub');
		foreach ($list1 as $key => $value) {
			$list1[$key]['qty'] = $salesSub->where('masid='.$value['id'])->sum('qty');
			$list1[$key]['status'] = $salesSub->where('masid='.$value['id'])->order('ostatus asc')->getField('ostatus');
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
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0;
		foreach ($list1 as $k => $row) {
			$ioamount += $row[ioamount];
			$oamount += $row[oamount];
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] = 
				array($row[id],$row[orderno],$row[customer],$row[project],$row[ptype],$row[qty],$row[ioamount],$row[oamount],getTraceStatus($row[status]));
			$i++;
		}
		$responce->userdata['ioamount'] = $ioamount;
		$responce->userdata['oamount'] = $oamount;
		$responce->userdata['qty'] = 'Totals:';
		return json_encode($responce);
	}
	/**
	 * @Title: getReportProjectPerson
	 * @Description: todo(采购订单统计表)
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
	public function reportpurchaseorderlist1($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT  COUNT(DISTINCT od.id) AS 'count'
					FROM mis_purchase_ordermas AS od 
					LEFT JOIN mis_purchase_contractmas contractmas ON od.prcnoid = contractmas.id
					LEFT JOIN mis_purchase_supplier supplier ON od.supplierid = supplier.id
					LEFT JOIN mis_sales_project project ON od.projectid = project.id
					LEFT JOIN mis_purchase_ordersub sub ON od.id = sub.masid
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
		
		$sql = "SELECT DISTINCT od.id AS 'id',
					od.orderno AS 'orderno',
					contractmas.orderno as 'contractmas_orderno',
					supplier.name as 'supplier_name',
					project.name AS 'project_name',
					od.ioamount AS 'ioamount',
					od.oamount AS 'oamount',
					sub.unitprice AS 'sub_unitprice',
					sub.taxunitprice AS 'sub_taxunitprice'
					FROM mis_purchase_ordermas AS od 
					LEFT JOIN mis_purchase_contractmas contractmas ON od.prcnoid = contractmas.id
					LEFT JOIN mis_purchase_supplier supplier ON od.supplierid = supplier.id
					LEFT JOIN mis_sales_project project ON od.projectid = project.id
					LEFT JOIN mis_purchase_ordersub sub ON od.id = sub.masid
					WHERE 1=1 $wh 
				ORDER BY $sidx $sord 
				LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$salesSub = D('MisPurchaseOrdersub');
		foreach ($list1 as $key => $value) {
			$list1[$key]['qty'] = $salesSub->where('masid='.$value['id'])->sum('qty');
			$list1[$key]['status'] = $salesSub->where('masid='.$value['id'])->order('ostatus asc')->getField('ostatus');
			$sql = "SELECT ptype.name AS 'ptype' FROM mis_purchase_ordermas od 
				LEFT JOIN mis_purchase_ordersub sub ON od.id = sub.masid 
				JOIN mis_product_code product ON sub.prodid = product.id 
				JOIN mis_product_type ptype ON product.typeid = ptype.id
				WHERE od.id =".$value["id"];
			$list3 = $this->query($sql);
			$length = count($list3);
			for ($i = 0; $i < $length; $i++) {
					$list1[$key]["ptype"] = $list3[$i]["ptype"];
					if($i < $length - 1) {
						$list1[$key]["ptype"] .= "|";
					}
			}
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0;
		foreach ($list1 as $k => $row) {
			$ioamount += $row[ioamount];
			$oamount += $row[oamount];
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] = 
				array($row[id],$row[orderno],$row[contractmas_orderno],$row[supplier_name],$row[project_name],$row[ptype],$row[qty],$row[sub_unitprice],$row[sub_taxunitprice],$row[ioamount],$row[oamount],getTraceStatus($row[status]));
			$i++;
		}
		$responce->userdata['ioamount'] = $ioamount;
		$responce->userdata['oamount'] = $oamount;
		$responce->userdata['qty'] = 'Totals:';
		return json_encode($responce);
	}
	
	/*
	 *物资申请跟踪表
	 */
	public function reportpurchaseorderlist($page,$limit,$sidx,$sord,$wh){
		$sqlcount = "SELECT  COUNT(DISTINCT od.id) AS 'count'
					FROM mis_project_material_application_mas AS od
					LEFT JOIN mis_sales_project project ON od.projectid = project.id
					LEFT JOIN mis_project_material_application_sub sub ON od.id = sub.masid
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
		
		$sql = "SELECT DISTINCT od.id AS 'id',
					od.orderno AS 'orderno',
					project.name AS 'project_name',
					sub.psize AS 'sub_psize',
					sub.goods AS 'sub_goods'
					FROM mis_project_material_application_mas AS od
					LEFT JOIN mis_sales_project project ON od.projectid = project.id
					LEFT JOIN mis_project_material_application_sub sub ON od.id = sub.masid
					WHERE 1=1 $wh 
				ORDER BY $sidx $sord 
				LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$materialSub = D('MisProjectMaterialApplicationSub');
		foreach ($list1 as $key => $value) {
			$list1[$key]['qty'] = $materialSub->where('masid='.$value['id'])->sum('qty');
			$list1[$key]['status'] = $materialSub->where('masid='.$value['id'])->order('ostatus asc')->getField('ostatus');
			$sql = "SELECT unit.name AS 'ptype' FROM mis_project_material_application_mas od 
					LEFT JOIN mis_project_material_application_sub sub ON od.id = sub.masid 
					JOIN mis_product_unit unit ON sub.baseunitid = unit.id 
					WHERE od.id =".$value["id"];
			$list3 = $this->query($sql);
			$length = count($list3);
			for ($i = 0; $i < $length; $i++) {
				$list1[$key]["ptype"] = $list3[$i]["ptype"];
			}
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0;
		foreach ($list1 as $k => $row) {
			$ioamount += $row[ioamount];
			$oamount += $row[oamount];
			$responce->rows[$i]['id'] = $row[id];
			$responce->rows[$i]['cell'] = 
				array($row[id],$row[orderno],$row[project_name],$row[sub_goods],$row[ptype],$row[qty],getTraceStatus($row[status]));
			$i++;
		}
		$responce->userdata['qty'] = 'Totals:';
		return json_encode($responce);
	}
}
?>