<?php
//Version 1.0
/**
 * 图形报表数据获取集合类
 * @author 杨东
 * @date 2012-10-31
 *
 */
class ReportChartsModel extends CommonModel{
	/**
	 * 销售未采购明细表
	 * 杨东
	 * 2012-10-25
	 * */
	public function getSalesNotpurchaseList($x,$y,$series) {
		switch ($x) {
			case 'code':
			case 'name':
				$xsql = 'mpc.'.$x.' AS '.$x;
				$gxsql = 'mpc.'.$x;
				break;
			case 'orderno':
				$xsql = 'msom.'.$x.' AS '.$x;
				$gxsql = 'msom.'.$x;
				break;
		}
		if ($xsql) $xsql .= ',';
		switch ($y) {
			case 'qty':
				$ysql = "SUM(IFNULL(mpuc.exchange,1) * msos.qty) AS 'qty'";
				break;
		}
		switch ($series) {
			case 'code':
			case 'name':
				$seriessql = 'mpc.'.$series.' AS '.$series;
				$gseriessql = 'mpc.'.$series;
				break;
			case 'orderno':
				$seriessql = 'msom.'.$series.' AS '.$series;
				$gseriessql = 'msom.'.$series;
				break;
		}
		if ($seriessql) $seriessql .= ',';
		if ($gseriessql) $gseriessql = ','.$gseriessql;
		$sql = "SELECT 
					$xsql $seriessql $ysql
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
				GROUP BY $gxsql $gseriessql ";
		$result = $this->query($sql);
		return $result;
	}
	
	
	/**
	 * 销售未采购明细表
	 * 黎明刚
	 * 2012-12-19
	 * */
	public function getSalesNotpurchaseList11($x,$y,$series) {
		switch ($x) {
			case 'code':
			case 'name':
				$xsql = 'mpc.'.$x.' AS '.$x;
				$gxsql = 'mpc.'.$x;
				break;
			case 'orderno':
				$xsql = 'msom.'.$x.' AS '.$x;
				$gxsql = 'msom.'.$x;
				break;
		}
		if ($xsql) $xsql .= ',';
		switch ($y) {
			case 'qty':
				$ysql = "SUM(IFNULL(mpuc.exchange,1) * msos.qty) AS 'qty'";
				break;
		}
		switch ($series) {
			case 'code':
			case 'name':
				$seriessql = 'mpc.'.$series.' AS '.$series;
				$gseriessql = 'mpc.'.$series;
				break;
			case 'orderno':
				$seriessql = 'msom.'.$series.' AS '.$series;
				$gseriessql = 'msom.'.$series;
				break;
		}
		if ($seriessql) $seriessql .= ',';
		if ($gseriessql) $gseriessql = ','.$gseriessql;
		$sql = "SELECT
		$xsql $seriessql $ysql
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
		GROUP BY $gxsql $gseriessql ";
		return $sql;
		$result = $this->query($sql);
		return $result;
	}
	
	public function getprojectanalysyList($projectid,$type){
		$sql='';
		switch ($type) {
			case 'cost':
				$sql .= "SELECT occurdate,budgetcost,quantities,occucost FROM mis_project_cost_analysis
					WHERE  projectid = ".$projectid." AND STATUS = 1 AND auditState = 3";
				break;
			case 'quality':
				$sql .= "SELECT `occurdate`,`svratewishmm`,`svraterealmm` FROM mis_project_quality_analysis
					WHERE projectid=".$projectid." AND STATUS =1 AND  auditstate=3 ORDER BY id ";
				break;
		}
		$result = $this->query($sql);
		return $result;
	}
}
?>