<?php
//Version 1.0
/**
 * 图形报表中心控制器
 * @author 杨东
 * @date 2012-10-31
 */
class ReportChartsAction extends CommonAction{
	public function index(){
		$reporttype = $_REQUEST['reporttype'];
		$this->assign("reporttype",$reporttype);
		$x = $_POST['xarr']?$_POST['xarr']:'name';
		$y = $_POST['yarr']?$_POST['yarr']:'qty';
		$series = $_POST['seriesarr']?$_POST['seriesarr']:'';
		$this->assign('x',$x);
		$this->assign('y',$y);
		$this->assign('series',$series);
		if ($series) {
			$selectlist = array(
					array('swf'=>'MSColumn2D','name'=>'2D柱图'),
					array('swf'=>'ScrollColumn2D','name'=>'滚动2D柱图'),
					array('swf'=>'StackedColumn2D','name'=>'堆叠2D柱图'),
					array('swf'=>'ScrollStackedColumn2D','name'=>'滚动堆叠2D柱图'),
					array('swf'=>'MSColumn3D','name'=>'3D柱图'),
					array('swf'=>'StackedColumn3D','name'=>'堆叠3D柱图'),
					array('swf'=>'MSLine','name'=>'线图'),
					array('swf'=>'ScrollLine2D','name'=>'滚动线图'),
					array('swf'=>'MSArea','name'=>'区域图'),
					array('swf'=>'ScrollArea2D','name'=>'滚动区域图'),
					array('swf'=>'StackedArea2D','name'=>'堆叠区域图'),
					array('swf'=>'MSBar2D','name'=>'2D条图'),
					array('swf'=>'StackedBar2D','name'=>'堆叠2D条图'),
					array('swf'=>'MSBar3D','name'=>'3D条图'),
					array('swf'=>'StackedBar3D','name'=>'堆叠3D条图')
			);
			$selected = "MSColumn3D";
		} else {
			$selectlist = array(
					array('swf'=>'Column2D','name'=>'2D柱图'),
					array('swf'=>'Column3D','name'=>'3D柱图'),
					array('swf'=>'Pie3D','name'=>'3D饼图'),
					array('swf'=>'Pie2D','name'=>'2D饼图'),
					array('swf'=>'Line','name'=>'线图'),
					array('swf'=>'Bar2D','name'=>'条图'),
					array('swf'=>'Area2D','name'=>'区域图'),
					array('swf'=>'Doughnut2D','name'=>'2D空心饼图'),
					array('swf'=>'Doughnut3D','name'=>'3D空心饼图')
			);
			$selected = "Column3D";
		}
		$this->assign('selected',$selected);
		$this->assign('selectlist',$selectlist);
		switch ($reporttype) {
			case 10:
				//销售未采购明细表
				$this->getSalesNotpurchaseList();
				$this->display();
				break;
		}
	}
	// 构造图形
	public function getCharts(){
		import('@.ORG.BaseCharts.Chart');
		$x = $_REQUEST['x'];
		$y = $_REQUEST['y'];
		$series = $_REQUEST['series'];
		$chartsModel = D('ReportCharts');
		//获取数据
		$data = $chartsModel->getSalesNotpurchaseList($x,$y,$series);
		//创建chart对象
		$chart = new Chart();
		// 默认参数
		$graphAttribute = array('useRoundEdges'=>'1');
		//调用方法进行设置
		$chart->setGraphAttribute($graphAttribute);
		//设置x坐标
		$chart->setX($x);
		//设置Y坐标
		$chart->setY($y);
		if ($series) {
			//设置系列
			$chart->setSeries($series);
			//生成图表
			$chart->builderChart(Chart::$MULTI_SERIES_CHARTS, $data);
		} else {
			//生成图表
			$chart->builderChart(Chart::$SINGLE_SERIES, $data );
		}
	}
	// 销售未采购明细表
	public function getSalesNotpurchaseList(){
		$xarr = array(array('code'=>'orderno','name'=>'销售订单号'),array('code'=>'code','name'=>'产品编码'),array('code'=>'name','name'=>'产品名称'));
		$yarr = array(array('code'=>'qty','name'=>'销售数量'));
		$seriesarr = array(array('code'=>'orderno','name'=>'销售订单号'),array('code'=>'name','name'=>'产品名称'));
		$this->assign("xarr",$xarr);
		$this->assign("yarr",$yarr);
		$this->assign("seriesarr",$seriesarr);
	}
}
?>
