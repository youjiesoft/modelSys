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
class MisProjectFlowLinkModel extends MisSystemFlowLinkModel {
	protected $trueTableName = 'mis_project_flow_link';

	/**
	 * @Title: setLinkWork
	 * @Description: todo(增加一行新任务时重新对任务关联结构做变动)
	 * @param linkInfo当前任务节点信息，包含自身，前置节点的一维数组，
	 * linkInfo=array('id'=>'当前新增的任务节点'，'link'=>'被绑定任务节点')
	 *  $type类型 分为增加前置节点1,增加后置节点2，修改3，删除4， modelname是对哪个模型操作,有MisSystemFlowLink模板及MisProjectFlowLink项目实例
	 * @author yangxi
	 * @date 2014-10-21 上午11:00:00
	 * @throws
	 */
	function setLinkWork($linkid,$linkInfo,$type,$projectid=0){
		//$type=4;
		//实例化模型对象
	
		//$Model=D($model);
		$Model=D("MisProjectFlowLink");
		if($projectid!==0){
			$map['projectid']=$projectid;
		}
		switch ($type){
			case "1":
				//删除之前信息记录
				$map=array();
				$map['id']=$linkid;
				$map['projectid']=$projectid;
				$this->where($map)->delete();
				//插入前置信息
				$data=array();
				$data['id']            = $linkid;
				$data['projectid']     = $projectid;
				$data['predecessorid'] = $linkInfo;
				$this->add($data);
				break;
		}
/*****************************以下按标准任务处理，不实用，暂留存底******************************/
// 		switch ($type){
// 			case "1":
// 				//首先获取前后置任务列表
// 				$result=$this->getLinkWork($linkInfo['link']);
// 				//对$linkInfo['pro']做专置为数组
// 				//初始化一个空数组
// 				$predecessoridArr=array();
// 				$predecessoridArr=explode(',',$linkInfo['link']);
// 				$data=array();
// 				//执行事务
// 				$Model->startTrans();
// 				foreach ($predecessoridArr as $key => $val){
// 					//新数据的插入
// 					$data[$key]['id']=$linkInfo['id'];
// 					$data[$key]['predecessorid']=$val;
// 					$data[$key]['projectid']=$projectid;
// 					//如果存在节点
// 					if(!empty($result)){
// 						//如果有后置节点，替换后置节点
// 						foreach($result as $subkey=>$subval){
// 							if($subval[id]==$val){
// 								$data[$key]['successorid']=$subval['successorid'];
// 							}else{
// 								$data[$key]['successorid']=0;
// 							}
// 							//更新原节点的后置节点
// 							$map=array();
// 							$map['id']=$subval['id'];
// 							//重新设置successorid值
// 							$Model->where($map)->setField('successorid',$linkInfo['id']);
// 							//将前置节点为原节点值的节点更新为最新添加节点
// 							$map=array();
// 							$map['predecessorid']=$subval['id'];
// 							$Model->where($map)->setField('predecessorid',$linkInfo['id']);
// 						}
// 					}else{
// 						//如果存在节点
// 						//前置节点数据的插入
// 						foreach ($predecessoridArr as $key=> $val){
// 							$dataPre[$key]['id']=$val;
// 							$dataPre[$key]['successorid']=$linkInfo['id'];
// 							$dataPre[$key]['projectid']=$projectid;
// 						}
// 						$Model->addAll($dataPre);
// 					}
// 				}
// 				//插入数据
// 				$Model->addAll($data);
// 				//提交事务
// 				$Model->commit();
// 				break;
// 			case "2":
// 				//首先获取前后置任务列表
// 				$result=$this->getLinkWork($linkInfo['link']);
// 				//对$linkInfo['pro']做专置为数组
// 				//初始化一个空数组
// 				$successoridArr=array();
// 				$successoridArr=explode(',',$linkInfo['link']);
// 				$data=array();
// 				//执行事务
// 				$Model->startTrans();
// 				foreach ($successoridArr as $key => $val){
// 					//新数据的插入
// 					$data[$key]['id']=$linkInfo['id'];
// 					$data[$key]['successorid']=$val;
// 					$data[$key]['projectid']=$projectid;
// 					//如果存在节点
// 					if(!empty($result)){
// 						//如果有前置节点，替换前置节点
// 						foreach($result as $subkey=>$subval){
// 							if($subval[id]==$val){
// 								$data[$key]['predecessorid']=$subval['predecessorid'];
// 							}else{
// 								$data[$key]['predecessorid']=0;
// 							}
// 							//更新原节点的前置节点
// 							$map=array();
// 							$map['id']=$subval['id'];
// 							//重新设置successorid值
// 							$Model->where($map)->setField('predecessorid',$linkInfo['id']);
// 							//将前置节点为原节点值的节点更新为最新添加节点
// 							$map=array();
// 							$map['successorid']=$subval['id'];
// 							$Model->where($map)->setField('successorid',$linkInfo['id']);
// 						}
// 					}else{
// 						//如果不存在节点
// 						//后置节点数据的插入
// 						foreach ($successoridArr as $key=> $val){
// 							$dataPre[$key]['id']=$val;
// 							$dataPre[$key]['successorid']=$linkInfo['id'];
// 							$dataPre[$key]['projectid']=$projectid;
// 						}
// 						$Model->addAll($dataPre);
// 					}
// 				}
// 				//插入数据
// 				$Model->addAll($data);
// 				//提交事务
// 				$Model->commit();
// 				break;
// 				//修改只考虑前置任务  microsoft里面没有改变前置任务的功能，此处代码只做备用
// 			case "3":
// 				//首先获取前后置任务列表
// 				$result=$this->getLinkWork($linkInfo['id']);
// 				//与当前数组做比较，获取差异数组
// 				//更新前置节点
// 				$map=array();
// 				$map['id']=$predecessorid;
// 				//执行事务
// 				$Model->startTrans();
// 				//重新设置predecessorid值
// 				$Model->where($map)->setField('predecessorid',$id);
// 				//更新后置节点
// 				$map=array();
// 				$map['predecessorid']=$predecessorid;
// 				//重新设置predecessorid值
// 				$Model->where($map)->setField('predecessorid',$id);
// 				//提交事务
// 				$Model->commit();
// 				break;
// 				//删除某个节点，以下完全参照microsoft project管理
// 			case "4":
// 				$map=array();
// 				$result=$this->getLinkWork($linkInfo['id']);
// 				//执行事务
// 				$Model->startTrans();
// 				if(count($result)>1){
// 					foreach($result as $key =>$val){
// 						//清空前置节点的后置节点值
// 						$map=array();
// 						$map['id']=$val['predecessorid'];
// 						$Model->where($map)->setField('successorid',0);
// 						//清空后置节点的前置节点值
// 						$map=array();
// 						$map['id']=$val['successorid'];
// 						$Model->where($map)->setField('predecessorid',0);
// 					}
	
// 				}else{
// 					//如果只有一条关联记录，就顺延
// 					foreach ($result as $key => $val){
// 						//清空前置节点的后置节点值
// 						$map=array();
// 						$map['id']=$val['predecessorid'];
// 						$Model->where($map)->setField('successorid',$val['successorid']);
// 						//清空后置节点的前置节点值
// 						$map=array();
// 						$map['id']=$val['successorid'];
// 						$Model->where($map)->setField('predecessorid',$val['predecessorid']);
// 					}
// 				}
// 				//删除掉当前数组记录
// 				$map=array();
// 				$map['id']=$linkInfo['id'];
// 				$Model->where($map)->delete();
// 				//提交事务
// 				$Model->commit();
// 				break;
// 		}
/*****************************以上按标准任务处理，不实用，暂留存底******************************/
	}
	
	/**
	 * @Title: getLinkWork
	 * @Description: todo(获取任务的前置任务)
	 * @param id 代表当前任务id
	 * @param type  1.标准，只要查询前后置任务及状态   2.获取前置任务是否全部完成 ，返回true or false
	 * @param model 代表当前model
	 * @author yangxi
	 * @date 2014-10-21 上午11:00:00
	 * @throws
	 */
	function getLinkWork($id,$type=1,$projectid=0){		
		if($type == 1){
			$map=array();
			if($projectid){
			$map['mis_project_flow_link.projectid']=$projectid;
			$map['mis_project_flow_link.id']=$id;
			$mpflView=D('MisProjectFlowLinkView');
		    $result=$mpflView->where($map)->select();
			    if( false!==$result){	
			    	return $result;
				}else{	
					
				}
			}
		}
		if($type == 2){
		    $map=array();
			if ($projectid) {
				$map['projectid'] = $projectid;
			} else {
				return false;
			}
			$map['id'] = $id;
			$predecessorid=$this->where($map)->getField('predecessorid');
			//有前置任务，继续深入判断
			if ($predecessorid) {
			$predecessorArr= explode(",", $predecessorid); 
			    $complete=true;//放置一个初始标示值
				foreach ( $predecessorArr as $key => $val ) {
					if (getFieldBy($val, 'id', 'complete', 'mis_project_flow_form')==0) {
						return false;
					}
				}
				if($complete)return true;
			} else {
				//无前置任务，直接返回完成
				return true;
			}
		}	
	}
}
?>