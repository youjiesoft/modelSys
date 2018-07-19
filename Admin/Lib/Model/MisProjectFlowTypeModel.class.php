<?php
/**
 * @Title: MisProjectFlowLinkModel 
 * @Package package_name 
 * @Description: 项目=》任务关联关系模型 
 * @author liminggang 
 * @company 重庆特米洛科技有限公司
 * @copyright 本文件归属于重庆特米洛科技有限公司
 * @date 2014-10-22 上午14:04:15 
 * @version V1.0
 */
class MisProjectFlowTypeModel extends CommonModel {
	protected $trueTableName = 'mis_project_flow_type';
	public function  getDeptCombox($projectid){
		//查询岗位
		$MisProjectFlowFormModel=D('MisProjectFlowForm');
		$where['status']=1;
		$where['projectid']=$projectid;
		$parentidList=$MisProjectFlowFormModel->where($where)->field("id,name,category,outlinelevel")->select();
		//	print_r($parentidList);
		$supcategoryList = $this->where($where)->field("id,name,parentid,outlinelevel")->select();
		//echo "<br/>**************************************************<br/>";
		//print_r($supcategoryList);
		//exit;
		foreach ($supcategoryList as $key=>$val){
			if($val['outlinelevel']==1){
				$newDeptList['supcategory'][]=array(
						'id'=>$val['id'],
						'name'=>$val['name'],
						'parentid'=>$val['parentid'],
				);
			}elseif($val['outlinelevel']==2){
				$newDeptList['category'][]=array(
						'id'=>$val['id'],
						'name'=>$val['name'],
						'parentid'=>$val['parentid'],
				);
			}
		}
		foreach ($parentidList as $jkey=>$jval){
			if($jval['outlinelevel']==3){
				$newDeptList['parentid'][]=array(
						'id'=>$jval['id'],
						'name'=>$jval['name'],
						'category'=>$jval['category'],
				);
			}
		}
		//print_r($newDeptList);
	
		return json_encode($newDeptList);
	}
	
}
?>