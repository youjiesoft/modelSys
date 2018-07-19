<?php 
/**
 * @Title: MisSalesProjectBasicTypeAction 
 * @Package package_name 
 * @Description: todo(项目类型维护控制器) 
 * @author liminggang 
 * @company Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @copyright 本文件归属于Aqo5Re65bSr5zG755m45t92YuQnZvNHbtRnL3d3d
 * @date 2014-2-13 下午2:25:05 
 * @version V1.0
 */
class MisSalesProjectBasicTypeAction extends MisOrderTypesCoreAction{
	
	public function _filter(&$map){
		 //列表过滤器，生成查询Map对象
		 $map = $this->_search ();
		 $map['status'] =array("egt",0);
		 // 获得类型ID
		 $typeid=$_REQUEST['typeid'];
		 if($typeid){
		 	$map['type'] = $typeid;
		 }
	}
	public function index(){
		//第一步，获取项目类型数据
		$misSalesProjectBasicTypeDao = M("mis_sales_project_basic_type");
		$tpMap['status'] = 1;
		$tplist=$misSalesProjectBasicTypeDao->where($tpMap)->select();
		foreach($tplist as $key=>$val){
			$tplist[$key]['parentid'] = 0;
			
		}
		$param['url'] = "";
		$param['rel'] = "misSalesProjectBasicType_left";
		
		$this->assign("tplist",$tplist);
		$this->getTree();
		//$typeid=$_REQUEST['typeid'];
		//$this->assign('typeid',$typeid);
		//$this->getSalesOrderTypes("MisSalesBasicTypeDivId", 2,"MisSalesBasicType");
		
		$this->display();
	}
}
?>