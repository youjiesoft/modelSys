<?php
/**
 *
 * @Title: ReportHrLeaveEmployeeAction
 * @Package package_name
 * @Description: todo(用一句话描述该类的作用)
 * @author renling
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2013-12-21 上午9:45:49
 * @version V1.0
 */
class ReportHrLeaveEmployeeAction extends CommonReportAction{
	/**
	 *
	 * @Title: lookuphrMonthEmployeesChart
	 * @Description: todo(这里用一句话描述这个方法的作用)
	 * @author renling
	 * @date 2013-12-19 下午5:56:05
	 * @throws
	 */
	public function lookupHrLeaveEmployeeChart(){
		//人事模型
		$MisHrBasicEmployeeModel=D('MisHrBasicEmployee');
		$MisSysDeptcountList=$MisHrBasicEmployeeModel->query("SELECT count(deptid) as count,deptid,mis_system_department.name AS 'name' FROM mis_hr_personnel_person_info  LEFT JOIN mis_system_department ON mis_system_department.id=mis_hr_personnel_person_info.deptid WHERE mis_hr_personnel_person_info.status=1 AND working=0 GROUP BY (deptid) ");
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
		//$xmlWriter->writeAttribute("caption", '截止目前各部门离职人数统计	【横坐标为部门，纵坐标为人数(人)】'); //面板颜色
		// 创建系列开始
		$xmlWriter->startElement("categories");
		//循环遍历创建
		foreach($MisSysDeptcountList as $key=>$val){
			$xmlWriter->startElement("category");
			$xmlWriter->writeAttribute("label",$val['name']);
			$xmlWriter->endElement();
		}
		$xmlWriter->endElement();
		// 系列创建完成 开始创建数据
		$xmlWriter->startElement("dataset");
		// $xmlWriter->writeAttribute("seriesName",$v['name']);
		//循环遍历创建 数据列表
		foreach($MisSysDeptcountList as $k1=>$v1){
			$xmlWriter->startElement("set");
			$xmlWriter->writeAttribute("value",$v1['count']);
			$xmlWriter->endElement();
		}
		$xmlWriter->endElement();
		$xmlWriter->endDocument();//结束XML
		$xmlWriter->flush();//输出XML对象
		unset($xmlWriter);//销毁XML对象
	}
}
