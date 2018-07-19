<?php
/**
 * @Title: ReportCarUsageModel 
 * @Package package_name
 * @Description: todo(车辆使用情况) 
 * @author renling 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-10-10 上午11:52:22 
 * @version V1.0
 */
class ReportCarUsageModel extends CommonModel{
	/**
	 * @Title: CarUsageList 
	 * @Description: todo(车辆使用情况 封装数据) 
	 * @param unknown_type $page
	 * @param unknown_type $limit
	 * @param unknown_type $sidx
	 * @param unknown_type $sord
	 * @param unknown_type $sarr
	 * @return string  
	 * @author renling 
	 * @date 2013-10-10 下午12:06:18 
	 * @throws
	 */
function CarUsageList($page,$limit,$sidx,$sord,$sarr){
		$wh = "";
		foreach( $sarr as $k=>$v) {
			$v = urldecode($v);
			switch ($k) {
				case 'collhandledate':
					//时间戳
					$v = $v.'-1'; //月开始时间  例如 2013-10-1 0：00:00
					$begindate = strtotime($v);
					$endtime = strtotime('next month', $begindate)-1;  //月结束时间 例如 2013-10-1 23：59:59
					$wh .= " AND  mis_request_car.departureTime >= ".$begindate." AND  mis_request_car.departureTime <= ".$endtime;
					break;
				default:
					break;
			}
		}
		$sqlcount = "SELECT COUNT( mis_system_car.id) AS 'count'
					FROM mis_system_car
					  LEFT JOIN mis_request_car
					    ON mis_request_car.carID = mis_system_car.id
					WHERE mis_system_car.status = 1 $wh";
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
		$sql = " SELECT  mis_system_car.id,
					  mis_system_car.carno      AS '车牌号',
					  mis_system_car.employeeID AS '责任驾驶人'
					FROM mis_request_car
					  LEFT JOIN mis_system_car
					    ON mis_request_car.carID = mis_system_car.id
					WHERE mis_system_car.status = 1
					GROUP BY (mis_system_car.id)  $wh
					ORDER BY $sidx $sord 
					LIMIT $start , $limit";
		$list1 = $this->query($sql);
		$model = D("MisProductUnit");
		$unitlist = $model->where('status=1')->getField('id,name');
		//加油记录模型
		$MisCarAddOilInfoModel=D('MisCarAddOilInfo');
		//维修模型
		$MisCarFixModel=D('MisCarFix');
		//交通事故
		$MisCarTrafficAccidentModel=D('MisCarTrafficAccident');
		$MisCarTrafficAccidentList=$MisCarTrafficAccidentModel->where(" status=1")->getField("id,carid");
		foreach ($list1 as $key => $val) {
		if($val['id']){
			if(in_array($val['id'], array_values($MisCarTrafficAccidentList))){
				$list1[$key]["IsAccident"]="有";
			}else{
				$list1[$key]["IsAccident"]="无";
			}
			//以下是维修部分封装数据
			//累计维修费
			$MisCarFixList=$MisCarFixModel->where(" carid=".$val['id']." and  status=1")->select();
			$accumulativeFixCount=count($MisCarFixList);
			foreach ($MisCarFixList as $fkey=>$fval){
			    if($fval['amount']){
			    	$sumFixAmountList[$val['id']]+=$fval['amount'];
			     }
			  }
			}
			//本月维修费用
			$sumFixInMonthAmount=0;
			$MisCarFixInmonthList=$MisCarFixModel->where(" status=1  AND  mis_car_fix.fixdate >= ".$begindate." AND  mis_car_fix.fixdate <= ".$endtime." and carid=".$val['id'])->select();
			$repairMonthCount=count($MisCarFixInmonthList);  //本月维修次数
			foreach ($MisCarFixInmonthList as $mkey=>$mval){
				$sumFixInMonthAmount+=$mval['amount'];
				//累加本月维修厂家
				if($mval['repaircompany']){
					$maintenanceFactoryList[$val['id']]+=$mval['repaircompany']."、";
				}
			}
			//以下是油料试用封装数据
			$MisCarAddOilInfoList=$MisCarAddOilInfoModel->where(" car_id=".$val['id']." and status=1")->select();
			foreach ($MisCarAddOilInfoList as $skey=>$sval){
				if($sval['amount']){
					$OilInfoCountSumList[$val['id']]+=$sval['amount'];
				}
			}
			//本月油料费
			$MisCarAddOilInfoInMonthList=$MisCarAddOilInfoModel->where(" status=1  AND  add_time >= ".$begindate." AND  add_time <= ".$endtime." and car_id=".$val['id'])->select();
			foreach ($MisCarAddOilInfoInMonthList as $Ikey=>$Ival){
				if($Ival['amount']){
					$OilInfoCountInMonthList[$val['id']]+=$Ival['amount'];
				}
			}
		}
		foreach ($list1 as $key => $val) {
			//累计维修费
			$list1[$key]['sumFixAmount'] = $sumFixAmountList[$val['id']];
			//本月维修费
			$list1[$key]['maintenanceFactory'] = $maintenanceFactoryList[$val['id']];
			//累计油料费   未完成部分
		}
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		$i=0;
		foreach ($list1 as $k => $row) {
		    $responce->rows[$i]['cell'] = 
			array(
					$row[collmasid],$row[collprojectname],
					$row[collproductcode],$row[collproductname],
					$row[collproductprodsize],$row[collunit],
					number_format($row[collqty]),$row[colltaxunitprice],
					$row[colltaxamount],$row[collorderno],
					$row[collhandledate],$row[collremark],$row[collremark] 
				);
		    $i++;
		}
		return json_encode($responce);
	}
}